@extends('layouts.super-admin')

@section('title', 'Pengguna')

@section('description', 'Halaman untuk melihat informasi daftar pengguna.')

@section('content')
    <h1 class="mt-4">Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pengguna</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary btn-sm">
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
            <div class="card">
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
@endsection