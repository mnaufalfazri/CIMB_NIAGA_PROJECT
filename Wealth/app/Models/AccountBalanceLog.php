<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountBalanceLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'old_balance',
        'new_balance',
        'reference_id',
        'action_type',
        'created_at',
    ];

    protected $casts = [
        'old_balance' => 'decimal:2',
        'new_balance' => 'decimal:2',
        'created_at'  => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
