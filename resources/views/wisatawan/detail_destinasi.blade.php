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
                                <img style="width: 950px; height: 630px;"
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
                            <p>{!! strip_tags($destination->desk) !!}</p>
                            <h4 class="mt-4">Deskripsi</h4>
                            <p class="mb-3">{!! strip_tags($destination->long_desk) !!}</p>

                            <!--=== Acara Section ===-->
                            <h4 class="mt-4">Acara di {{ $destination->tujuan }}</h4>
                            @if ($acara->isEmpty())
                                <p>Tidak ada event yang tersedia untuk destinasi ini.</p>
                            @else
                                <ul>
                                    @foreach ($acara as $event)
                                        <li>
                                            <h6>{{ $event->Nama_acara }}</h6>
                                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                                data-bs-target="#eventModal{{ $event->id }}">
                                                Lihat
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1"
                                                aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="eventModalLabel{{ $event->id }}">
                                                                {{ $event->Nama_acara }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Tutup"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Tanggal:</strong>
                                                                {{ \Carbon\Carbon::parse($event->Tanggal_acara)->format('d F Y') }}
                                                            </p>
                                                            <p><strong>Deskripsi:</strong></p>
                                                            <p>{!! strip_tags($event->Deskripsi ?? 'Belum ada deskripsi.') !!}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <h4 class="mt-4">Beli Tiket</h4>
                            <!-- pesantiket -->
                            @if($tiket)
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#tiketModal">
                                    Pesan Tiket
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="tiketModal" tabindex="-1"
                                    aria-labelledby="tiketModalLabel" aria-hidden="true">
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
                                                <form action="{{ route('wisatawan.konfirmasi') }}" method="GET" enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="ID_Wisata" value="{{ $destination->id }}">
                                                    <input type="hidden" name="Harga_Satuan" value="{{ $tiket->Harga }}">

                                                    <div class="form-group col-md-4">
                                                        <input name="Jumlah_Tiket" type="number" class="form-control" id="Tiket" min="0" required>
                                                    </div>

                                                    <div class="modal-footer mt-4">
                                                        <button id="submitBtn" type="submit" class="btn btn-primary mt-3">Pesan Tiket</button>
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
                                <div id="map" data-lng="{{ $destination->latitude }}"
                                    data-lat="{{ $destination->longitude }}"
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

                        <!--=== Disqus Comments ===-->
                        <div id="disqus_thread"></div>
                        <script>
                            (function() {
                                var d = document,
                                    s = d.createElement('script');
                                s.src = 'https://meguide-org.disqus.com/embed.js';
                                s.setAttribute('data-timestamp', +new Date());
                                (d.head || d.body).appendChild(s);
                            })();
                        </script>
                        <noscript>Please enable JavaScript to view the
                            <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a>
                        </noscript>
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
                                                        href="{{ route('blog.show', ['slug' => $blog->slug]) }}">{{ $blog->judul }}</a>
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
