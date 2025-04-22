<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Halaman Admin')</title>
    @stack('styles')
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/connect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dark_theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/CROP/croppie.css') }}" rel="stylesheet">
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

                    <li class="{{ Request::routeIs('destinasi.*') ? 'active-page' : '' }}">
                        <a href="{{ route('destinasi.index') }}"
                            class="{{ Request::routeIs('destinasi.*') ? 'active' : '' }}">
                            <i class="material-icons-outlined">dashboard</i>Dashboard
                        </a>
                    </li>

                    <li class="{{ Request::routeIs('blog.*') ? 'active-page' : '' }}">
                        <a href="{{ url('/blog') }}" class="{{ Request::routeIs('blog.*') ? 'active' : '' }}">
                            <i class="material-icons-outlined">rss_feed</i>Blog
                        </a>
                    </li>

                    <li class="{{ Request::routeIs('saran.*') ? 'active-page' : '' }}">
                        <a href="{{ url('/saran') }}" class="{{ Request::routeIs('saran.*') ? 'active' : '' }}">
                            <i class="material-icons-outlined">feedback</i>Kelola Saran Wisata
                        </a>
                    </li>

                    <li class="sidebar-title">Akun Pengguna</li>
                    <li
                        class="{{ Request::routeIs('wisatawan.*') || Request::routeIs('pemilik-wisata.*') ? 'active-page' : '' }}">
                        <a href="#"><i class="material-icons">people</i>Kelola Akun<i
                                class="material-icons has-sub-menu">add</i></a>
                        <ul class="sub-menu">
                            <li class="{{ Request::routeIs('wisatawan.*') ? 'active-page' : '' }}">
                                <a href="{{ url('/wisatawan') }}"
                                    class="{{ Request::routeIs('wisatawan.*') ? 'active' : '' }}">Wisatawan</a>
                            </li>
                            <li class="{{ Request::routeIs('pemilik-wisata.*') ? 'active-page' : '' }}">
                                <a href="{{ url('/pemilik-wisata') }}"
                                    class="{{ Request::routeIs('pemilik-wisata.*') ? 'active' : '' }}">Pemilik Wisata</a>
                            </li>
                        </ul>
                    </li>


                    <li class="sidebar-title">Management</li>
                    <li
                        class="{{ Request::routeIs('kategori.*') || Request::routeIs('galeri.*') ? 'active-page' : '' }}">
                        <a href="#"><i class="material-icons">apps</i>Data<i
                                class="material-icons has-sub-menu">add</i></a>
                        <ul class="sub-menu">
                            <li class="{{ Request::routeIs('kategori.*') ? 'active-page' : '' }}">
                                <a href="{{ url('/kategori') }}"
                                    class="{{ Request::routeIs('kategori.*') ? 'active' : '' }}">Kategori</a>
                            </li>
                            <li class="{{ Request::routeIs('galeri.*') ? 'active-page' : '' }}">
                                <a href="{{ url('/galeri') }}"
                                    class="{{ Request::routeIs('galeri.*') ? 'active' : '' }}">Galeri</a>
                            </li>
                        </ul>
                    </li>
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
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/avatars/profile-image-2.png') }}"
                                    alt="profile image">
                                <span>{{ session('admin')->nama }}</span>
                                <i class="material-icons dropdown-icon">keyboard_arrow_down</i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="">Pengaturan Akun</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
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
    <script src="{{ asset('assets/CROP/croppie.min.js') }}"></script>
    <script src="{{ asset('assets/js/category.js') }}"></script>

    {{-- untuk tiny  --}}
    @stack('scripts')

    <!-- Form Logout (untuk keamanan di Laravel) -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</body>

</html>
