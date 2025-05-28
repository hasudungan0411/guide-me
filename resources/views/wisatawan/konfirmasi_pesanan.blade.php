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
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

    <style>
        /* Menambah tinggi dan mengatur tampilan konten */
        body {
            background-image: url('{{ asset('storage/images/destinasi/' . $destinasi->gambar) }}');
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh; /* Pastikan body mengambil tinggi layar penuh */
            margin: 0;
            display: flex; /* Gunakan flexbox untuk penataan vertikal dan horizontal */
            justify-content: center; /* Posisikan konten di tengah horizontal */
            align-items: center; /* Posisikan konten di tengah vertikal */
            flex-direction: column; /* Sesuaikan arah konten menjadi kolom */
        }

        /* Overlay dengan transparansi untuk meningkatkan kontras teks */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Mempertegas overlay */
            z-index: 1;
        }

        /* Membuat kontainer lebih tinggi dan menambah padding */
        .container {
            position: relative;
            z-index: 2;
            padding: 40px 20px; /* Padding lebih kecil untuk tampilan responsif */
            max-width: 1200px; /* Batasi lebar kontainer */
            width: 100%; /* Agar kontainer dapat menyesuaikan lebar layar */
        }

        /* Gaya untuk gambar tiket */
        .ticket-img {
            width: 100%;
            height: auto;
        }

        /* Memperbesar ukuran teks dan menambah ruang antar elemen */
        .card-body h3 {
            font-size: 2rem; /* Ukuran font yang responsif */
            margin-bottom: 20px;
        }

        .card-body p {
            font-size: 1.1rem; /* Ukuran font yang lebih besar */
            margin-bottom: 15px;
        }

        .btn {
            padding: 12px 25px;
            font-size: 1.1rem;
            margin: 10px; /* Memberikan jarak antar tombol */
        }

        /* Menambahkan media query untuk perangkat kecil (mobile) */
        @media (max-width: 768px) {
            .card-body h3 {
                font-size: 1.5rem; /* Menyesuaikan ukuran font untuk perangkat kecil */
            }

            .card-body p {
                font-size: 1rem; /* Menyesuaikan ukuran font untuk perangkat kecil */
            }

            .btn {
                font-size: 1rem; /* Ukuran tombol lebih kecil pada perangkat kecil */
                padding: 10px 20px; /* Menyesuaikan padding pada tombol */
            }

            .container {
                padding: 20px; /* Padding lebih kecil pada layar kecil */
            }
        }
    </style>
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

    <!-- Overlay untuk meningkatkan kontras teks di atas gambar -->
    <div class="overlay"></div>

    <!-- Gunakan flexbox untuk menengahnya konten -->
    <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100%;">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ $destinasi->tujuan }}</h3>

                            <!-- Konfirmasi Pesanan -->
                            <p><strong>ID Wisata:</strong> {{ $data['ID_Wisata'] }}</p>
                            <p><strong>Jumlah Tiket:</strong> {{ $data['Jumlah_Tiket'] }}</p>
                            <p><strong>Harga Satuan:</strong> Rp {{ number_format($data['Harga_Satuan'], 0, ',', '.') }}</p>
                            <p><strong>Total Harga:</strong> Rp {{ number_format($data['Total_Harga'], 0, ',', '.') }}</p>
                            
                            <!-- Informasi Wisatawan -->
                            <p><strong>Nama Wisatawan:</strong> {{ $wisatawan->name }}</p>
                            <p><strong>Email Wisatawan:</strong> {{ $wisatawan->email }}</p>

                            <!-- Tombol untuk Konfirmasi dan Pembatalan -->
                            <form action="{{ route('konfirmasi.pesanan', $data['ID_Wisata']) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">Konfirmasi Pesanan</button>
                            </form>

                            <form action="{{ route('batal.pesanan') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger">Batalkan Pesanan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Scripts --}}
    <!--====== Jquery js ======-->
    <script src="{{ asset('assets/wisatawan/vendor/jquery-3.6.0.min.js') }}"></script>

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

</body>

</html>
