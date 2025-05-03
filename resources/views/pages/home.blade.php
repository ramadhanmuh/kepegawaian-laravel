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
            @session('error')
                <div class="col-12 mb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $value }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endsession
            <div class="col-12 mb-3">
                {{ $application->description }}
            </div>
            <div class="col-12">
                <a href="{{ route('login.view') }}" class="btn btn-primary">Masuk</a>
                <a href="{{ route('forgot-password.index') }}" class="btn btn-secondary">Lupa Kata Sandi ?</a>
            </div>
        </div>
    </div>

    @if (! request()->cookie('cookie_consent'))
        <div class="card-footer">
            <div class="col-12 mb-3 small">
                Silahkan menyetujui persetujuan penggunaan cookie di bawah layar untuk melanjutkan situs ini.
            </div>
        </div>
    @endif

    @if (!request()->cookie('cookie_consent'))
        <div id="cookie-banner" style="z-index: 1000;" class="start-0 bottom-0 w-100 bg-dark position-fixed text-white p-1 px-2">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    Situs ini menggunakan cookie untuk meningkatkan pengalaman Anda.    
                </div>
                <div class="col-auto">
                    <button onclick="acceptCookies()" id="accept_cookie_button" class="btn btn-primary" type="button">Saya Setuju</button>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @if (!request()->cookie('cookie_consent'))
        <script>
            function acceptCookies() {
                var acceptCookieButton = document.getElementById('accept_cookie_button');
                
                acceptCookieButton.innerText = 'Memuat...';

                var xhr = new XMLHttpRequest();                

                var method = 'POST';

                var url = '{{ route("accept-cookie") }}';

                xhr.open(method, url, true);

                xhr.onreadystatechange = function() {
                    // Selesai
                    if (xhr.readyState === 4) {
                        // Berhasil
                        if (xhr.status === 200) {
                            document.getElementById('cookie-banner').remove();
                        } else {
                            acceptCookieButton.innerText = 'Saya Setuju';
                            alert('Gagal menyetujui penggunaan cookie.');
                        }
                    }
                };

                xhr.send();
            }
        </script>
    @endif
@endpush