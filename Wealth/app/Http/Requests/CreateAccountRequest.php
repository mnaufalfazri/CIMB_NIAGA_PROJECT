<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id'        => ['required', 'integer', 'min:1'],
            'user_name'      => ['required', 'string', 'max:100'],
            'nomor_rekening' => ['nullable', 'string', 'size:13', 'unique:accounts,nomor_rekening'],
            'account_type'   => ['nullable', 'in:saving,business,deposit'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required'        => 'User ID wajib diisi.',
            'user_name.required'      => 'Nama nasabah wajib diisi.',
            'nomor_rekening.size'     => 'Nomor rekening harus 13 digit.',
            'nomor_rekening.unique'   => 'Nomor rekening sudah terdaftar.',
            'account_type.in'         => 'Tipe akun tidak valid.',
        ];
    }
}
