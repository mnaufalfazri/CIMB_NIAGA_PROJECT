<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MutasiFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date_from'        => ['nullable', 'date', 'before_or_equal:date_to'],
            'date_to'          => ['nullable', 'date', 'after_or_equal:date_from'],
            'transaction_type' => ['nullable', 'in:all,transfer,payment,topup,withdraw,deposit,admin_fee,initial,refund,reversal'],
            'direction'        => ['nullable', 'in:all,credit,debit'],
            'page'             => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_from.before_or_equal' => 'Tanggal mulai harus sebelum atau sama dengan tanggal selesai.',
            'date_to.after_or_equal'    => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'transaction_type.in'       => 'Tipe transaksi tidak valid.',
            'direction.in'              => 'Arah transaksi tidak valid.',
        ];
    }
}
