<header class="pc-header">
    <div class="header-wrapper">
        <!-- [Mobile Media Block] start -->
        <div class="me-auto pc-mob-drp">
            <ul class="list-unstyled">
                <!-- ======= Menu collapse Icon ===== -->
                <li class="pc-h-item pc-sidebar-collapse">
                    <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                        <i class="ph-duotone ph-list fs-4"></i>
                    </a>
                </li>
                <li class="pc-h-item pc-sidebar-popup">
                    <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                        <i class="ph-duotone ph-list fs-4"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!-- [Mobile Media Block end] -->
        <div class="ms-auto">
            <ul class="list-unstyled">
                <li class="dropdown pc-h-item">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="ph-duotone ph-sun-dim"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                            <i class="ph-duotone ph-moon"></i>
                            <span>Dark</span>
                        </a>
                        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                            <i class="ph-duotone ph-sun-dim"></i>
                            <span>Light</span>
                        </a>
                    </div>
                </li>
                <!-- User Profile Dropdown -->
                <li class="dropdown pc-h-item header-user-profile">
                    <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="d-flex align-items-center gap-2">
                            <span class="avtar avtar-s bg-light-primary rounded-circle">
                                <i class="ph-duotone ph-user fs-5 text-primary"></i>
                            </span>
                            <span class="user-name d-none d-sm-inline-block">
                                <span class="text-sm text-muted">{{ Auth::user()->name ?? 'Akses' }}</span>
                                <h6 class="mb-0 text-truncate" style="max-width: 100px;">{{ request()->is('admin*') ? 'Admin' : 'Customer' }}</h6>
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                        <div class="dropdown-header">
                            <h5 class="m-0 text-truncate">{{ Auth::user()->name ?? 'Selamat Datang' }}</h5>
                            <small class="text-muted">{{ Auth::user()->email ?? '' }}</small>
                        </div>
                        {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="ph-duotone ph-gear"></i>
                            <span>Pengaturan Profil</span>
                        </a> --}}
                        <hr class="dropdown-divider">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="ph-duotone ph-sign-out"></i>
                                <span>Keluar</span>
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>