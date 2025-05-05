<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeEducationRequest extends FormRequest
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
            'id' => [
                'required', 'uuid',
                'unique:employee_education,id',
            ],
            'employee_id' => [
                'required', 'string',
                'exists:employees,id'
            ],
            'level' => [
                'required', 'string',
                'in:sd,smp,sma,s1,s2,s3'
            ],
            'school_name' => [
                'required', 'string', 'max:255'
            ],
            'major' => [
                'nullable', 'string', 'max:255'
            ],
            'school_address' => [
                'required', 'string', 'max:65535'
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
            'id' => 'ID',
            'level' => 'Jenjang',
            'school_name' => 'Nama Sekolah/Kampus',
            'major' => 'Jurusan',
            'school_address' => 'Alamat Sekolah/Kampus'
        ];
    }
}
