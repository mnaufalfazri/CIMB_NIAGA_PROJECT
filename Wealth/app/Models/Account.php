<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'nomor_rekening',
        'account_type',
        'currency',
        'balance',
        'status',
        'version',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'version' => 'integer',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function balanceLogs(): HasMany
    {
        return $this->hasMany(AccountBalanceLog::class);
    }

    /**
     * Get the account type label in Indonesian.
     */
    public function getAccountTypeLabelAttribute(): string
    {
        return match ($this->account_type) {
            'saving'   => 'Tabungan',
            'business' => 'Bisnis',
            'deposit'  => 'Deposito',
            default    => ucfirst($this->account_type),
        };
    }

    /**
     * Get the status label in Indonesian.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active' => 'Aktif',
            'frozen' => 'Dibekukan',
            'closed' => 'Ditutup',
            default  => ucfirst($this->status),
        };
    }
}
