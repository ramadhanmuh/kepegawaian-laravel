@extends('layouts.super-admin')

@section('title', 'Jenis Pemberhentian Kerja - Ubah')

@section('description', 'Halaman untuk menambahkan data jenis pemberhentian kerja.')

@section('content')
    <h1 class="mt-4">Ubah Jenis Pemberhentian Kerja</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.termination-types.index') }}" class="text-decoration-none">
                Jenis Pemberhentian Kerja
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
                    <form action="{{ route('super-admin.termination-types.update', $item->id) }}" class="row" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-md-2 col-xl-1 mb-md-3">
                                    <label for="name" class="form-label m-md-0">Nama</label>
                                </div>
                                <div class="col-md-10 col-xl-11 mb-3">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') === null ? $item->name : old('name') }}" required>
                                </div>
                                <div class="col-md-2 col-xl-1">
                                    <label for="description" class="form-label m-md-0">Deskripsi</label>
                                </div>
                                <div class="col-md-10 col-xl-11">
                                    <textarea name="description" id="description" rows="3" class="form-control" required>{{ old('description') === null ? $item->description : old('description') }}</textarea>
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

@push('scripts')
    @session('alertError')
        <script>
            alert('{{ $value }}');
        </script>
    @endsession
@endpush