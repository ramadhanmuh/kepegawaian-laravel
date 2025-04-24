@extends('layouts.auth')

@section('title', 'Atur Ulang Kata Sandi')
@section('description', 'Halaman untuk mengubah kata sandi.')

@section('content')
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Atur Ulang Kata Sandi</h3></div>

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

    @session('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $value }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

    @session('error')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $value }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    
    <div class="card-body">
        <form method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" id="password" name="password" type="password" placeholder="********" required />
                <label for="password">Kata Sandi</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" placeholder="********" required />
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="{{ route('login.view') }}">Masuk</a>
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
@endsection