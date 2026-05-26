<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'nomor_rekening',
        'biller_category',
        'customer_number',
        'amount',
        'admin_fee',
        'status',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'admin_fee' => 'decimal:2',
        ];
    }
}
