<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountBalanceLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WealthSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Budi Santoso
        $user1 = User::firstOrCreate(
            ['email' => 'budi@cimb.com'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password'),
            ]
        );

        $account1 = Account::firstOrCreate(
            ['user_id' => $user1->id],
            [
                'user_name'      => $user1->name,
                'nomor_rekening' => '8901234567890',
                'account_type'   => 'saving',
                'currency'       => 'IDR',
                'balance'        => 1000000.00,
                'status'         => 'active',
                'version'        => 0,
            ]
        );
        $this->seedTransactions($account1);

        // 2. Seed Nasabah (from Login UserSeeder)
        $user2 = User::firstOrCreate(
            ['email' => 'nasabah@gmail.com'],
            [
                'id' => 2,
                'name' => 'nasabah',
                'password' => bcrypt('nasabah'),
            ]
        );

        $account2 = Account::firstOrCreate(
            ['user_id' => $user2->id],
            [
                'user_name'      => $user2->name,
                'nomor_rekening' => '0000000000002',
                'account_type'   => 'saving',
                'currency'       => 'IDR',
                'balance'        => 1000000.00,
                'status'         => 'active',
                'version'        => 0,
            ]
        );
        $this->seedTransactions($account2);

        // 3. Seed Sachras (from Login UserSeeder)
        $user3 = User::firstOrCreate(
            ['email' => 'sachras@gmail.com'],
            [
                'id' => 3,
                'name' => 'sachras',
                'password' => bcrypt('sachras'),
            ]
        );

        $account3 = Account::firstOrCreate(
            ['user_id' => $user3->id],
            [
                'user_name'      => $user3->name,
                'nomor_rekening' => '0000000000003',
                'account_type'   => 'saving',
                'currency'       => 'IDR',
                'balance'        => 1000000.00,
                'status'         => 'active',
                'version'        => 0,
            ]
        );
        $this->seedTransactions($account3);

        $this->command->info("✅ WealthSeeder selesai. Seeded Budi, nasabah, and sachras.");
    }

    private function seedTransactions(Account $account): void
    {
        $now     = now();
        $balance = 1000000.00;

        $samples = [
            // Initial
            ['dir' => 'credit', 'type' => 'initial',  'amount' => 1000000, 'desc' => 'Saldo awal pembukaan rekening',     'months_ago' => 6],

            // Month -5
            ['dir' => 'credit', 'type' => 'topup',    'amount' => 5000000, 'desc' => 'Top up via ATM',                   'months_ago' => 5],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 350000,  'desc' => 'Pembayaran BPJS Kesehatan',         'months_ago' => 5],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 150000,  'desc' => 'Pembayaran Listrik PLN',            'months_ago' => 5],

            // Month -4
            ['dir' => 'credit', 'type' => 'transfer', 'amount' => 3000000, 'desc' => 'Transfer masuk dari rekening lain', 'months_ago' => 4, 'cp_account' => '8909876543210', 'cp_name' => 'Ani Rahayu'],
            ['dir' => 'debit',  'type' => 'transfer', 'amount' => 1500000, 'desc' => 'Transfer ke rekening tujuan',       'months_ago' => 4],
            ['dir' => 'debit',  'type' => 'withdraw',  'amount' => 500000,  'desc' => 'Penarikan tunai ATM',              'months_ago' => 4],

            // Month -3
            ['dir' => 'credit', 'type' => 'topup',    'amount' => 2000000, 'desc' => 'Top up via mobile banking',        'months_ago' => 3],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 89000,   'desc' => 'Pembayaran Netflix',               'months_ago' => 3],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 250000,  'desc' => 'Pembayaran Telkomsel',             'months_ago' => 3],
            ['dir' => 'debit',  'type' => 'admin_fee', 'amount' => 15000,  'desc' => 'Biaya administrasi bulanan',       'months_ago' => 3],

            // Month -2
            ['dir' => 'credit', 'type' => 'transfer', 'amount' => 7500000, 'desc' => 'Gaji bulan ini',                   'months_ago' => 2, 'cp_account' => '8901111111111', 'cp_name' => 'PT Maju Bersama'],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 1200000, 'desc' => 'Pembayaran kartu kredit',          'months_ago' => 2],
            ['dir' => 'debit',  'type' => 'transfer', 'amount' => 2000000, 'desc' => 'Kirim uang ke orang tua',          'months_ago' => 2],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 450000,  'desc' => 'Belanja online Shopee',            'months_ago' => 2],

            // Month -1
            ['dir' => 'credit', 'type' => 'transfer', 'amount' => 7500000, 'desc' => 'Gaji bulan ini',                   'months_ago' => 1, 'cp_account' => '8901111111111', 'cp_name' => 'PT Maju Bersama'],
            ['dir' => 'credit', 'type' => 'refund',   'amount' => 450000,  'desc' => 'Refund pembelian Shopee',          'months_ago' => 1, 'cp_account' => '8909999999999', 'cp_name' => 'Shopee Indonesia'],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 350000,  'desc' => 'Pembayaran BPJS Kesehatan',        'months_ago' => 1],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 150000,  'desc' => 'Pembayaran Listrik PLN',           'months_ago' => 1],
            ['dir' => 'debit',  'type' => 'admin_fee', 'amount' => 15000,  'desc' => 'Biaya administrasi bulanan',      'months_ago' => 1],

            // This month
            ['dir' => 'credit', 'type' => 'transfer', 'amount' => 7500000, 'desc' => 'Gaji bulan ini',                   'months_ago' => 0, 'cp_account' => '8901111111111', 'cp_name' => 'PT Maju Bersama'],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 89000,   'desc' => 'Pembayaran Netflix',               'months_ago' => 0],
            ['dir' => 'debit',  'type' => 'payment',  'amount' => 250000,  'desc' => 'Pembayaran Telkomsel',             'months_ago' => 0],
            ['dir' => 'debit',  'type' => 'transfer', 'amount' => 500000,  'desc' => 'Kirim uang ke teman',             'months_ago' => 0],
            ['dir' => 'credit', 'type' => 'topup',    'amount' => 1000000, 'desc' => 'Top up saldo via ATM',             'months_ago' => 0],
        ];

        // Delete existing seeded transactions to avoid duplicates
        Transaction::where('account_id', $account->id)->delete();
        AccountBalanceLog::where('account_id', $account->id)->delete();

        $balance = 0.00;

        foreach ($samples as $i => $s) {
            $date = $now->copy()->subMonths($s['months_ago'])->startOfMonth()->addDays(rand(1, 20));

            $balanceBefore = $balance;

            if ($s['dir'] === 'credit') {
                $balance += $s['amount'];
            } else {
                $balance = max(0, $balance - $s['amount']);
            }

            $balanceAfter = $balance;

            $tx = Transaction::create([
                'account_id'          => $account->id,
                'reference_id'        => 'SEED-' . strtoupper(Str::random(8)) . '-' . $i,
                'direction'           => $s['dir'],
                'transaction_type'    => $s['type'],
                'amount'              => $s['amount'],
                'balance_before'      => $balanceBefore,
                'balance_after'       => $balanceAfter,
                'status'              => 'success',
                'description'         => $s['desc'],
                'counterparty_account' => $s['cp_account'] ?? null,
                'counterparty_name'   => $s['cp_name'] ?? null,
                'created_at'          => $date,
            ]);

            AccountBalanceLog::create([
                'account_id'   => $account->id,
                'old_balance'  => $balanceBefore,
                'new_balance'  => $balanceAfter,
                'reference_id' => $tx->reference_id,
                'action_type'  => $s['dir'],
                'created_at'   => $date,
            ]);
        }

        // Update account balance to final computed balance
        $account->update(['balance' => $balance, 'version' => count($samples)]);
    }
}
