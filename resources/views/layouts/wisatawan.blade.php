<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Adventure, Tours, Travel, Explore, Wisata, Batam, Jalan-Jalan, Liburan">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MeGuide - @yield('title', 'Destination')</title>
    @stack('styles')

    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/flaticon/flaticon_gowilds.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/calendar/calendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/custom.css') }}">
</head>

<body>
    @include('sweetalert::alert')
    <!-- Start Preloader -->
    <div class="preloader">
        <div class="loader">
            <div class="pre-shadow"></div>
            <div class="pre-box"></div>
        </div>
    </div>

    <!-- Search Modal -->
    <div class="modal fade search-modal" id="search-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form>
                    <div class="form_group">
                        <input type="search" class="form_control" placeholder="Search here" name="search">
                        <label><i class="fa fa-search"></i></label>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Header (Component) -->
    @include('components.header')

    @include('wisatawan.chatbot')

    <!-- Main Content -->
    <div class="page-content">
        <div class="main-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')


    {{-- Scripts --}}
    <!--====== Jquery js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/jquery-3.6.0.min.js') }}"></script>

    <!--====== Midtrans js ======-->
 

    <!--====== Bootstrap js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/popper/popper.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/bootstrap/js/bootstrap.min.js') }}" defer></script>

    <!--====== Slick js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/slick/slick.min.js') }}" defer></script>

    <!--====== Magnific js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}" defer></script>

    <!--====== Isotope js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/isotope.min.js') }}" defer></script>

    <!--====== Imagesloaded js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/imagesloaded.min.js') }}" defer></script>

    <!--====== Counterup js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/jquery.counterup.min.js') }}" defer></script>

    <!--====== Waypoints js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/jquery.waypoints.js') }}" defer></script>

    <!--====== Nice-select js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/nice-select/js/jquery.nice-select.min.js') }}" defer></script>

    <!--====== Calendar js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/calendar/calendar.min.js') }}"></script>

    <!--====== jquery UI js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/jquery-ui/jquery-ui.min.js') }}" defer></script>

    <!--====== WOW js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/wow.min.js') }}" defer></script>

    <!--====== Main js ======-->
    <script src="{{ asset('assets/wisatawan/js/theme.js') }}" defer></script>
    <!-- Tambahkan di bagian akhir sebelum </body> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonColor: '#3085d6'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonColor: '#d33'
                });
            });
        </script>
    @endif

    @stack('scripts')

    @yield('script-midtrans')

</body>

</html>
