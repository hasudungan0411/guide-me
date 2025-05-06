@extends('layouts.wisatawan')

@section('title', 'Halaman Kategori Destinasi')

@section('content')
    <section class="page-banner overlay pt-170 pb-220 bg_cover"
        style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-banner-content text-center text-white">
                        <h1 class="page-title">Kategori</h1>
                        <ul class="breadcrumb-link text-white">
                            <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                            <li class="active">Kategori</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-form-section pb-100">
        <div class="container-fluid pb-5">
            <div class="booking-form-wrapper p-r z-2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="row">
                            @foreach ($categories as $kategori)
                                <div class="col-xl-4 col-md-6 col-sm-12 places-column">
                                    <!-- Single Place Item -->
                                    <div class="single-place-item mb-60 wow fadeInUp">
                                        <div class="place-img">
                                            <img src="{{ asset('storage/images/kategori/' . $kategori->gambar) }}"
                                                width="410px" height="280px">
                                        </div>
                                        <div class="place-content">
                                            <div class="info">
                                                <h4 class="card-title">
                                                    <a
                                                        href="{{ route('wisatawan.destinasi-by-kategori', $kategori->id_kategori) }}">{{ $kategori->nama_kategori }}
                                                    </a>
                                                </h4>
                                                <div align="right" class="meta">
                                                    <span><a
                                                            href="{{ route('wisatawan.destinasi-by-kategori', $kategori->id_kategori) }}">Cek
                                                            Destinasi<i class="far fa-long-arrow-right"></i></a></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="gallery-section mbm-150">
        <div class="container-fluid">
            <div class="slider-active-5-item wow fadeInUp">
                @foreach ($gallery as $galeri)
                    <div class="single-gallery-item">
                        <div class="gallery-img">
                            <img src="{{ asset('storage/images/galeri/' . $galeri->gambar) }}" style="height: 300px">
                            <div class="hover-overlay">
                                <a href="{{ asset('images/galeri/' . $galeri->gambar) }}" class="icon-btn img-popup"><i
                                        class="far fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
