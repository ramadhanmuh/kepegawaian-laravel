<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
                'required', 'string', 'max:255'
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'phone' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'current_password' => [
                'required', 'string', 'current_password'
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
            'email' => 'Email',
            'name' => 'Nama',
            'phone' => 'Nomor Telepon Genggam',
            'current_password' => 'Kata Sandi Saat Ini'
        ];
    }
}
