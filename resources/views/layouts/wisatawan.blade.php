<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Adventure, Tours, Travel, Explore, Wisata, Batam, Jalan-Jalan, Liburan">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>MeGuide - @yield('title', 'Destination')</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/flaticon/flaticon_gowilds.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/magnific-popup/dist/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/nice-select/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/custom.css') }}">
</head>

<body>
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

    <!-- Main Content -->
    <div class="page-content">
        <div class="main-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('components.footer')

    {{-- scripts  --}}
    <!--====== Back To Top  ======-->
    <a href="#" class="back-to-top" ><i class="far fa-angle-up"></i></a>
    <!--====== Jquery js ======-->
    <script src="assets/wisatawan/vendor/jquery-3.6.0.min.js"></script>
    <!--====== Bootstrap js ======-->
    <script src="assets/wisatawan/vendor/popper/popper.min.js"></script>
    <!--====== Bootstrap js ======-->
    <script src="assets/wisatawan/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--====== Slick js ======-->
    <script src="assets/wisatawan/vendor/slick/slick.min.js"></script>
    <!--====== Magnific js ======-->
    <script src="assets/wisatawan/vendor/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <!--====== Isotope js ======-->
    <script src="assets/wisatawan/vendor/isotope.min.js"></script>
    <!--====== Imagesloaded js ======-->
    <script src="assets/wisatawan/vendor/imagesloaded.min.js"></script>
    <!--====== Counterup js ======-->
    <script src="assets/wisatawan/vendor/jquery.counterup.min.js"></script>
    <!--====== Waypoints js ======-->
    <script src="assets/wisatawan/vendor/jquery.waypoints.js"></script>
    <!--====== Nice-select js ======-->
    <script src="assets/wisatawan/vendor/nice-select/js/jquery.nice-select.min.js"></script>
    <!--====== jquery UI js ======-->
    <script src="assets/wisatawan/vendor/jquery-ui/jquery-ui.min.js"></script>
    <!--====== WOW js ======-->
    <script src="assets/wisatawan/vendor/wow.min.js"></script>
    <!--====== Main js ======-->
    <script src="assets/wisatawan/js/theme.js"></script>

</body>

</html>
