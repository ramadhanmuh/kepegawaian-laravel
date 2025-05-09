@extends('layouts.super-admin')

@section('title', 'Pengguna - Detail')

@section('description', 'Halaman untuk melihat informasi detail pengguna.')

@section('content')
    <h1 class="mt-4">Detail Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.users.index') }}" class="text-decoration-none">
                Pengguna
            </a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.users.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
                Ubah
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <b>Nama</b>
                            <p class="m-0">{{ $item->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Email</b>
                            <p class="m-0">{{ $item->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Nomor Telepon Genggam</b>
                            <p class="m-0">{{ $item->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <b>Jenis</b>
                            <p class="m-0">{{ $item->role }}</p>
                        </div>
                        <div class="col-md-6 mb-3 mb-md-0">
                            <b>Tanggal Dibuat</b>
                            <p class="m-0">{{ $item->created_at }}</p>
                        </div>
                        <div class="col-md-6">
                            <b>Tanggal Diubah</b>
                            <p class="m-0">{{ $item->created_at == $item->updated_at ? '-' : $item->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection