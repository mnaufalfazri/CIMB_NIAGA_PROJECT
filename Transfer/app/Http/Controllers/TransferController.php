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
        $request->validate([
            'transfer_type' => 'required|in:intra_bank,inter_bank_bifast',
            'receiver_nomor_rekening' => 'required|string|size:13',
            'receiver_name' => 'required|string',
            'amount' => 'required|numeric|min:10000',
            'description' => 'nullable|string|max:255',
        ]);

        $fee = $request->transfer_type === 'inter_bank_bifast' ? 2500 : 0;
        
        return Inertia::render('transfer/confirm', [
            'data' => $request->all(),
            'fee' => $fee,
            'total' => $request->amount + $fee
        ]);
    }

    public function execute(Request $request)
    {
        $user = session('user');
        $amount = (float) $request->amount;
        $fee = (float) $request->fee;
        $totalDebit = $amount + $fee;

        // Check balance first
        $balanceData = $this->bankingService->checkBalance($user['nomor_rekening']);
        if (!$balanceData || $balanceData['balance'] < $totalDebit) {
            return redirect()->route('transfer.create')->with('error', 'Saldo tidak mencukupi');
        }

        $referenceId = 'TRF-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

        // Debit sender
        $debitResult = $this->bankingService->debit([
            'nomor_rekening' => $user['nomor_rekening'],
            'amount' => $totalDebit,
            'reference_id' => $referenceId . '-DB',
            'description' => 'Transfer ' . ($request->transfer_type === 'intra_bank' ? 'Intra' : 'Inter') . ' Bank to ' . $request->receiver_name
        ]);

        if (!$debitResult['success']) {
            return redirect()->route('transfer.create')->with('error', 'Gagal memotong saldo: ' . $debitResult['message']);
        }

        if ($request->transfer_type === 'inter_bank_bifast') {
            sleep(rand(2, 3));
        } else {
            // Credit receiver (Intra bank)
            $creditResult = $this->bankingService->credit([
                'nomor_rekening' => $request->receiver_nomor_rekening,
                'amount' => $amount,
                'reference_id' => $referenceId . '-CR',
                'description' => 'Transfer in from ' . $user['name'],
                'counterparty_account' => $user['nomor_rekening'],
                'counterparty_name' => $user['name']
            ]);

            if (!$creditResult['success']) {
                // Rollback debit
                $this->bankingService->credit([
                    'nomor_rekening' => $user['nomor_rekening'],
                    'amount' => $totalDebit,
                    'reference_id' => $referenceId . '-RB',
                    'description' => 'Rollback transfer failed',
                    'counterparty_account' => 'SYSTEM',
                    'counterparty_name' => 'SYSTEM'
                ]);

                Transfer::create([
                    'sender_nomor_rekening' => $user['nomor_rekening'],
                    'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
                    'receiver_name' => $request->receiver_name,
                    'amount' => $amount,
                    'fee' => $fee,
                    'transfer_type' => $request->transfer_type,
                    'status' => 'failed',
                    'description' => $request->description,
                    'reference_id' => $referenceId,
                ]);

                return redirect()->route('transfer.create')->with('error', 'Transfer gagal, saldo dikembalikan. Pesan: ' . $creditResult['message']);
            }
        }

        $transfer = Transfer::create([
            'sender_nomor_rekening' => $user['nomor_rekening'],
            'receiver_nomor_rekening' => $request->receiver_nomor_rekening,
            'receiver_name' => $request->receiver_name,
            'amount' => $amount,
            'fee' => $fee,
            'transfer_type' => $request->transfer_type,
            'status' => 'completed',
            'description' => $request->description,
            'reference_id' => $referenceId,
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
