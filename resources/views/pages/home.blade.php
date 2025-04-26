@extends('layouts.auth')

@section('title', 'Beranda')
@section('description', 'Halaman informasi aplikasi.')

@section('content')
    <div class="card-header"><h3 class="text-center font-weight-light my-4">{{ $application->name }}</h3></div>

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
        <div class="row">
            <div class="col-12 mb-3">
                {{ $application->description }}
            </div>
            <div class="col-12">
                <a href="{{ route('login.view') }}" class="btn btn-primary">Masuk</a>
                <a href="{{ route('forgot-password.index') }}" class="btn btn-secondary">Lupa Kata Sandi ?</a>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <div class="col-12 mb-3 small">
            Silahkan menyetujui persetujuan penggunaan cookie di bawah ini untuk melanjutkan situs ini.
        </div>
    </div>

    @if (!request()->cookie('cookie_consent'))
        <div id="cookie-banner" style="z-index: 1000;" class="start-0 bottom-0 w-100 bg-dark position-fixed text-white p-1 px-2">
            Situs ini menggunakan cookie untuk meningkatkan pengalaman Anda. 
            <button onclick="acceptCookies()" class="btn btn-primary" type="button">Saya Setuju</button>
        </div>
    @endif
@endsection

@push('scripts')
    @if (!request()->cookie('cookie_consent'))
        <script>
            function acceptCookies() {
                fetch('{{ route("accept-cookie") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).then(() => {
                    document.getElementById('cookie-banner').remove();
                });
            }
        </script>
    @endif
@endpush