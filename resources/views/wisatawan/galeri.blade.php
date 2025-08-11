@extends('layouts.wisatawan')

@section('title', 'Halaman Galeri')

@section('content')
    <section class="page-banner overlay pt-170 pb-170 bg_cover"
        style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-banner-content text-center text-white">
                        <h1 class="page-title">Gallery</h1>
                        <ul class="breadcrumb-link text-white">
                            <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                            <li class="active">Gallery</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                @foreach ($galleries as $galeri)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <!--=== Single Gallery Item ===-->
                        <div class="single-gallery-item mb-30 wow fadeInUp">
                            <div class="gallery-img">
                            <img src="{{ asset('storage/images/galeri/' . $galeri->gambar) }}" alt="Gallery Image"
                            style="width: 100%; height: 250px; object-fit: cover; border-radius: 8px;">
                                <div class="hover-overlay">
                                    <a href="{{ asset('storage/images/galeri/' . $galeri->gambar) }}"
                                        class="icon-btn img-popup"><i class="far fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
