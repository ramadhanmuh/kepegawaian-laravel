@extends('layouts.auth')

@section('title', 'Masuk')
@section('description', 'Halaman untuk masuk ke aplikasi.')

@section('content')
    <div class="card-header"><h3 class="text-center font-weight-light my-4">Masuk</h3></div>

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
    
    <div class="card-body">
        <form method="POST" action="{{ route('login.authenticate') }}/">
            @csrf
            <div class="form-floating mb-3">
                <input class="form-control" name="email" id="email" type="email" placeholder="name@example.com" required />
                <label for="email">Email</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" name="password" id="password" type="password" placeholder="Kata Sandi" required />
                <label for="password">Kata Sandi</label>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" name="remember_me" id="remember_me" type="checkbox" value="1" />
                <label class="form-check-label" for="remember_me">Selalu Masuk</label>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="password.html">Lupa Kata Sandi ?</a>
                <button type="submit" class="btn btn-primary">Masuk</button>
            </div>
        </form>
    </div>
@endsection