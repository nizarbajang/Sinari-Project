<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Peternak - AgroTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/farmer.css') }}">
</head>

<body>

    <!-- SIDEBAR DESKTOP -->
    <nav id="sidebar-desktop" class="d-none d-lg-block">
        <div class="sidebar-header">
            <h3>Agro<span style="color: var(--color-primary)">Tech</span></h3>
            <p class="text-white-50">Panel Peternak</p>
        </div>

        <ul class="list-unstyled components p-0">

            <li class="{{ Request::routeIs('farmer.dashboard') ? 'active' : '' }}">
                <a href="{{ route('farmer.dashboard') }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Dashboard Proyek</span>
                </a>
            </li>

            <li class="{{ Request::routeIs('reports.index') || Request::routeIs('reports.*') ? 'active' : '' }}">
                <a href="{{ route('reports.index') }}">
                    <i class="fas fa-boxes"></i>
                    <span>Daftar Proyek Anda</span>
                </a>
            </li>

        </ul>

        <div class="text-center mt-auto p-3 sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-outline-light w-100">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <!-- SIDEBAR MOBILE -->
    <div class="offcanvas offcanvas-start offcanvas-admin" tabindex="-1" id="sidebar-mobile"
        aria-labelledby="sidebar-mobileLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebar-mobileLabel">
                Agro<span style="color: var(--color-primary)">Tech</span>
            </h5>
            <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body">
            <ul class="list-unstyled components p-0">
                <li class="{{ Request::routeIs('farmer.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('farmer.dashboard') }}">
                        <i class="fas fa-chart-bar"></i> Dashboard Proyek
                    </a>
                </li>

                <li class="{{ Request::routeIs('reports.index') || Request::routeIs('reports.*') ? 'active' : '' }}">
                    <a href="{{ route('reports.index') }}">
                        <i class="fas fa-boxes"></i> Daftar Proyek Anda
                    </a>
                </li>
            </ul>

            <div class="text-center mt-auto p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-light w-100">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- WRAPPER -->
    <div id="content-wrapper">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 mx-3">
            <div class="container-fluid">

                <button class="btn btn-outline-secondary d-none d-lg-block me-3" id="sidebar-toggle-btn">
                    <i class="fas fa-bars"></i>
                </button>

                <button class="navbar-toggler d-lg-none me-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebar-mobile">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h4 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    @yield('page-title', 'Dashboard Proyek')
                </h4>

                <div class="d-flex ms-auto align-items-center">
                    @php
                        $role = Auth::user()->role;
                    @endphp

                    <a href="
                        @if ($role === 'farmer') {{ route('farmer.profile') }}
                        @elseif($role === 'investor')
                            {{ route('investor.profile') }}
                        @else
                            {{ route('admin.profile') }} @endif
                    "
                        class="me-3 text-primary" style="font-size: 1.3rem;">
                        <i class="fas fa-user-circle"></i>
                        <span class="me-3 text-primary d-none d-sm-inline">Halo, Peternak!</span>
                    </a>


                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-link text-danger">
                            <i class="fas fa-sign-out-alt"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            @yield('content')
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#sidebar-toggle-btn").on("click", function() {
                $("#sidebar-desktop").toggleClass("toggled");
                $("#content-wrapper").toggleClass("toggled");
            });
        });
    </script>

</body>

</html>
