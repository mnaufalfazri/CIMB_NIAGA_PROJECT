<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nomor_rekening'      => ['required', 'string', 'size:13'],
            'amount'              => ['required', 'numeric', 'min:1'],
            'reference_id'        => ['required', 'string', 'max:50', 'unique:transactions,reference_id'],
            'description'         => ['nullable', 'string', 'max:255'],
            'counterparty_account' => ['nullable', 'string', 'max:13'],
            'counterparty_name'   => ['nullable', 'string', 'max:100'],
            'transaction_type'    => ['nullable', 'in:transfer,topup,deposit,refund,reversal'],
        ];
    }

    public function messages(): array
    {
        return [
            'nomor_rekening.required'  => 'Nomor rekening wajib diisi.',
            'nomor_rekening.size'      => 'Nomor rekening harus 13 digit.',
            'amount.required'          => 'Jumlah transaksi wajib diisi.',
            'amount.min'               => 'Jumlah transaksi minimal Rp 1.',
            'reference_id.required'    => 'Reference ID wajib diisi.',
            'reference_id.unique'      => 'Reference ID sudah digunakan.',
            'transaction_type.in'      => 'Tipe transaksi tidak valid.',
        ];
    }
}
