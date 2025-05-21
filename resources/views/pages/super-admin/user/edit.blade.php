@extends('layouts.super-admin')

@section('title', 'Pengguna - Ubah')

@section('description', 'Halaman untuk menambahkan data pengguna.')

@section('content')
    <h1 class="mt-4">Ubah Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.users.index') }}" class="text-decoration-none">
                Pengguna
            </a>
        </li>
        <li class="breadcrumb-item active">Ubah</li>
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
                    <form action="{{ route('super-admin.users.update', $item->id) }}" class="row" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') === null ? $item->name : old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') === null ? $item->email : old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text">Jika tidak diisi, maka akan memakai data yang lama.</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon Genggam</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') === null ? $item->phone : old('phone') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Jenis</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="super_admin" {{ old('role') === null ? ($item->role === 'super_admin' ? 'selected' : '') : (old('role') === 'super_admin' ? 'selected' : '') }}>
                                    Super Admin
                                </option>
                                <option value="admin" {{ old('role') === null ? ($item->role === 'admin' ? 'selected' : '') : (old('role') === 'admin' ? 'selected' : '') }}>
                                    Admin
                                </option>
                            </select>
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

@push('scripts')
    @session('alertError')
        <script>
            alert('{{ $value }}');
        </script>
    @endsession
@endpush