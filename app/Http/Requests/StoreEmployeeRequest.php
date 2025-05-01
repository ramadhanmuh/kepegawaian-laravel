<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
                'required', 'uuid', 'unique:employees,id'
            ],
            'full_name' => [
                'required', 'string', 'max:255'
            ],
            'number' => [
                'required', 'string', 'max:255',
                'unique:employees,number'
            ],
            'designation_id' => [
                'required', 'string', 'exists:designations,id'
            ],
            'email' => [
                'nullable', 'email', 'max:255',
                'unique:employees,email'
            ],
            'phone' => [
                'required', 'string', 'max:255',
                'unique:employees,phone'
            ],
            'gender' => [
                'required', 'string', 'in:pria,wanita'
            ],
            'religion' => [
                'required', 'string',
                'in:islam,kristen_protestan,kristen_katolik,hindu,buddha,konghucu'
            ],
            'place_of_birth' => [
                'required', 'string', 'max:255'
            ],
            'date_of_birth' => [
                'required', 'string', 'date_format:Y-m-d'
            ],
            'date_of_joining' => [
                'required', 'string', 'date_format:Y-m-d'
            ],
            'marital_status' => [
                'required', 'string',
                'in:belum_menikah,sudah_menikah'
            ],
            'photo' => [
                'required', 'file', 'mimes:jpg,jpeg,png',
                'max:5120'
            ],
            'address' => [
                'required', 'string', 'max:65535'
            ],
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
            'full_name' => 'Nama Lengkap',
            'number' => 'Nomor Pegawai',
            'designation_id' => 'Jabatan',
            'email' => 'Email',
            'phone' => 'Nomor Telepon Genggam',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'place_of_birth' => 'Tempat Lahir',
            'date_of_birth' => 'Tanggal Lahir',
            'date_of_joining' => 'Tanggal Bergabung',
            'marital_status' => 'Status Pernikahan',
            'photo' => 'Foto',
            'address' => 'Alamat',
        ];
    }
}
