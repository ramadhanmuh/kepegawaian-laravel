<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string',
                'max:255',
            ],
            'email' => [
                'required', 'email',
                'max:255', 'unique:users,email'
            ],
            'password' => [
                'required', 'string',
            ],
            'phone' => [
                'required', 'string',
                'unique:users,phone'
            ],
            'role' => [
                'required', 'string',
                'in:admin,super_admin'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'phone' => 'Nomor Telepon Genggam',
            'role' => 'Jenis'
        ];
    }
}
