@extends('layouts.admin')

@section('title', 'Jenis Pemberhentian Kerja - Detail')

@section('description', 'Halaman untuk melihat informasi detail jenis pemberhentian kerja.')

@section('content')
    <h1 class="mt-4">Detail Jenis Pemberhentian Kerja</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.termination-types.index') }}" class="text-decoration-none">
                Jenis Pemberhentian Kerja
            </a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="row mb-3">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('admin.termination-types.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
                Ubah
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-auto col-md-3 col-xl-2">
                                    <b>Nama</b>
                                </div>
                                <div class="col-auto px-1">
                                    <b>:</b>
                                </div>
                                <div class="col-12 col-md">{{ $item->name }}</div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-auto col-md-3 col-xl-2">
                                    <b>Deskripsi</b>
                                </div>
                                <div class="col-auto px-1">
                                    <b>:</b>
                                </div>
                                <div class="col-12 col-md">{{ $item->description }}</div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-auto col-md-3 col-xl-2">
                                    <b>Tanggal Dibuat</b>
                                </div>
                                <div class="col-auto px-1">
                                    <b>:</b>
                                </div>
                                <div class="col-12 col-md">{{ $item->created_at }}</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-auto col-md-3 col-xl-2">
                                    <b>Tanggal Diubah</b>
                                </div>
                                <div class="col-auto px-1">
                                    <b>:</b>
                                </div>
                                <div class="col-12 col-md">{{ $item->created_at == $item->updated_at ? '-' : $item->updated_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection