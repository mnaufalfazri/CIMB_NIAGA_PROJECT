<?php

namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Services\BankingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TransferController extends Controller
{
    protected $bankingService;

    public function __construct(BankingService $bankingService)
    {
        $this->bankingService = $bankingService;
    }

    public function create()
    {
        return Inertia::render('transfer/create');
    }

    public function validateAccount(Request $request)
    {
        $request->validate(['nomor_rekening' => 'required|string|size:13']);
        $result = $this->bankingService->validateAccount($request->nomor_rekening);
        if ($result && $result['exists']) {
            return response()->json($result);
        }
        return response()->json(['exists' => false, 'message' => 'Rekening tidak ditemukan'], 404);
    }

    public function confirm(Request $request)
    {
        // FIX #3: bank_tujuan wajib diisi untuk transfer inter-bank
        $request->validate([
            'transfer_type'           => 'required|in:intra_bank,inter_bank_bifast',
            'bank_tujuan'             => 'required_if:transfer_type,inter_bank_bifast|nullable|string',
            'receiver_nomor_rekening' => 'required|string|size:13',
            'receiver_name'           => 'required|string',
            'amount'                  => 'required|numeric|min:10000',
            'description'             => 'nullable|string|max:255',
        ]);

        $fee = $request->transfer_type === 'inter_bank_bifast' ? 2500 : 0;

        return Inertia::render('transfer/confirm', [
            'data'  => $request->all(),
            'fee'   => $fee,
            'total' => $request->amount + $fee,
        ]);
    }

    public function execute(Request $request)
    {
        // FIX #3: Validate bank_tujuan on execute as well
        $request->validate([
            'transfer_type'           => 'required|in:intra_bank,inter_bank_bifast',
            'bank_tujuan'             => 'required_if:transfer_type,inter_bank_bifast|nullable|string',
            'receiver_nomor_rekening' => 'required|string|size:13',
            'receiver_name'           => 'required|string',
            'amount'                  => 'required|numeric|min:10000',
            'fee'                     => 'required|numeric|min:0',
        ]);

        $user        = session('user');
        $amount      = (float) $request->amount;
        $fee         = (float) $request->fee;
        $totalDebit  = $amount + $fee;

        // Check balance first
        $balanceData = $this->bankingService->checkBalance($user['nomor_rekening']);
        if (!$balanceData || $balanceData['balance'] < $totalDebit) {
            return redirect()->route('transfer.create')->with('error', 'Saldo tidak mencukupi');
        }

        $referenceId       = 'TRF-' . now()->format('YmdHis') . '-' . rand(1000, 9999);
        $transferTypeLabel = $request->transfer_type === 'intra_bank' ? 'Intra' : 'Inter';

        // FIX #2: Debit only the transfer amount (not bundled with fee)
        $debitResult = $this->bankingService->debit([
            'nomor_rekening'   => $user['nomor_rekening'],
            'amount'           => $amount,
            'reference_id'     => $referenceId . '-DB',
            'transaction_type' => 'transfer',
            'description'      => 'Transfer ' . $transferTypeLabel . ' Bank ke ' . $request->receiver_name,
        ]);

        if (!$debitResult['success']) {
            return redirect()->route('transfer.create')->with('error', 'Gagal memotong saldo: ' . $debitResult['message']);
        }

        // FIX #2: Debit fee separately as its own admin_fee transaction (only when fee > 0)
        if ($fee > 0) {
            $feeDebitResult = $this->bankingService->debit([
                'nomor_rekening'   => $user['nomor_rekening'],
                'amount'           => $fee,
                'reference_id'     => $referenceId . '-FEE',
                'transaction_type' => 'admin_fee',
                'description'      => 'Biaya Transfer ' . $transferTypeLabel . ' Bank (BIFAST)',
            ]);

            if (!$feeDebitResult['success']) {
                // Rollback the main transfer debit before returning error
                $this->bankingService->credit([
                    'nomor_rekening'       => $user['nomor_rekening'],
                    'amount'               => $amount,
                    'reference_id'         => $referenceId . '-RB-DB',
                    'description'          => 'Rollback transfer — gagal memotong biaya',
                    'counterparty_account' => 'SYSTEM',
                    'counterparty_name'    => 'SYSTEM',
                ]);

                Transfer::create([
                    'sender_nomor_rekening'   => $user['nomor_rekening'],
                    'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
                    'receiver_name'           => $request->receiver_name,
                    'amount'                  => $amount,
                    'fee'                     => $fee,
                    'transfer_type'           => $request->transfer_type,
                    'status'                  => 'failed',
                    'description'             => $request->description,
                    'reference_id'            => $referenceId,
                ]);

                return redirect()->route('transfer.create')->with('error', 'Gagal memotong biaya transfer: ' . $feeDebitResult['message']);
            }
        }

        if ($request->transfer_type === 'inter_bank_bifast') {
            // FIX #1: Wrap BIFAST simulation in try-catch with full rollback on failure
            try {
                // Simulate BIFAST network processing delay (2–3 seconds).
                // In a real system this would call the BI-FAST API.
                // No internal credit is needed: the money exits to the external bank network.
                sleep(rand(2, 3));
            } catch (\Exception $e) {
                // FIX #1: Rollback both transfer debit AND fee debit
                $this->bankingService->credit([
                    'nomor_rekening'       => $user['nomor_rekening'],
                    'amount'               => $totalDebit,
                    'reference_id'         => $referenceId . '-RB',
                    'description'          => 'Rollback transfer inter-bank gagal',
                    'counterparty_account' => 'SYSTEM',
                    'counterparty_name'    => 'SYSTEM',
                ]);

                Transfer::create([
                    'sender_nomor_rekening'   => $user['nomor_rekening'],
                    'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
                    'receiver_name'           => $request->receiver_name,
                    'amount'                  => $amount,
                    'fee'                     => $fee,
                    'transfer_type'           => $request->transfer_type,
                    'status'                  => 'failed',
                    'description'             => $request->description,
                    'reference_id'            => $referenceId,
                ]);

                return redirect()->route('transfer.create')->with('error', 'Transfer inter-bank gagal, saldo dikembalikan.');
            }
        } else {
            // Credit receiver (Intra bank only)
            $creditResult = $this->bankingService->credit([
                'nomor_rekening'       => $request->receiver_nomor_rekening,
                'amount'               => $amount,
                'reference_id'         => $referenceId . '-CR',
                'transaction_type'     => 'transfer',
                'description'          => 'Transfer masuk dari ' . $user['name'],
                'counterparty_account' => $user['nomor_rekening'],
                'counterparty_name'    => $user['name'],
            ]);

            if (!$creditResult['success']) {
                // Rollback: return amount + fee to sender
                $this->bankingService->credit([
                    'nomor_rekening'       => $user['nomor_rekening'],
                    'amount'               => $totalDebit,
                    'reference_id'         => $referenceId . '-RB',
                    'description'          => 'Rollback transfer gagal — saldo dikembalikan',
                    'counterparty_account' => 'SYSTEM',
                    'counterparty_name'    => 'SYSTEM',
                ]);

                Transfer::create([
                    'sender_nomor_rekening'   => $user['nomor_rekening'],
                    'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
                    'receiver_name'           => $request->receiver_name,
                    'amount'                  => $amount,
                    'fee'                     => $fee,
                    'transfer_type'           => $request->transfer_type,
                    'status'                  => 'failed',
                    'description'             => $request->description,
                    'reference_id'            => $referenceId,
                ]);

                return redirect()->route('transfer.create')->with('error', 'Transfer gagal, saldo dikembalikan. Pesan: ' . $creditResult['message']);
            }
        }

        $transfer = Transfer::create([
            'sender_nomor_rekening'   => $user['nomor_rekening'],
            'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
            'receiver_name'           => $request->receiver_name,
            'amount'                  => $amount,
            'fee'                     => $fee,
            'transfer_type'           => $request->transfer_type,
            'status'                  => 'completed',
            'description'             => $request->description,
            'reference_id'            => $referenceId,
        ]);

        return redirect()->route('transfer.receipt', $transfer->id)->with('success', 'Transfer Berhasil');
    }

    public function receipt($id)
    {
        $transfer = Transfer::findOrFail($id);
        if ($transfer->sender_nomor_rekening !== session('user')['nomor_rekening']) {
            abort(403);
        }
        return Inertia::render('transfer/receipt', ['transfer' => $transfer]);
    }

    public function history(Request $request)
    {
        $query = Transfer::where('sender_nomor_rekening', session('user')['nomor_rekening']);

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('transfer_type', $request->type);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $transfers = $query->latest()->paginate(15);
        return Inertia::render('transfer/history', ['transfers' => $transfers]);
    }
}
