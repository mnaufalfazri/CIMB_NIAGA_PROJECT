<?php

namespace App\Services;

class BillerService
{
    private static $mockBills = [
        'pln' => [
            '1234567890' => ['name' => 'Ahmad Sudrajat', 'amount' => 350000, 'period' => 'Mei 2026'],
            '0987654321' => ['name' => 'Siti Nurhaliza', 'amount' => 275000, 'period' => 'Mei 2026'],
            '1122334455' => ['name' => 'Budi Santoso', 'amount' => 420000, 'period' => 'Mei 2026'],
        ],
        'pdam' => [
            '5544332211' => ['name' => 'Dewi Lestari', 'amount' => 85000, 'period' => 'Mei 2026'],
            '6677889900' => ['name' => 'Rudi Hermawan', 'amount' => 120000, 'period' => 'Mei 2026'],
            '1122334455' => ['name' => 'Andi Wijaya', 'amount' => 95000, 'period' => 'Mei 2026'],
        ],
        'internet' => [
            'NET001234' => ['name' => 'Rina Marlina', 'amount' => 350000, 'period' => 'Mei 2026', 'package' => 'Unlimited 100Mbps'],
            'NET005678' => ['name' => 'Joko Susanto', 'amount' => 250000, 'period' => 'Mei 2026', 'package' => 'Unlimited 50Mbps'],
            'NET009012' => ['name' => 'Mega Wati', 'amount' => 450000, 'period' => 'Mei 2026', 'package' => 'Unlimited 200Mbps'],
        ],
    ];

    public static function getBillers(): array
    {
        return array_keys(self::$mockBills);
    }

    public static function lookupBill(string $category, string $customerNumber): ?array
    {
        if (isset(self::$mockBills[$category][$customerNumber])) {
            $bill = self::$mockBills[$category][$customerNumber];
            $bill['customer_number'] = $customerNumber;
            $bill['biller_category'] = $category;
            return $bill;
        }

        return null;
    }
}
