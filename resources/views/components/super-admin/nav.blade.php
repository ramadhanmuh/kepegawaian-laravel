<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    {{-- Navbar Brand --}}
    <a class="navbar-brand ps-3" href="{{ route('super-admin.dashboard.index') }}">{{ $application->name }}</a>
    {{-- Sidebar Toggle --}}
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    {{-- Navbar --}}
    <ul class="navbar-nav ms-auto me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('super-admin.profile.index') }}">Profil</a></li>
                <li><a class="dropdown-item" href="{{ route('super-admin.change-password.edit') }}">Ubah Kata Sandi</a></li>
                <li>
                    <form action="{{ route('super-admin.delete-account') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">Hapus Akun</button>
                    </form>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                    <form action="{{ route('super-admin.logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>