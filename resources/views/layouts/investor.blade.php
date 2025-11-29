<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('page-title', 'Dashboard Investor') - SinariFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Pastikan path CSS Anda benar --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    {{-- ================================================= --}}
    {{-- A. SIDEBAR DESKTOP --}}
    {{-- ================================================= --}}
    <nav id="sidebar-desktop" class="d-none d-lg-block">
        <div class="sidebar-header">
            <h3>Sinari<span style="color: var(--color-primary)">Farm</span></h3>
            <p class="text-white-50">Investor Panel</p>
        </div>
        <ul class="list-unstyled components p-0">
            <li class="{{ Request::routeIs('investor.dashboard') ? 'active' : '' }}">
                <a href="{{ route('investor.dashboard') }}"><i class="fas fa-home me-2"></i> <span>Dashboard
                        Utama</span></a>
            </li>
            <li
                class="{{ Request::routeIs('investments.projects.index', 'investor.investments.projects.show') ? 'active' : '' }}">
                <a href="{{ route('investments.projects.index') }}"><i class="fas fa-search-dollar me-2"></i>
                    <span>Cari Proyek</span></a>
            </li>
            <li class="{{ Request::routeIs('investments.history') ? 'active' : '' }}">
                <a href="{{ route('investments.history') }}"><i class="fas fa-history me-2"></i> <span>Riwayat
                        Investasi</span></a>
            </li>
            {{-- <li class="{{ Request::routeIs('investor.withdraw.index') ? 'active' : '' }}">
                <a href="{{ route('investor.withdraw.index') }}"><i class="fas fa-money-check-alt me-2"></i>
                    <span>Permintaan Withdraw</span></a>
            </li> --}}
            <li>
                <a href="#"><i class="fas fa-chart-bar me-2"></i> <span>Laporan Keuntungan</span></a>
            </li>
        </ul>
    </nav>

    {{-- ================================================= --}}
    {{-- B. SIDEBAR MOBILE (Offcanvas) --}}
    {{-- ================================================= --}}
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
                <li class="{{ Request::routeIs('investor.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('investor.dashboard') }}"><i class="fas fa-home me-2"></i> Dashboard Utama</a>
                </li>
                <li
                    class="{{ Request::routeIs('investments.projects.index', 'investor.investments.projects.show') ? 'active' : '' }}">
                    <a href="{{ route('investments.projects.index') }}"><i class="fas fa-search-dollar me-2"></i> Cari
                        Proyek</a>
                </li>
                <li class="{{ Request::routeIs('investments.history') ? 'active' : '' }}">
                    <a href="{{ route('investments.history') }}"><i class="fas fa-history me-2"></i> Riwayat
                        Investasi</a>
                </li>
                {{-- <li class="{{ Request::routeIs('investor.withdraw.index') ? 'active' : '' }}">
                    <a href="{{ route('investor.withdraw.index') }}"><i class="fas fa-money-check-alt me-2"></i>
                        Permintaan Withdraw</a>
                </li> --}}
                <li>
                    <a href="#"><i class="fas fa-chart-bar me-2"></i> Laporan Keuntungan</a>
                </li>
            </ul>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- C. WRAPPER UTAMA & NAVBAR --}}
    {{-- ================================================= --}}
    <div id="content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 mx-3">
            <div class="container-fluid">
                <button class="btn btn-light d-none d-lg-block me-3" id="sidebar-toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <button class="navbar-toggler d-lg-none me-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebar-mobile" aria-controls="sidebar-mobile">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Title section --}}
                <h4>@yield('page-icon') @yield('page-title')</h4>

                <div class="d-flex ms-auto">
                    <span class="me-3 text-muted d-none d-sm-inline">Halo, Investor
                        {{ Auth::user()->name ?? '' }}!</span>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-dark text-decoration-none p-0"><i
                                class="fas fa-sign-out-alt"></i>
                            Keluar</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- D. SCRIPTS --}}
    {{-- ================================================= --}}
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
</body>

</html>
