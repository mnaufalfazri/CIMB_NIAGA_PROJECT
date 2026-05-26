<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedTransaction extends Model
{
    protected $fillable = [
        'reference_id',
        'payload',
        'error_message',
        'retry_count',
        'status',
    ];

    protected $casts = [
        'payload'     => 'array',
        'retry_count' => 'integer',
    ];
}
