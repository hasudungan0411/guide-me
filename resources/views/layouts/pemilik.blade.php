<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/connect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dark_theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>
    <div class="loader">
        <div class="spinner-grow text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="connect-container align-content-stretch d-flex flex-wrap">
        <!-- Sidebar -->
        <div class="page-sidebar">
            <div class="logo-box">
                <a href="#" class="logo-text">MeGuide</a>
            </div>
            <div class="page-sidebar-inner slimscroll">
                <ul class="accordion-menu">
                    <li class="sidebar-title">Apps</li>
                    <li class="{{ Request::routeIs('pemilik.index') ? 'active-page' : '' }}">
                        <a href="{{ route('pemilik.index') }}"
                            class="{{ Request::routeIs('pemilik.index') ? 'active' : '' }}">
                            <i class="material-icons-outlined">dashboard</i>Dashboard
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('pemilik.tempatwisata') ? 'active-page' : '' }}">
                        <a href="{{ route('pemilik.tempatwisata', ['id' => '38']) }}"
                            class="{{ Request::routeIs('pemilik.tempatwisata') ? 'active' : '' }}">
                            <i class="material-icons-outlined">map</i>Tempat Wisata
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('pemilik.acara') ? 'active-page' : '' }}">
                        <a href="{{ route('pemilik.acara', ['id' => '38']) }}"
                            class="{{ Request::routeIs('pemilik.acara') ? 'active' : '' }}">
                            <i class="material-icons-outlined">event</i>Acara
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('pemilik.tiket') ? 'active-page' : '' }}">
                        <a href="{{ route('pemilik.tiket', ['id' => '38']) }}"
                            class="{{ Request::routeIs('pemilik.tiket') ? 'active' : '' }}">
                            <i class="material-icons-outlined">confirmation_number</i>Tiket
                        </a>
                    </li>
                    <li class="{{ Request::routeIs('pemilik.transaksi') ? 'active-page' : '' }}">
                        <a href="{{ route('pemilik.transaksi', ['id' => '38']) }}"
                            class="{{ Request::routeIs('pemilik.transaksi') ? 'active' : '' }}">
                            <i class="material-icons-outlined">payments </i>Transaksi
                        </a>
                    </li>
                        <!-- <li><a href="{{ route('pemilik.tempatwisata', ['id' => '38']) }}">Tempat Wisata</a></li>
                                <li><a href="{{ route('pemilik.acara', ['id' => '38']) }}">Acara</a></li>
                                <li><a href="{{ route('pemilik.tempatwisata', ['id' => '38']) }}">Tiket</a></li> -->
                   
                </ul>
            </div>
        </div>

        <!-- Page Container -->
        <div class="page-container">
            <!-- HEADER -->
            <div class="page-header">
                <nav class="navbar navbar-expand">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <ul class="navbar-nav">
                        <li class="nav-item small-screens-sidebar-link">
                            <a href="#" class="nav-link"><i class="material-icons-outlined">menu</i></a>
                        </li>
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/avatars/profile-image-2.png') }}" alt="profile image">
                                <span>pemilik</span>
                                <i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="">Pengaturan Akun</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('pemilik.logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                            </div>
                        </li>
                    </ul>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="#" class="nav-link" id="dark-theme-toggle">
                                    <i class="material-icons-outlined">brightness_2</i>
                                    <i class="material-icons">brightness_2</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="page-content">
                <div class="main-wrapper">
                    @yield('content')
                </div>
            </div>

            <!-- Footer -->
            <div class="page-footer">
                <div class="row">
                    <div class="col-md-12">
                        <span class="footer-text">&copy; {{ date('Y') }} MeGuide</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/plugins/jquery/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/connect.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>

    <!-- Form Logout (untuk keamanan di Laravel) -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>
</html>
