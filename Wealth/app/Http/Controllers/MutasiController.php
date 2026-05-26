<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\MutasiFilterRequest;
use App\Services\WealthService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MutasiController extends Controller
{
    public function __construct(
        private readonly WealthService $wealthService
    ) {}

    /**
     * SRS-BNK-002: Mutasi Rekening
     * Show paginated transaction history with filters.
     */
    public function index(MutasiFilterRequest $request): Response
    {
        $userId  = $request->user()->id;
        $account = Account::where('user_id', $userId)->first();

        $transactions = null;

        if ($account) {
            $filters = $request->only([
                'date_from',
                'date_to',
                'transaction_type',
                'direction',
            ]);

            $transactions = $this->wealthService->getMutasi(
                accountId: $account->id,
                filters: $filters,
                perPage: 15
            );
        }

        return Inertia::render('wealth/mutasi', [
            'account'      => $account,
            'transactions' => $transactions,
            'filters'      => $request->only(['date_from', 'date_to', 'transaction_type', 'direction']),
        ]);
    }
}
