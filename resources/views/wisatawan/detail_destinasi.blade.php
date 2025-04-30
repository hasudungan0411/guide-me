@extends('layouts.wisatawan')

@section('title', 'Detail Destinasi')

@push('styles')
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet" />
    <link href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" rel="stylesheet" />
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
                                    src="{{ asset('storage/images/destinasi/' . $destination->$gambar) }}" alt="Place Image">
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Details and Map Section -->
        <div class="container" style="height: auto; margin-bottom: 350px">
            <div class="tour_details-wrapper pt-80">
                <div class="tour-title-wrapper pb-12 wow fadeInUp">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="tour-title mb-20">
                                <h3 class="title">
                                    {{ $destination->tujuan }}
                                </h3>
                                <p><i class="far fa-map-marker-alt mb-40"></i>Batam, Kepulauan Riau</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="row">
                    <div class="col-xl-8">
                        <div class="place-content-wrap pt-10 wow fadeInUp" style="margin-top: -51px !important;">
                            <p>{!! strip_tags($destination->desk) !!}</p>
                            <h4 class="mt-4">Deskripsi</h4>
                            <p class="mb-3">{!! strip_tags($destination->long_desk) !!}</p>
                            <h4 class="mt-4">Navigasi</h4>
                            <p class="mb-3">Berikut ini adalah navigasi ke <b>{{ $destination->tujuan }}</b>, anda dapat
                                melihat peta di bagian bawah dan navigasi di bagian sisi kanan.</p>
                        </div>

                        <!--=== Map Box ===-->
                        <div class="map-box mb-60 wow fadeInUp">
                            <div class="map-box">
                                <div id="map" data-lng="{{ $destination->latitude }}"
                                    data-lat="{{ $destination->longitude }}" style="height: 500px; border-radius: 8px;">
                               </div>                               

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
                                <a href="{{ asset('images/galeri/' . $gallery->gambar) }}" class="icon-btn img-popup"><i
                                        class="far fa-plus"></i></a>
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

        document.addEventListener("DOMContentLoaded", function () {
            const mapEl = document.getElementById('map');
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
                interactive: false,
                unit: 'metric',
                profile: 'mapbox/driving-traffic',
                controls: {
                    instructions: true
                },
                routeOptions: {
                    steps: true
                },
                language: 'id'
            });

            map.on('load', function () {
                map.resize();

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        directions.setOrigin([userLng, userLat]);
                        directions.setDestination([lng, lat]);

                        getPlaceName(userLat, userLng);
                    });
                }

                // Tambahkan marker lokasi tujuan
                new mapboxgl.Marker()
                    .setLngLat([lng, lat])
                    .addTo(map);
            });

            function getPlaceName(lat, lng) {
                fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`)
                    .then(response => response.json())
                    .then(data => {
                        const placeName = data.features[0]?.place_name;
                        const originNameEl = document.getElementById('origin-name');
                        if (originNameEl && placeName) {
                            originNameEl.innerText = placeName;
                        }
                    });
            }

            // Tambahkan directions panel ke kanan peta jika kamu pakai container-nya
            const directionsContainer = document.getElementById('directions-container');
            if (directionsContainer) {
                directionsContainer.appendChild(directions.onAdd(map));
            }
        });
    </script>
@endpush
