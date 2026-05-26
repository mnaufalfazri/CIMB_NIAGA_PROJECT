<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\WealthService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private readonly WealthService $wealthService
    ) {}

    /**
     * SRS-BNK-001: Dashboard Saldo
     * Display real-time balance, monthly income, and expense.
     */
    public function index(Request $request): Response
    {
        $userId = $request->user()->id;
        $data   = $this->wealthService->getDashboardData($userId);

        return Inertia::render('wealth/dashboard', [
            'account'             => $data['account'],
            'totalBalance'        => $data['total_balance'],
            'incomeThisMonth'     => $data['income_this_month'],
            'expenseThisMonth'    => $data['expense_this_month'],
            'recentTransactions'  => $data['recent_transactions'] ?? [],
        ]);
    }
}
