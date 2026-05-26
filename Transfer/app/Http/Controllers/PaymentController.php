<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\BankingService;
use App\Services\BillerService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    protected $bankingService;

    public function __construct(BankingService $bankingService)
    {
        $this->bankingService = $bankingService;
    }

    public function create()
    {
        return Inertia::render('payment/create');
    }

    public function checkBill(Request $request)
    {
        $request->validate([
            'biller_category' => 'required|in:pln,pdam,internet',
            'customer_number' => 'required|string',
        ]);

        $bill = BillerService::lookupBill($request->biller_category, $request->customer_number);

        if ($bill) {
            return response()->json($bill);
        }

        return response()->json(['message' => 'Tagihan tidak ditemukan'], 404);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'biller_category' => 'required|in:pln,pdam,internet',
            'customer_number' => 'required|string',
            'amount' => 'required|numeric',
            'name' => 'required|string',
            'period' => 'required|string',
        ]);

        return Inertia::render('payment/confirm', [
            'data' => $request->all(),
            'admin_fee' => 2500,
            'total' => $request->amount + 2500
        ]);
    }

    public function execute(Request $request)
    {
        $user = session('user');
        $amount = (float) $request->amount;
        $adminFee = 2500;
        $totalDebit = $amount + $adminFee;

        // Check balance
        $balanceData = $this->bankingService->checkBalance($user['nomor_rekening']);
        if (!$balanceData || $balanceData['balance'] < $totalDebit) {
            return redirect()->route('payment.create')->with('error', 'Saldo tidak mencukupi');
        }

        $referenceId = 'PAY-' . now()->format('YmdHis') . '-' . rand(1000, 9999);

        // Debit account
        $debitResult = $this->bankingService->debit([
            'nomor_rekening' => $user['nomor_rekening'],
            'amount' => $totalDebit,
            'reference_id' => $referenceId . '-DB',
            'description' => 'Pembayaran ' . strtoupper($request->biller_category) . ' ' . $request->customer_number
        ]);

        if (!$debitResult['success']) {
            return redirect()->route('payment.create')->with('error', 'Pembayaran gagal: ' . $debitResult['message']);
        }

        $payment = Payment::create([
            'nomor_rekening' => $user['nomor_rekening'],
            'biller_category' => $request->biller_category,
            'customer_number' => $request->customer_number,
            'amount' => $amount,
            'admin_fee' => $adminFee,
            'status' => 'completed',
            'reference_id' => $referenceId,
        ]);

        return redirect()->route('payment.receipt', $payment->id)->with('success', 'Pembayaran Berhasil');
    }

    public function receipt($id)
    {
        $payment = Payment::findOrFail($id);
        if ($payment->nomor_rekening !== session('user')['nomor_rekening']) {
            abort(403);
        }
        return Inertia::render('payment/receipt', ['payment' => $payment]);
    }

    public function history(Request $request)
    {
        $payments = Payment::where('nomor_rekening', session('user')['nomor_rekening'])
            ->latest()
            ->paginate(15);
            
        return Inertia::render('payment/history', ['payments' => $payments]);
    }
}
