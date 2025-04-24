@extends('layouts.auth')

@section('title', 'Masuk')
@section('description', 'Halaman untuk masuk ke aplikasi.')

@section('content')
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Pemulihan Kata Sandi</h3></div>

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
        <div class="small mb-3 text-muted">Masukkan email anda dan kami akan kirim kamu sebuah tautan untuk atur ulang jara sandi anda.</div>
        <form method="POST" action="{{ route('forgot-password.reset') }}">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                <label for="inputEmail">Email</label>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="{{ route('login.view') }}">Masuk</a>
                <button class="btn btn-primary" type="submit">Atur Ulang Kata Sandi</button>
            </div>
        </form>
    </div>
@endsection