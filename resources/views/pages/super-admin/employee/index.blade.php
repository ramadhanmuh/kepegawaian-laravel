@extends('layouts.super-admin')

@section('title', 'Pegawai')

@section('description', 'Halaman untuk melihat informasi daftar pegawai.')

@section('content')
    <h1 class="mt-4">Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pegawai</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.employees.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
        <div class="col-12">
            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered w-100 nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Foto</th>
                                <th>Nama</th>
                                <th>Nomor</th>
                                <th>Jabatan</th>
                                <th>Telepon Genggam</th>
                                <th class="text-xl-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script defer src="{{ url('assets/js/super-admin/employee/index.js') }}"></script>
@endpush