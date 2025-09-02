@extends('layouts.wisatawan')

@section('title', 'Detail Destinasi')

@push('styles')
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
    <link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css"
        rel="stylesheet" />
@endpush


@section('content')
    <section class="place-details-section">
        <!-- Map Slider -->
        <div class="place-slider-area overflow-hidden wow fadeInUp">
            <div class="place-slider">
                @foreach (['gambar', 'gambar2', 'gambar3', 'gambar4', 'gambar5'] as $gambar)
                    @if (!empty($destination->$gambar))
                        <div class="place-slider-item">
                            <div class="place-img">
                                <img style="width: 950px; height: 570px; overflow: hidden;"
                                    src="{{ asset('storage/images/destinasi/' . $destination->$gambar) }}"
                                    alt="Place Image">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Details and Map Section -->
        <div class="container" style="height: auto; margin-bottom: 200px;">
            <div class="tour_details-wrapper pt-80">
                <div class="tour-title-wrapper pb-12 wow fadeInUp">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="tour-title mb-20">
                                <!-- Favorite Icon -->
                                <div class="favorite-icon" id="favorite-icon" data-id="{{ $destination->id }}"
                                    data-logged-in="{{ Auth::guard('wisatawan')->check() ? 'true' : 'false' }}"
                                    style="cursor: pointer;">
                                    <i class="far fa-heart" style="font-size: 30px; color: gray;"></i>
                                </div>
                                <h3 class="title">
                                    {{ $destination->tujuan }}
                                </h3>
                                <p><i class="far fa-map-marker-alt mb-40"></i>Batam, Kepulauan Riau</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Contentt -->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="place-content-wrap pt-10 wow fadeInUp" style="margin-top: -51px !important;">
                            <p style="text-align: justify;">{!! strip_tags($destination->desk) !!}</p>
                            <h4 class="mt-4">Deskripsi</h4>
                            <p style="text-align: justify;" class="mb-3">{!! strip_tags($destination->long_desk) !!}</p>

                            <!--=== Acara ===-->
                            <h4 class="mt-4">Acara di {{ $destination->tujuan }}</h4>
                            <div class="row text-center">
                                @foreach ($acara as $event)
                                    <div class="col-md-2 mb-4 d-flex justify-content-center">
                                        <div data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->ID_Acara }}"
                                            style="position: relative; width: 125px; height: 125px; border-radius: 50%; overflow: hidden; border: 7px solid #aef7dd;
                                            cursor: pointer; transition: transform 0.5s ease;"
                                            onmouseenter="this.style.transform='scale(1.05)'"
                                            onmouseleave="this.style.transform='scale(1)'">
                                            <img src="{{ asset('storage/images/event/' . $event->Gambar_acara) }}"
                                                alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                            <div style="position: absolute; inset: 0; background-color: rgba(11, 237, 52, 0.6); border-radius: 50%; display: flex;
                                            justify-content: center; align-items: center; color: white; font-weight: bold; font-size: 16px; opacity: 0; transition: opacity 0.3s ease;"
                                                onmouseenter="this.style.opacity='1'" onmouseleave="this.style.opacity='0'">
                                                {{ Str::words($event->Nama_acara, 2) }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- modal utk detail  --}}
                                    <div class="modal fade" id="eventModal{{ $event->ID_Acara }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $event->ID_Acara }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        {{ $event->Nama_acara }}
                                                    </h3>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/images/event/' . $event->Gambar_acara) }}"
                                                        alt=""
                                                        style="max-width: 100%; max-height: 300px; border-radius: 10px; margin-bottom: 10px;">
                                                    <p style="font-weight: bold;">
                                                        {{ $event->Tanggal_mulai_acara }} -
                                                        {{ $event->Tanggal_berakhir_acara }}
                                                    </p>
                                                    <p style="margin-top: 25px;">
                                                        {{ Str::limit(strip_tags($event->Deskripsi), 150, '...') }}
                                                        <a href="{{ route('wisatawan.acara_detail', ['ID_Acara' => $event->ID_Acara]) }}"
                                                            style="color: #8d979f; text-decoration: none;">Lihat
                                                            Selengkapnya</a>
                                                    </p>
                                                    <div class="modal-footer justify-content-center">
                                                        <a href="{{ route('wisatawan.acara_detail', ['ID_Acara' => $event->ID_Acara]) }}"
                                                            class="btn btn-primary"
                                                            style="margin-top: 20px; background-color: #64b5f6; border: none;">Lihat
                                                            Detail</a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <h4 class="mt-4">Beli Tiket</h4>
                            <!-- pesantiket -->
                            @if ($tiket)
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#tiketModal">
                                    Pesan Tiket
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="tiketModal" tabindex="-1" aria-labelledby="tiketModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tiketModalLabel">
                                                    Tiket {{ $destination->tujuan }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Harga Tiket : </strong>{{ $tiket->Harga }}</p>
                                                <p><strong>Stok Tiket : </strong>{{ $tiket->Persediaan }}</p>
                                                <form action="{{ route('wisatawan.konfirmasi') }}" method="GET"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="ID_Wisata" value="{{ $destination->id }}">
                                                    <input type="hidden" name="Harga_Satuan"
                                                        value="{{ $tiket->Harga }}">

                                                    <div class="form-group col-md-4">
                                                        <input name="Jumlah_Tiket" type="number" class="form-control"
                                                            id="Tiket" min="0" required>
                                                    </div>

                                                    <div class="modal-footer mt-4">
                                                        <button id="submitBtn" type="submit"
                                                            class="btn btn-primary mt-3">Pesan Tiket</button>
                                                    </div>

                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @else
                                <p>Tiket belum tersedia untuk destinasi ini.</p>
                            @endif

                            <h4 class="mt-4">Navigasi</h4>
                            <p class="mb-3">Berikut ini adalah navigasi ke <b>{{ $destination->tujuan }}</b>, anda dapat
                                melihat peta di bagian bawah dan navigasi di bagian sisi kanan.</p>
                        </div>

                        <!--=== Map Box ===-->
                        <div class="map-box mb-60 wow fadeInUp">
                            <!-- Bungkus map dan directions dalam satu flex container -->
                            <div id="map-wrapper"
                                style="display: flex; flex-direction: row; height: 600px; width: 100%; position: relative;">

                                <!-- MAP AREA -->
                                <div id="map" data-lat="{{ $destination->latitude }}"
                                    data-lng="{{ $destination->longitude }}"
                                    style="flex: 3; border-radius: 8px; height: 100%;">
                                </div>

                                <!-- DIRECTIONS PANEL -->
                                <div id="directions-container"
                                    style="flex: 1; display: none; background: white; overflow-y: auto; padding: 10px;">
                                </div>
                            </div>

                            <p class="mt-3">Asal: <span id="origin-name">Menunggu lokasi...</span></p>
                            <div class="mt-3">
                                <button id="show-route-btn" class="btn btn-primary">Tampilkan Rute</button>
                                <button id="start-navigation-btn" class="btn btn-success" style="display:none;">Mulai
                                    Perjalanan</button>
                            </div>
                        </div>

                        <!--=== Ulasan Section ===-->
                        <h4 class="mt-4">Ulasan Pengunjung</h4>
                        <form action="{{ route('wisatawan.ulasan.store', $destination->id) }}" method="POST"
                            id="form-ulasan">
                            @csrf
                            <div class="form-row" style="display: flex; align-items: center;">
                                <div class="col-md-10" style="flex: 1;">
                                    <div class="form-group mt-3">
                                        <textarea name="ulasan" required class="form-control" rows="4"></textarea>
                                    </div>
                                    <!-- Tombol Kirim -->
                                    <button type="button" id="showRatingModal" class="btn btn-primary mt-2">Kirim
                                        Ulasan</button>

                                </div>
                            </div>
                            <!-- Pembatas (Divider) setelah tombol kirim ulasan -->
                            <hr style="border: 1px solid #b2aeae; margin: 20px 0;">

                            <!-- Menampilkan jumlah ulasan dan rating -->
                            <div style="text-align: left; margin-bottom: 20px; font-size: 1.5rem; color: #FFD700;">
                                <h4><strong>Ulasan </strong>({{ $destination->ulasan->count() }})
                                    @if ($destination->ulasan->count() > 0)
                                        {{-- {{ number_format($destination->ulasan->avg('rating'), 1) }} / 5 --}}
                                        <span style="display: inline-block;">
                                            @php
                                                $rating = $destination->ulasan->avg('rating');
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($rating >= $i)
                                                    <span style="font-size: 20px; color: #f39c12;">★</span>
                                                    <!-- Bintang penuh -->
                                                @elseif ($rating >= $i - 0.5)
                                                    <span
                                                        style="font-size: 20px; color: #f39c12; background: linear-gradient(90deg, #f39c12 50%, #ddd 50%); -webkit-background-clip: text; color: transparent;">★</span>
                                                    <!-- Bintang setengah -->
                                                @else
                                                    <span style="font-size: 20px; color: #ddd;">★</span>
                                                    <!-- Bintang kosong -->
                                                @endif
                                            @endfor
                                        </span>
                                    @endif
                                </h4>
                            </div>
                        </form>
                        <div class="modal fade" id="ratingModal" tabindex="-1" role="dialog"
                            aria-labelledby="ratingModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document"
                                style="display: flex; justify-content: center; align-items: center; height: 100%; width: 100%; max-width: 400px; margin: 0 auto;">
                                <div class="modal-content"
                                    style="padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: #fff;">
                                    <div class="modal-header"
                                        style="display: flex; justify-content: center; width: 100%; text-align: center;">
                                        <h5 class="modal-title" id="ratingModalLabel" style="width: 100%;">Pilih Rating
                                            Anda</h5>
                                    </div>
                                    <div class="modal-body" style="text-align: center;">
                                        <!-- Rating Bintang -->
                                        <div class="rating-container"
                                            style="display: flex; justify-content: center; gap: 65px; margin-bottom: 20px; flex-wrap: wrap;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div style="display: flex; flex-direction: column; align-items: center;">
                                                    <input type="radio" name="rating_popup"
                                                        value="{{ $i }}" id="star{{ $i }}_popup"
                                                        required style="display: none;">
                                                    <label for="star{{ $i }}_popup" class="fa fa-star"
                                                        style="font-size: 2rem; color: #ddd; cursor: pointer; transition: color 0.2s ease;">
                                                    </label>
                                                    <span class="rating-label" style="font-size: 0.9rem; color: #555;">
                                                        @if ($i == 1)
                                                            Tidak Suka
                                                        @elseif ($i == 2)
                                                            Kurang Suka
                                                        @elseif ($i == 3)
                                                            Netral
                                                        @elseif ($i == 4)
                                                            Suka
                                                        @else
                                                            Sangat Suka
                                                        @endif
                                                    </span>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Menampilkan ulasan yang sudah ada --}}
                        @forelse ($destination->ulasan->take(3) as $ulasan)
                            <div class="ulasan-item" id="ulasan-{{ $ulasan->id }}" style="margin-bottom: 1.5rem;">
                                <div style="display: flex; align-items: flex-start;">
                                    <!-- Profil Image -->
                                    <div style="margin-right: 10px;">
                                        <img src="{{ $ulasan->wisatawan->Foto_Profil ?? asset('assets/images/avatars/profile-image-2.png') }}"
                                            alt="foto-profil" style="width: 40px; height: 40px; border-radius: 50%;">
                                    </div>
                                    <div>
                                        <!-- Nama Wisatawan -->
                                        <h6 style="font-size: 1.25rem; font-weight: bold; margin: 0;">
                                            {{ $ulasan->wisatawan->Nama }}</h6>
                                        <!-- Tanggal -->
                                        <p style="font-size: 1rem; margin: 0;">
                                            {{ $ulasan->created_at->format('d M Y') }}
                                        </p>
                                        <!-- Rating -->
                                        <div class="rating-container" style="font-size: 15px;"
                                            data-rating="{{ $ulasan->rating }}">
                                            <p>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="fa fa-star"></span>
                                                @endfor
                                            </p>
                                        </div>
                                        <!-- Ulasan -->
                                        <p style="font-size: 1rem; margin: 0;">{{ $ulasan->ulasan }}</p>
                                    </div>
                                </div>
                                <hr style="border: 1px solid #ddd;">
                            </div>
                        @empty
                            <p>Belum ada ulasan untuk destinasi ini.</p>
                        @endforelse
                        <style>
                            /* css utk rating */
                            .fa-star {
                                color: #ddd;
                                /* Default warna bintang: abu-abu */
                                transition: color 0.2s ease;
                                /* Efek transisi untuk perubahan warna */
                            }

                            .fa-star.checked {
                                color: #f39c12;
                                /* Warna emas untuk bintang yang terpilih */
                            }
                        </style>

                        <!-- Tombol untuk memuat lebih banyak ulasan -->
                        <div class="post-title-date" style="margin-top: 1.5rem;">
                            @if ($destination->ulasan->count() > 3)
                                <button id="load-more" data-destination-id="{{ $destination->id }}"
                                    class="btn btn-success"
                                    style="padding: 10px 20px; background-color: #28a745; border-color: #28a745; color: white; font-size: 1rem;">
                                    Tampilkan Lebih Banyak Ulasan
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="sidebar-widget-area pt-10 pl-lg-30">
                            <div class="sidebar-widget recent-post-widget mb-40 wow fadeInUp">
                                <h4 class="widget-title">Recent News</h4>
                                <ul class="recent-post-list">
                                    @foreach ($blogs as $blog)
                                        <li class="post-thumbnail-content">
                                            <img style="height: 130px"
                                                src="{{ asset('storage/images/blog/' . $blog->gambar) }}"
                                                alt="{{ $blog->judul }}">
                                            <div class="post-title-date">
                                                <h5><a
                                                        href="{{ route('wisatawan.blog-detail', ['slug' => $blog->slug]) }}">{{ $blog->judul }}</a>
                                                </h5>
                                                <span class="posted-on"><i class="far fa-calendar-alt"></i><a
                                                        href="#">{{ $blog->tanggal->format('d F Y') }}</a></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div style="display: none;" id="directions-container-2"></div>

                            {{-- calender  --}}
                            <div class="calendar-wrapper wow fadeInUp">
                                <div class="calendar-container mb-45"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section mbm-150">
        <div class="container-fluid">
            <div class="slider-active-5-item wow fadeInUp">
                @foreach ($galleries as $gallery)
                    <div class="single-gallery-item">
                        <div class="gallery-img">
                            <img src="{{ asset('storage/images/galeri/' . $gallery->gambar) }}" style="height: 300px">
                            <div class="hover-overlay">
                                <a href="{{ asset('storage/images/galeri/' . $gallery->gambar) }}"
                                    class="icon-btn img-popup">
                                    <i class="far fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- Mapbox CDN -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>

    <script>
        $(document).ready(function() {
            var currentPage = 1; // Mulai dari halaman pertama

            // Fungsi untuk inisialisasi rating stars (warna bintang)
            function initRatingStars() {
                // Loop untuk menangani rating di semua ulasan yang sudah ada atau dimuat
                $('.rating-container').each(function() {
                    const ratingContainer = $(this); // Simpan referensi container
                    const ratingValue = ratingContainer.data(
                        'rating'); // Ambil nilai rating dari data-attribute

                    // Reset warna bintang dengan class
                    ratingContainer.find('.fa-star').each(function(index) {
                        if (index < ratingValue) {
                            $(this).addClass('checked'); // Beri class untuk warna emas
                        } else {
                            $(this).removeClass('checked'); // Hapus class untuk warna abu-abu
                        }
                    });
                });
            }

            // Menambahkan efek hover untuk bintang
            $('.rating-container label').on('mouseenter', function() {
                const ratingValue = $(this).attr('for').replace('star', '') -
                    1; // Ambil nilai rating dari atribut 'for'

                const ratingLabels = $(this).closest('.rating-container').find(
                    'label'); // Semua label dalam container

                // Update warna semua bintang berdasarkan posisi indeks yang sedang dihover
                ratingLabels.each(function(index) {
                    if (index <= ratingValue) {
                        $(this).css('color', '#f39c12'); // Warna emas saat hover
                    } else {
                        $(this).css('color', '#ddd'); // Warna abu-abu untuk yang lain
                    }
                });
            });

            // Mengembalikan warna bintang setelah hover
            $('.rating-container label').on('mouseleave', function() {
                const selectedRating = $(this).closest('.rating-container').find(
                    'input[type="radio"]:checked').val(); // Ambil rating yang dipilih

                const ratingLabels = $(this).closest('.rating-container').find(
                    'label'); // Semua label dalam container

                // Update warna berdasarkan rating yang dipilih atau default
                ratingLabels.each(function(index) {
                    if (selectedRating && index < selectedRating) {
                        $(this).css('color', '#f39c12'); // Warna emas jika sudah dipilih
                    } else {
                        $(this).css('color', '#ddd'); // Warna abu-abu jika belum dipilih
                    }
                });
            });

            // Menambahkan event listener untuk input rating (untuk perubahan bintang saat klik)
            $('.rating-container input').on('change', function() {
                const ratingValue = $(this).val();
                const ratingLabels = $(this).closest('.rating-container').find('label');

                // Update warna bintang berdasarkan rating yang dipilih
                ratingLabels.each(function(index) {
                    if (index < ratingValue) {
                        $(this).css('color', '#f39c12'); // Warna emas
                    } else {
                        $(this).css('color', '#ddd'); // Warna abu-abu
                    }
                });
            });

            // Panggil fungsi pertama kali saat halaman dimuat
            initRatingStars();

            // Handling load more ulasan via AJAX
            $('#load-more').click(function() {
                var destinationId = $(this).data('destination-id'); // Ambil ID destinasi
                var button = $(this); // Simpan tombol untuk dihapus nanti

                currentPage++; // Naikkan halaman untuk request berikutnya

                $.ajax({
                    url: '/wisatawan/destinasi/' + destinationId + '/load-more-ulasan?page=' +
                        currentPage, // Kirimkan parameter page
                    method: 'GET',
                    success: function(response) {
                        // Tambahkan ulasan baru ke halaman
                        $('#load-more').before(response.html);

                        // Jika sudah tidak ada ulasan lebih lanjut
                        if (response.finished) {
                            button.remove(); // Hapus tombol jika tidak ada ulasan lagi
                        }

                        // Panggil kembali fungsi untuk inisialisasi ulang rating stars pada ulasan yang baru dimuat
                        initRatingStars();
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memuat ulasan. Coba lagi nanti.');
                    }
                });
            });

            // Menampilkan modal saat tombol Kirim ditekan
            $('#showRatingModal').click(function() {
                $('#ratingModal').modal('show');
            });

            // Menambahkan event listener untuk input rating di dalam modal
            $('#ratingModal input').on('change', function() {
                const ratingValue = $(this).val(); // Ambil nilai rating yang dipilih
                const ulasanText = $('textarea[name="ulasan"]').val(); // Ambil teks ulasan

                // Cek apakah pengguna sudah login
                @if (Auth::check()) // Laravel Blade directive untuk mengecek status login
                    // Kirim ulasan dan rating ke server
                    $.ajax({
                        url: '{{ route('wisatawan.ulasan.store', $destination->id) }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ulasan: ulasanText,
                            rating: ratingValue
                        },
                        success: function(response) {
                            if (response.success) {
                                // Tampilkan pesan sukses menggunakan SweetAlert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Ulasan berhasil dikirim!',
                                    text: 'Terima kasih atas ulasan Anda!',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Tutup modal
                                        $('#ratingModal').modal('hide');
                                        // Reset form ulasan
                                        $('textarea[name="ulasan"]').val('');
                                        // Refresh halaman setelah ulasan dikirim
                                        location
                                            .reload(); // Refresh halaman untuk melihat ulasan baru
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan!',
                                    text: 'Isi ulasan anda tidak boleh kosong.'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan!',
                                text: 'Isi ulasan anda tidak boleh kosong.'
                            });
                        }
                    });
                @else
                    // Jika belum login, tampilkan notifikasi dan arahkan ke halaman login
                    Swal.fire({
                        icon: 'warning',
                        title: 'Anda perlu login!',
                        text: 'Silakan login terlebih dahulu untuk memberikan rating.',
                        confirmButtonText: 'Login',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Arahkan pengguna ke halaman login
                            window.location.href =
                                '{{ route('wisatawan.login') }}'; // Ganti dengan URL halaman login Anda
                        }
                    });
                @endif
            });
        });
    </script>

    {{-- logika map  --}}
    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoibml6YW4iLCJhIjoiY2xtcmp2ZnR4MDdwaDJqbnQ0aHFzNDhvcyJ9.DljKUfMz4UuQs217X2Dwvg';

        document.addEventListener("DOMContentLoaded", function() {
            const mapEl = document.getElementById('map');
            const showRouteBtn = document.getElementById('show-route-btn');
            const startNavBtn = document.getElementById('start-navigation-btn');

            if (!mapEl) return;

            const lat = parseFloat(mapEl.dataset.lat);
            const lng = parseFloat(mapEl.dataset.lng);

            if (isNaN(lat) || isNaN(lng) || lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                console.error('Koordinat tidak valid:', lat, lng);
                return;
            }

            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [lng, lat],
                zoom: 14
            });

            const directions = new MapboxDirections({
                accessToken: mapboxgl.accessToken,
                interactive: false, // user tidak bisa input manual
                unit: 'metric',
                profile: 'mapbox/driving-traffic',
                controls: {
                    inputs: false, // kita tentukan titik lewat script
                    instructions: true
                },
                routeOptions: {
                    steps: true
                },
                language: 'id'
            });

            map.on('load', function() {
                map.resize();
                map.addControl(new mapboxgl.NavigationControl());

                // Tambahkan marker tujuan
                new mapboxgl.Marker()
                    .setLngLat([lng, lat])
                    .addTo(map);

                // Tambahkan panel directions tapi belum set rute
                const directionsContainer = document.getElementById('directions-container');
                if (directionsContainer) {
                    directionsContainer.appendChild(directions.onAdd(map));
                }
            });

            showRouteBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        directions.setOrigin([userLng, userLat]);
                        directions.setDestination([lng, lat]);

                        getPlaceName(userLat, userLng);
                    }, function() {
                        alert("Gagal mendapatkan lokasi Anda.");
                    });
                } else {
                    alert("Geolocation tidak didukung browser Anda.");
                }
            });

            // Tampilkan tombol "Mulai" setelah rute siap
            directions.on('route', function() {
                startNavBtn.style.display = 'inline-block';
            });

            // fungsi ketika diklik mulai maka mengarah ke halaman maps
            startNavBtn.addEventListener('click', function() {
                const origin = directions.getOrigin().geometry.coordinates;
                const destination = directions.getDestination().geometry.coordinates;

                const gmapsUrl =
                    `https://www.google.com/maps/dir/?api=1&origin=${origin[1]},${origin[0]}&destination=${destination[1]},${destination[0]}&travelmode=driving`;
                window.open(gmapsUrl, '_blank');
            });

            function getPlaceName(lat, lng) {
                fetch(
                        `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`
                    )
                    .then(response => response.json())
                    .then(data => {
                        const placeName = data.features[0]?.place_name;
                        const originNameEl = document.getElementById('origin-name');
                        if (originNameEl && placeName) {
                            originNameEl.innerText = placeName;
                        }
                    });
            }
        });
    </script>
    {{-- script untuk favorit --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const favoriteIcon = document.getElementById("favorite-icon");

            if (!favoriteIcon) return;

            const icon = favoriteIcon.querySelector("i");
            const destinationId = favoriteIcon.dataset.id;
            const isLoggedIn = favoriteIcon.dataset.loggedIn === "true";

            // Cek status favorit dari localStorage (optional)
            if (!isLoggedIn) {
                // Jika tidak login, hapus status favorit dari localStorage
                localStorage.removeItem("favorit_" + destinationId);
            }

            let isFavorit = localStorage.getItem("favorit_" + destinationId) === "true";

            updateIcon();

            favoriteIcon.addEventListener("click", function() {
                if (!isLoggedIn) {
                    // Redirect ke login jika belum login
                    window.location.href = "/wisatawan/Masuk";
                    return;
                }

                isFavorit = !isFavorit;

                fetch(`/wisatawan/favorit/toggle/${destinationId}`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content")
                        },
                        body: JSON.stringify({
                            status: isFavorit
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            localStorage.setItem("favorit_" + destinationId, isFavorit);
                            updateIcon();
                        }
                    })
                    .catch(error => {
                        console.error("Gagal toggle favorit:", error);
                    });
            });

            function updateIcon() {
                icon.classList.remove("fa-heart", "far", "fas");
                if (isFavorit) {
                    icon.classList.add("fas", "fa-heart");
                    icon.style.color = "red";
                } else {
                    icon.classList.add("far", "fa-heart");
                    icon.style.color = "gray";
                }
            }
        });
    </script>
@endpush
