<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'reference_id',
        'direction',
        'transaction_type',
        'amount',
        'balance_before',
        'balance_after',
        'status',
        'description',
        'counterparty_account',
        'counterparty_name',
        'created_at',
    ];

    protected $casts = [
        'amount'         => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after'  => 'decimal:2',
        'created_at'     => 'datetime',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Scope: filter by date range.
     */
    public function scopeFilterByDate(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return $query;
    }

    /**
     * Scope: filter by transaction type.
     */
    public function scopeFilterByType(Builder $query, ?string $type): Builder
    {
        if ($type && $type !== 'all') {
            $query->where('transaction_type', $type);
        }

        return $query;
    }

    /**
     * Scope: filter by direction (credit/debit).
     */
    public function scopeFilterByDirection(Builder $query, ?string $direction): Builder
    {
        if ($direction && $direction !== 'all') {
            $query->where('direction', $direction);
        }

        return $query;
    }

    /**
     * Get human-readable transaction type label.
     */
    public function getTransactionTypeLabelAttribute(): string
    {
        return match ($this->transaction_type) {
            'transfer'  => 'Transfer',
            'payment'   => 'Pembayaran',
            'topup'     => 'Top Up',
            'withdraw'  => 'Penarikan',
            'deposit'   => 'Setoran',
            'admin_fee' => 'Biaya Admin',
            'initial'   => 'Saldo Awal',
            'refund'    => 'Refund',
            'reversal'  => 'Reversal',
            default     => ucfirst($this->transaction_type),
        };
    }
}
