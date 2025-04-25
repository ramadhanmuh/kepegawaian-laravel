@extends('layouts.super-admin')

@section('title', 'Profil - Ubah')

@section('description', 'Halaman untuk mengubah informasi akun.')

@section('content')
    <h1 class="mt-4">Ubah Profil</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">Profil</li>
        <li class="breadcrumb-item active">Ubah</li>
    </ol>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ empty(old('name')) ? $item->name : old('name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ empty(old('email')) ? $item->email : old('email') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon Genggam</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ empty(old('phone')) ? $item->phone : old('phone') }}" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('super-admin.profile.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection