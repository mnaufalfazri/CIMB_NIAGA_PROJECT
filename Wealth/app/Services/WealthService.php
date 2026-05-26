<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountBalanceLog;
use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WealthService
{
    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-001: Dashboard Data
    // ─────────────────────────────────────────────────────────────

    /**
     * Get dashboard data for authenticated user.
     */
    public function getDashboardData(int $userId): array
    {
        $account = Account::where('user_id', $userId)->first();

        if (! $account) {
            return [
                'account'           => null,
                'total_balance'     => 0,
                'income_this_month' => 0,
                'expense_this_month' => 0,
            ];
        }

        $now = now();

        $incomeThisMonth = Transaction::where('account_id', $account->id)
            ->where('direction', 'credit')
            ->where('status', 'success')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('amount');

        $expenseThisMonth = Transaction::where('account_id', $account->id)
            ->where('direction', 'debit')
            ->where('status', 'success')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('amount');

        // Recent transactions for mini-history on dashboard
        $recentTransactions = Transaction::where('account_id', $account->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return [
            'account'             => $account,
            'total_balance'       => (float) $account->balance,
            'income_this_month'   => (float) $incomeThisMonth,
            'expense_this_month'  => (float) $expenseThisMonth,
            'recent_transactions' => $recentTransactions,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-002: Mutasi Rekening
    // ─────────────────────────────────────────────────────────────

    /**
     * Get paginated transaction history with filters.
     */
    public function getMutasi(int $accountId, array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return Transaction::where('account_id', $accountId)
            ->filterByDate($filters['date_from'] ?? null, $filters['date_to'] ?? null)
            ->filterByType($filters['transaction_type'] ?? null)
            ->filterByDirection($filters['direction'] ?? null)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-003: Auto-Create Account
    // ─────────────────────────────────────────────────────────────

    /**
     * Create a new account when Registration Service approves a user.
     */
    public function createAccountForUser(array $data): Account
    {
        return DB::transaction(function () use ($data) {
            $account = Account::create([
                'user_id'      => $data['user_id'],
                'user_name'    => $data['user_name'] ?? null,
                'nomor_rekening' => $data['nomor_rekening'] ?? $this->generateNomorRekening(),
                'account_type' => $data['account_type'] ?? 'saving',
                'currency'     => 'IDR',
                'balance'      => 1000000.00,
                'status'       => 'active',
                'version'      => 0,
            ]);

            // Record initial balance transaction
            $referenceId = 'INIT-' . strtoupper(Str::random(10));

            Transaction::create([
                'account_id'       => $account->id,
                'reference_id'     => $referenceId,
                'direction'        => 'credit',
                'transaction_type' => 'initial',
                'amount'           => 1000000.00,
                'balance_before'   => 0.00,
                'balance_after'    => 1000000.00,
                'status'           => 'success',
                'description'      => 'Saldo awal pembukaan rekening',
                'created_at'       => now(),
            ]);

            AccountBalanceLog::create([
                'account_id'   => $account->id,
                'old_balance'  => 0.00,
                'new_balance'  => 1000000.00,
                'reference_id' => $referenceId,
                'action_type'  => 'credit',
                'created_at'   => now(),
            ]);

            return $account;
        });
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-004: Check Balance
    // ─────────────────────────────────────────────────────────────

    /**
     * Get balance for a given account number.
     */
    public function checkBalance(string $nomorRekening): ?array
    {
        $account = Account::where('nomor_rekening', $nomorRekening)
            ->where('status', 'active')
            ->first();

        if (! $account) {
            return null;
        }

        return [
            'nomor_rekening' => $account->nomor_rekening,
            'balance'        => (float) $account->balance,
            'currency'       => $account->currency,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-005: Validate Account
    // ─────────────────────────────────────────────────────────────

    /**
     * Validate existence of an account by nomor rekening.
     */
    public function validateAccount(string $nomorRekening): array
    {
        $account = Account::where('nomor_rekening', $nomorRekening)->first();

        if (! $account) {
            return ['exists' => false, 'name' => null, 'nomor_rekening' => $nomorRekening];
        }

        return [
            'exists'         => true,
            'name'           => $account->user_name,
            'nomor_rekening' => $account->nomor_rekening,
            'status'         => $account->status,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-006: Debit Account
    // ─────────────────────────────────────────────────────────────

    /**
     * Debit (reduce) balance from an account.
     *
     * @throws \Exception if insufficient balance or account not found/active
     */
    public function debitAccount(array $data): array
    {
        return DB::transaction(function () use ($data) {
            // Lock the row to prevent race conditions
            $account = Account::where('nomor_rekening', $data['nomor_rekening'])
                ->lockForUpdate()
                ->first();

            if (! $account) {
                throw new \Exception('Rekening tidak ditemukan.', 404);
            }

            if ($account->status !== 'active') {
                throw new \Exception('Rekening tidak aktif.', 422);
            }

            if ((float) $account->balance < (float) $data['amount']) {
                throw new \Exception('Saldo tidak mencukupi.', 400);
            }

            $balanceBefore = (float) $account->balance;
            $balanceAfter  = $balanceBefore - (float) $data['amount'];

            // Update balance with optimistic locking via version
            $account->update([
                'balance' => $balanceAfter,
                'version' => $account->version + 1,
            ]);

            Transaction::create([
                'account_id'       => $account->id,
                'reference_id'     => $data['reference_id'],
                'direction'        => 'debit',
                'transaction_type' => $data['transaction_type'] ?? 'transfer',
                'amount'           => $data['amount'],
                'balance_before'   => $balanceBefore,
                'balance_after'    => $balanceAfter,
                'status'           => 'success',
                'description'      => $data['description'] ?? null,
                'created_at'       => now(),
            ]);

            AccountBalanceLog::create([
                'account_id'   => $account->id,
                'old_balance'  => $balanceBefore,
                'new_balance'  => $balanceAfter,
                'reference_id' => $data['reference_id'],
                'action_type'  => 'debit',
                'created_at'   => now(),
            ]);

            return ['success' => true, 'balance_after' => $balanceAfter];
        });
    }

    // ─────────────────────────────────────────────────────────────
    // SRS-BNK-007: Credit Account
    // ─────────────────────────────────────────────────────────────

    /**
     * Credit (add) balance to an account.
     *
     * @throws \Exception if account not found or not active
     */
    public function creditAccount(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $account = Account::where('nomor_rekening', $data['nomor_rekening'])
                ->lockForUpdate()
                ->first();

            if (! $account) {
                throw new \Exception('Rekening tidak ditemukan.', 404);
            }

            if ($account->status !== 'active') {
                throw new \Exception('Rekening tidak aktif.', 422);
            }

            $balanceBefore = (float) $account->balance;
            $balanceAfter  = $balanceBefore + (float) $data['amount'];

            $account->update([
                'balance' => $balanceAfter,
                'version' => $account->version + 1,
            ]);

            Transaction::create([
                'account_id'          => $account->id,
                'reference_id'        => $data['reference_id'],
                'direction'           => 'credit',
                'transaction_type'    => $data['transaction_type'] ?? 'transfer',
                'amount'              => $data['amount'],
                'balance_before'      => $balanceBefore,
                'balance_after'       => $balanceAfter,
                'status'              => 'success',
                'description'         => $data['description'] ?? null,
                'counterparty_account' => $data['counterparty_account'] ?? null,
                'counterparty_name'   => $data['counterparty_name'] ?? null,
                'created_at'          => now(),
            ]);

            AccountBalanceLog::create([
                'account_id'   => $account->id,
                'old_balance'  => $balanceBefore,
                'new_balance'  => $balanceAfter,
                'reference_id' => $data['reference_id'],
                'action_type'  => 'credit',
                'created_at'   => now(),
            ]);

            return ['success' => true, 'balance_after' => $balanceAfter];
        });
    }

    // ─────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────

    /**
     * Generate a unique 13-digit account number.
     */
    private function generateNomorRekening(): string
    {
        do {
            // Format: 890 + 10 random digits (13 total)
            $nomor = '890' . str_pad((string) random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
        } while (Account::where('nomor_rekening', $nomor)->exists());

        return $nomor;
    }
}
