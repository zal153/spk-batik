<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary">
                <span class="fs-4 fw-bold text-white d-flex align-items-center gap-2">
                    <i class="ph-duotone ph-palette fs-2"></i> Apollo Batik SPK
                </span>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <!-- ADMIN SIDEBAR -->
                <li class="pc-item pc-caption">
                    <label>ADMIN MENU</label>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph-duotone ph-gauge"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }}">
                    <a href="{{ route('admin.kriteria.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph-duotone ph-list-numbers"></i></span>
                        <span class="pc-mtext">Kriteria & AHP</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.alternatif*') ? 'active' : '' }}">
                    <a href="{{ route('admin.alternatif.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph-duotone ph-t-shirt"></i></span>
                        <span class="pc-mtext">Katalog Batik</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.rekap*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rekap.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph-duotone ph-file-text"></i></span>
                        <span class="pc-mtext">Rekap Laporan</span>
                    </a>
                </li>
                <li class="pc-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ph-duotone ph-users"></i></span>
                        <span class="pc-mtext">Manajemen Akun</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>