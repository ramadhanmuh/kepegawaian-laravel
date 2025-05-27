@extends('layouts.admin')

@section('title', 'Jabatan - Tambah')

@section('description', 'Halaman untuk menambahkan data jabatan.')

@section('content')
    <h1 class="mt-4">Tambah Jabatan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.designations.index') }}" class="text-decoration-none">
                Jabatan
            </a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
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
                    <form action="{{ route('admin.designations.store') }}" class="row" method="POST">
                        @csrf
                        <div class="col-12 mb-3">
                            <div class="row align-items-center">
                                <div class="col-md-2 col-xl-1">
                                    <label for="name" class="form-label m-md-0">Nama</label>
                                </div>
                                <div class="col-md-10 col-xl-11">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-2 col-xl-1"></div>
                                <div class="col-md-10 col-xl-11">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
@endsection