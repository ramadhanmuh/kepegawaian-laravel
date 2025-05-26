@extends('layouts.admin')

@section('title', 'Profil - Ubah')

@section('description', 'Halaman untuk mengubah informasi akun.')

@section('content')
    <h1 class="mt-4">Ubah Profil</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.profile.index') }}" class="text-decoration-none">Profil</a>
        </li>
        <li class="breadcrumb-item active">Ubah</li>
    </ol>
    <div class="row">
        <div class="col-12">
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
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') === null ? $item->name : old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') === null ? $item->email : old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon Genggam</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') === null ? $item->phone : old('phone') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control" name="current_password" id="current_password" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
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