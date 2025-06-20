<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link" href="{{ route('super-admin.dashboard.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                    Kepegawaian
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('super-admin.designations.index') }}">Jabatan</a>
                        <a class="nav-link" href="{{ route('super-admin.employees.index') }}">Pegawai</a>
                        <a class="nav-link" href="{{ route('super-admin.employee-education.index') }}">Pendidikan Pegawai</a>
                        <a class="nav-link" href="{{ route('super-admin.termination-types.index') }}">Jenis Pemberhentian</a>
                        <a class="nav-link" href="{{ route('super-admin.terminations.index') }}">Pemberhentian Kerja</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts2" aria-expanded="false" aria-controls="collapseLayouts2">
                    <div class="sb-nav-link-icon"><i class="fas fa-gear"></i></div>
                    Pengaturan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('super-admin.users.index') }}">Pengguna</a>
                        <a class="nav-link" href="{{ route('super-admin.application.index') }}">Aplikasi</a>
                    </nav>
                </div>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Masuk Sebagai :</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>