@extends('layouts.wisatawan')

@section('title', 'Daftar Favorit')

@section('content')
    <!-- Start Page Banner -->
    <section class="page-banner overlay pt-170 pb-220 bg_cover"
        style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-banner-content text-center text-white">
                        <h1 class="page-title">Jelajahi Favorit</h1>
                        <ul class="breadcrumb-link text-white">
                            <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                            <li class="active">Favorit</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Page Banner -->

    <!-- Start Booking Section -->
    <section class="booking-form-section pb-100">
        <div class="container-fluid pb-5">
            <div class="booking-form-wrapper p-r z-2">
                <div class="container">
                    <div class="row justify-content-center">
                        @forelse ($destinations as $destination)
                            <div class="col-xl-4 col-md-6 col-sm-12 places-column">
                                <!-- Single Place Item -->
                                <div class="single-place-item mb-60 wow fadeInUp">
                                    <div class="place-img">
                                        <img src="{{ asset('storage/images/destinasi/' . $destination->gambar) }}"
                                            width="410px" height="280px">
                                    </div>
                                    <div class="place-content">
                                        <div class="info">
                                            <h4 class="title">
                                                <a
                                                    href="{{ route('wisatawan.detail_destinasi', ['id' => $destination->id]) }}">
                                                    {{ $destination->tujuan }}
                                                </a>
                                            </h4>
                                            <p>
                                                {{ Str::limit(strip_tags($destination->desk), 150) }}
                                            </p>
                                            <div align="right" class="meta">
                                                <span><a
                                                        href="{{ route('wisatawan.detail_destinasi', ['id' => $destination->id]) }}">Details<i
                                                            class="far fa-long-arrow-right"></i></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center">
                                <p class="text-muted">Belum ada destinasi di Favorit ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="gowilds-pagination wow fadeInDown mt-60 mb-30">
                                <li>
                                    @if ($destinations->currentPage() > 1)
                                        <a href="{{ $destinations->previousPageUrl() }}"><i
                                                class="far fa-arrow-left"></i></a>
                                    @endif
                                </li>
                                @for ($x = 1; $x <= $destinations->lastPage(); $x++)
                                    <li class="page-item">
                                        <a class="page-link {{ $x == $destinations->currentPage() ? 'active' : '' }}"
                                            href="{{ $destinations->url($x) }}">{{ $x }}</a>
                                    </li>
                                @endfor
                                <li>
                                    @if ($destinations->hasMorePages())
                                        <a href="{{ $destinations->nextPageUrl() }}"><i class="far fa-arrow-right"></i></a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Gallery Section -->
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
