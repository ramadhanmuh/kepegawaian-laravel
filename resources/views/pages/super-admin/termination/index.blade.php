@extends('layouts.super-admin')

@section('title', 'Pemberhentian Kerja')

@section('description', 'Halaman untuk melihat informasi daftar pengguna.')

@section('content')
    <h1 class="mt-4">Pemberhentian Kerja</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pemberhentian Kerja</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.terminations.create') }}" class="btn btn-primary btn-sm">
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
                    <div class="row mb-3">
                        <div class="col-6 col-md-4 col-lg-3">
                            <label for="termination_type_id" class="form-label">Jenis</label>
                            <select name="termination_type_id" id="termination_type_id" class="form-select">
                                <option value="">Semua</option>
                                @forelse ($termination_types as $termination_type)
                                    <option value="{{ $termination_type->id }}">
                                        {{ $termination_type->name }}
                                    </option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered w-100">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px">No</th>
                                <th>Pegawai</th>
                                <th>Jenis</th>
                                <th>Subyek</th>
                                <th>Tanggal</th>
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
    @session('alertError')
        <script>
            alert('{{ $value }}');
        </script>
    @endsession

    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script defer src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script defer src="{{ url('assets/js/super-admin/termination/index.js') }}"></script>
@endpush