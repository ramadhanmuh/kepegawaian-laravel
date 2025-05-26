<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="@yield('description')" />
        <meta name="base-url" content="{{ url('') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $application->name }} - @yield('title')</title>
        <link rel="icon" type="image/x-icon" href="{{ url($application->favicon) }}">
        <link href="{{ url('template/css/styles.css') }}" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        @stack('styles')
    </head>
    <body class="sb-nav-fixed">
        @include('components.admin.nav')
        
        <div id="layoutSidenav">

            @include('components.admin.sidebar')
            
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        @yield('content')
                    </div>
                </main>
                
                @include('components.admin.footer')
            </div>
        </div>
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script defer src="{{ url('template/js/scripts.js') }}"></script>
        @stack('scripts')
    </body>
</html>
