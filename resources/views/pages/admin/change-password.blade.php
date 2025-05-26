@extends('layouts.admin')

@section('title', 'Ubah Kata Sandi')

@section('description', 'Halaman untuk mengubah kata sandi akun.')

@section('content')
    <h1 class="mt-4">Ubah Kata Sandi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Ubah Kata Sandi</li>
    </ol>
    <div class="row">
        <div class="col-12">
            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form class="row" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3">
                            <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="new_password" id="new_password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_password_confirmation" class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection