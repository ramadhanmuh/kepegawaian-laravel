@extends('layouts.super-admin')

@section('title', 'Aplikasi - Ubah')

@section('description', 'Halaman untuk mengubah informasi akun.')

@section('content')
    <h1 class="mt-4">Ubah Aplikasi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.application.index') }}" class="text-decoration-none">Aplikasi</a>
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
                    <form class="row" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-12 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') === null ? $application->name : old('name') }}" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description') === null ? $application->description : old('description') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="copyright" class="form-label">Hak Cipta</label>
                            <input type="text" class="form-control" name="copyright" id="copyright" value="{{ old('copyright') === null ? $application->copyright : old('copyright') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="favicon" class="form-label">Favicon</label>
                            <input type="file" class="form-control" name="favicon" id="favicon">
                            <small class="form-text">Jika tidak diisi, maka akan memakai data yang lama.</small>
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