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
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Overlay untuk meningkatkan kontras teks */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            padding: 40px 20px;
            width: auto; /* Agar container mengikuti lebar kontennya */
            max-width: 100%; /* Membuat container lebar maksimal sesuai konten */
        }

        .ticket-img {
            width: 100%;
            height: auto;
        }

        .card-body h3 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .card-body p {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .btn {
            padding: 12px 25px;
            font-size: 1.1rem;
            margin: 10px;
        }

        /* Tabel responsif */
        .table {
            border: none; /* Menghilangkan border pada tabel */
            width: 100%; /* Memastikan tabel mengisi lebar kontainer */
        }

        .table td, .table th {
            border: none; /* Menghilangkan border pada sel tabel */
            padding: 8px 12px; /* Menambah padding pada sel */
            text-decoration: none; /* Menghilangkan underline jika ada */
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto; /* Agar tabel dapat digulir secara horizontal jika terlalu lebar */
        }

        /* Media query untuk perangkat kecil */
        @media (max-width: 768px) {
            .card-body h3 {
                font-size: 1.5rem;
            }

            .card-body p {
                font-size: 1rem;
            }

            .btn {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .container {
                padding: 20px;
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

    <div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100%;">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Konfirmasi Tiket {{ $destinasi->tujuan }}</h3>

                            <!-- Tabel untuk konfirmasi pesanan tanpa garis -->
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Nama</strong></td>
                                            <td>:</td>
                                            <td>{{ $wisatawan->Nama }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>:</td>
                                            <td>{{ $wisatawan->Email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jumlah Tiket</strong></td>
                                            <td>:</td>
                                            <td>{{ $data['Jumlah_Tiket'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Harga Satuan</strong></td>
                                            <td>:</td>
                                            <td>Rp {{ number_format($data['Harga_Satuan'], 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Harga</strong></td>
                                            <td>:</td>
                                            <td>Rp {{ number_format($data['Total_Harga'], 0, ',', '.') }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>

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
    <script src="{{ asset('assets/wisatawan/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/wisatawan/vendor/popper/popper.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/bootstrap/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/slick/slick.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/magnific-popup/dist/jquery.magnific-popup.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/isotope.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/imagesloaded.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/jquery.counterup.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/jquery.waypoints.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/nice-select/js/jquery.nice-select.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/calendar/calendar.min.js') }}"></script>
    <script src="{{ asset('assets/wisatawan/vendor/jquery-ui/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/vendor/wow.min.js') }}" defer></script>
    <script src="{{ asset('assets/wisatawan/js/theme.js') }}" defer></script>

    <!-- SweetAlert2 for Success/Error Notifications -->
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
