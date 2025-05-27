@extends('layouts.admin')

@section('title', 'Pendidikan Pegawai - Detail')

@section('description', 'Halaman untuk melihat informasi detail pendidikan pegawai.')

@section('content')
    <h1 class="mt-4">Detail Pendidikan Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.employee-education.index') }}" class="text-decoration-none">
                Pendidikan Pegawai
            </a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="row mb-3">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('admin.employee-education.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
                Ubah
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 mb-3 text-center">
                            <a href="{{ route('admin.employees.show', $item->employee_id) }}" class="text-decoration-none">
                                <img src="{{ url($item->photo) }}" alt="Foto Pendidikan Pegawai" width="124">
                            </a>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('admin.employees.show', $item->employee_id) }}" class="text-decoration-none">
                                <h5>{{ $item->full_name }} ({{ $item->number }})</h5>
                            </a>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <b>Jenjang :</b>
                            <p class="m-0">{{ $item->level }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Nama Sekolah/Kampus :</b>
                            <p class="m-0">{{ $item->school_name }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <b>Jurusan :</b>
                            <p class="m-0">{{ $item->major === null ? '-' : $item->major }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <b>Alamat Sekolah/Kampus :</b>
                            <p class="m-0">{{ $item->school_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <b>Tanggal Dibuat :</b>
                            <p class="m-0">{{ $item->created_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <b>Tanggal Diubah :</b>
                            <p class="m-0">{{ $item->created_at == $item->updated_at ? '-' : $item->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection