<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTerminationRequest extends FormRequest
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
                'unique:terminations,id'
            ],
            'employee_id' => [
                'required', 'string',
                'exists:employees,id',
                'unique:terminations,employee_id'
            ],
            'termination_type_id' => [
                'required', 'string',
                'exists:termination_types,id',
            ],
            'subject' => [
                'required', 'string',
                'max:255'
            ],
            'notice_date' => [
                'required',
                Rule::date()->format('Y-m-d')
            ],
            'termination_date' => [
                'required',
                Rule::date()->format('Y-m-d'),
                'after_or_equal:notice_date'
            ],
            'description' => [
                'required', 'string',
                'max:65535'
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
            'employee_id' => 'Pegawai',
            'termination_type_id' => 'Jenis Pemberhentian',
            'subject' => 'Subyek',
            'notice_date' => 'Tanggal Pemberitahuan',
            'termination_date' => 'Tanggal Pemberhentian Kerja',
            'description' => 'Deskripsi'
        ];
    }
}
