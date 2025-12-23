<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard Admin') - SinariFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    {{-- Bagian Sidebar Desktop --}}
    <nav id="sidebar-desktop" class="d-none d-lg-block">
        <div class="sidebar-header">
            <h3>Sinari<span style="color: var(--color-primary)">Farm</span></h3>
            <p class="text-white-50">Admin Panel</p>
        </div>
        <ul class="list-unstyled components p-0">
            {{-- 1. Dashboard Utama --}}
            <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-2"></i> <span>Dashboard
                        Utama</span></a>
            </li>

            {{-- 2. Kelola Proyek --}}
            <li class="{{ Request::routeIs('projects.*') ? 'active' : '' }}">
                <a href="{{ route('projects.index') }}"><i class="fas fa-boxes me-2"></i> <span>Kelola Proyek</span></a>
            </li>

            {{-- 3. Kelola User --}}
            <li class="{{ Request::routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}"><i class="fas fa-users-cog me-2"></i> <span>Kelola User</span></a>
            </li>

            {{-- 4. Laporan Proyek (Farmer Reports) --}}
            <li class="{{ Request::routeIs('admin.reports.*') ? 'active' : '' }}">
                <a href="{{ route('admin.reports.index') }}"><i class="fas fa-clipboard-list me-2"></i> <span>Laporan
                        Proyek</span></a>
            </li>

            {{-- 5. Ikhtisar Keuangan --}}
            <li class="{{ Request::routeIs('finance.index') ? 'active' : '' }}">
                <a href="{{ route('finance.index') }}"><i class="fas fa-chart-area me-2"></i> <span>Ikhtisar
                        Keuangan</span></a>
            </li>

            {{-- 6. Konfirmasi Investasi --}}
            <li class="{{ Request::routeIs('admin.investments.index') ? 'active' : '' }}">
                <a href="{{ route('admin.investments.index') }}"><i class="fas fa-hand-holding-usd me-2"></i>
                    <span>Konfirmasi Investasi</span></a>
            </li>

            {{-- 7. Permintaan Withdraw --}}
            <li class="{{ Request::routeIs('finance.withdraw.index') ? 'active' : '' }}">
                <a href="{{ route('finance.withdraw.index') }}"><i class="fas fa-money-bill-wave me-2"></i>
                    <span>Permintaan Withdraw</span></a>
            </li>

        </ul>
    </nav>

    {{-- Bagian Sidebar Mobile (Offcanvas) --}}
    <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="sidebar-mobile"
        aria-labelledby="sidebar-mobileLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebar-mobileLabel">
                Sinari<span style="color: var(--color-primary)">Farm</span>
            </h5>
            <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-unstyled components p-0">
                <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"><i class="fas fa-home me-2"></i> Dashboard Utama</a>
                </li>
                <li class="{{ Request::routeIs('projects.*') ? 'active' : '' }}">
                    <a href="{{ route('projects.index') }}"><i class="fas fa-boxes me-2"></i> Kelola Proyek</a>
                </li>
                <li class="{{ Request::routeIs('users.*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}"><i class="fas fa-users-cog me-2"></i> Kelola User</a>
                </li>
                <li class="{{ Request::routeIs('admin.reports.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}"><i class="fas fa-clipboard-list me-2"></i> Laporan
                        Proyek</a>
                </li>
                <li class="{{ Request::routeIs('finance.index') ? 'active' : '' }}">
                    <a href="{{ route('finance.index') }}"><i class="fas fa-chart-area me-2"></i> Ikhtisar Keuangan</a>
                </li>
                <li class="{{ Request::routeIs('admin.investments.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.investments.index') }}"><i class="fas fa-hand-holding-usd me-2"></i>
                        Konfirmasi
                        Investasi</a>
                </li>
                <li class="{{ Request::routeIs('finance.withdraw.index') ? 'active' : '' }}">
                    <a href="{{ route('finance.withdraw.index') }}"><i class="fas fa-money-bill-wave me-2"></i>
                        Permintaan Withdraw</a>
                </li>

                {{-- Logout Mobile --}}
                <li>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none text-white-50 w-100 text-start"
                            style="padding: 0; line-height: 2;"><i class="fas fa-sign-out-alt me-2"></i> Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    {{-- Wrapper Konten Utama --}}
    <div id="content-wrapper">
        {{-- Navbar Header --}}
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 mx-3">
            <div class="container-fluid">
                <button class="btn btn-light d-none d-lg-block me-3" id="sidebar-toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <button class="navbar-toggler d-lg-none me-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebar-mobile" aria-controls="sidebar-mobile">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Judul Dinamis --}}
                <h4><i class="fas fa-tachometer-alt me-2"></i> @yield('title', 'Admin Panel')</h4>

                <div class="d-flex ms-auto">
                    <span class="me-3 text-muted d-none d-sm-inline">Halo, Admin!</span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-dark btn btn-link p-0"><i class="fas fa-sign-out-alt"></i>
                            Keluar</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Skrip untuk Toggle Sidebar Desktop
            $("#sidebar-toggle-btn").on("click", function() {
                $("#sidebar-desktop").toggleClass("active");
                $("#content-wrapper").toggleClass("active");
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
