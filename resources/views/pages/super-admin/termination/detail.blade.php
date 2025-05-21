@extends('layouts.super-admin')

@section('title', 'Pemberhentian Kerja - Detail')

@section('description', 'Halaman untuk melihat informasi detail pengguna.')

@section('content')
    <h1 class="mt-4">Detail Pemberhentian Kerja</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.terminations.index') }}" class="text-decoration-none">
                Pemberhentian Kerja
            </a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="row mb-3">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.terminations.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
                Ubah
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-12 mb-3 text-center">
                            <a href="{{ route('super-admin.employees.show', $item->employee_id) }}" class="text-decoration-none">
                                <img src="{{ url($item->photo) }}" alt="Foto Pegawai" width="124">
                            </a>
                        </div>
                        <div class="col-12 text-center">
                            <a href="{{ route('super-admin.employees.show', $item->employee_id) }}" class="text-decoration-none">
                                <h5>{{ $item->full_name }} ({{ $item->number }})</h5>
                            </a>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <b>Jenis Pemberhentian :</b>
                            <p class="m-0">
                                <a href="{{ route('super-admin.termination-types.show', $item->termination_type_id) }}" class="text-decoration-none">
                                    {{ $item->termination_type }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Subyek :</b>
                            <p class="m-0">{{ $item->subject }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <b>Deskripsi :</b>
                            <p class="m-0">{{ $item->description }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Tanggal Pemberitahuan :</b>
                            <p class="m-0">{{ $item->notice_date }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Tanggal Pemberhentian :</b>
                            <p class="m-0">{{ $item->termination_date }}</p>
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

@push('scripts')
    @session('alertError')
        <script>
            alert('{{ $value }}');
        </script>
    @endsession
@endpush