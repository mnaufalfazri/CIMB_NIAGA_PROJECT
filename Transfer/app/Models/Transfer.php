<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'sender_nomor_rekening',
        'receiver_nomor_rekening',
        'receiver_name',
        'amount',
        'fee',
        'transfer_type',
        'status',
        'description',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'fee' => 'decimal:2',
        ];
    }
}
