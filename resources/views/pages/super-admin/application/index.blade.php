@extends('layouts.super-admin')

@section('title', 'Aplikasi')

@section('description', 'Halaman untuk melihat informasi aplikasi.')

@section('content')
    <h1 class="mt-4">Aplikasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Aplikasi</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <div class="row justify-content-end">
                <div class="col-auto">
                    <a href="{{ route('super-admin.application.edit') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                        <span class="d-none d-md-inline">
                            Ubah
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12">
            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <b>Nama</b>
                            <p class="m-0">{{ $application->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Deskripsi</b>
                            <p class="m-0">{{ $application->description }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Hak Cipta</b>
                            <p class="m-0">{{ $application->copyright }}</p>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <b>Tanggal Dibuat</b>
                            <p class="m-0">{{ $application->created_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <b>Tanggal Diubah</b>
                            <p class="m-0">{{ $application->created_at === $application->updated_at ? '-' : $application->updated_at }}</p>
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