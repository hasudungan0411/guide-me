@extends('layouts.wisatawan')

@section('title', 'Home')

@section('content')
    <section class="hero-section">
        <div class="hero-wrapper-three">
            <div class="hero-arrows"></div>
            <div class="hero-slider-three">
                @foreach ($destinations as $destination)
                    <div class="single-slider">
                        <div class="image-layer bg_cover"
                            style="background-image: url('{{ asset('storage/images/destinasi/' . $destination->gambar) }}')">
                        </div>
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-xl-7">
                                    <div class="hero-content text-white">
                                        <span class="sub-title">Selamat datang di Guide Me</span>
                                        <h1 data-animation="fadeInDown" data-delay=".4s">Penunjuk arah tempat wisata Batam
                                        </h1>
                                        <div class="hero-button" data-animation="fadeInRight" data-delay=".6s">
                                            <a href="{{ route('wisatawan.destinasi') }}" class="main-btn primary-btn">
                                                Lihat Destinasi <i class="fas fa-paper-plane"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="start" class="features-section pt-100 pb-50">
        <div class="container">
            <div class="row align-items-xl-center">
                <div class="col-xl-5">
                    <!--=== Features Content Box ===-->
                    <div class="features-content-box pr-lg-70 mb-50">
                        <!--=== Section Title ===-->
                        <div class="section-title mb-30">
                            <span class="sub-title">Kenapa harus MeGuide ?</span>
                            <h2>Destinasi wisata batam terangkum semuanya di sini</h2>
                        </div>
                        <p class="mb-30">Mulai dari wisata dan tempat-tempat yang unik bisa anda temukan di batam,
                            butuh jodoh ? ada di batam, Es teh ? Teh Obenk kaka :).
                        </p>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="features-item-area mb-20">
                        <div class="row pl-lg-70">
                            <div class="col-md-6">
                                <!--=== Fancy Icon Box ===-->
                                <div class="fancy-icon-box-two mb-30">
                                    <div class="icon">
                                        <i class="flaticon-camping"></i>
                                    </div>
                                    <div class="text">
                                        <h3 class="title">Tempat Berkemah</h3>
                                        <p style="text-align: justify">Bnyak tempat dibatam yang bisa jadikan bumi permekemahan, berkemah nuansa pantai
                                            dan hutan juga tersedia</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--=== Fancy Icon Box ===-->
                                <div class="fancy-icon-box-two mb-30">
                                    <div class="icon">
                                        <i class="flaticon-biking-mountain"></i>
                                    </div>
                                    <div class="text">
                                        <h3 class="title">Perbukitan</h3>
                                        <p>Banyak bukit di batam yang bisa dijadikan alternative bagi yang tidak suka naik
                                            gunung, di Batam adanya Bukit saja :)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--=== Fancy Icon Box ===-->
                                <div class="fancy-icon-box-two mb-30">
                                    <div class="icon">
                                        <i class="flaticon-fishing-2"></i>
                                    </div>
                                    <div class="text">
                                        <h3 class="title">Pantai</h3>
                                        <p>Pantai di batam sangat banyak, mualai dari pantai nuansa tradisional bahkan
                                            modern juga ada, pilihannya banyak :)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!--=== Fancy Icon Box ===-->
                                <div class="fancy-icon-box-two mb-30">
                                    <div class="icon">
                                        <i class="flaticon-caravan"></i>
                                    </div>
                                    <div class="text">
                                        <h3 class="title">Hutan</h3>
                                        <p>Walaupun batam terkenal dengan kota industri batam masih punya hutan yang dapat
                                            dikunjungi, ada yang hutan wisata dan ada juga hutan yang dilindungi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service-section pt-100 pb-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <div class="section-title text-center mb-50">
                        <span class="sub-title">Destinasi Pilihan</span>
                        <h2>Tempat Wisata Batam Paling Popular</h2>
                    </div>
                </div>
            </div>
            <div class="slider-active-3-item">
                @foreach ($recommendedItems as $item)
                    <div class="single-service-item-three mb-40">
                        <div class="content">
                            <img style="height: 250px" src="{{ asset('storage/images/destinasi/' . $item->gambar) }}"
                                alt="service image">
                            <h3 class="title">
                                <a href="">{{ $item->tujuan }}</a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($item->desk), 150) }}</p>
                            <div class="meta">
                                <span class="rate">
                                    <a href="{{ route('wisatawan.detail_destinasi', $item->id) }}"
                                        class="btn-link">Selengkapnya <i class="far fa-long-arrow-right"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="cta-bg overlay bg_cover pt-150 pb-150"
        style="background-image: url(https://blog.tiket.com/wp-content/uploads/2023/06/3.-Barelang-bridge.jpg);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-8">
                    <div class="cta-content-box text-white">
                        <h2 class="mb-35">Siap Berwisata Dengan Petualangan Nyata dan Menikmati Alam</h2>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-4">
                    <div class="play-box text-center">
                        <a href="https://www.youtube.com/watch?v=c43_GKscPQk" class="video-popup"><i
                                class="fas fa-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--====== Start Gallery Section ======-->
    <section class="gallery-section-two pb-100 pt-150">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                    <!--=== Section Title ===-->
                    <div class="section-title text-center mb-50">
                        <span class="sub-title">Destinasi</span>
                        <h2>Tempat Wisata<br>Batam</h2>
                    </div>
                </div>
            </div>

            <!--=== Gallery Slider ===-->
            <div class="slider-active-3-item-dot">
                @foreach ($destinations as $destination)
                    <div class="single-gallery-item-two">
                        <div class="img-holder">
                            <img style="height: 400px;"
                                src="{{ asset('storage/images/destinasi/' . $destination->gambar) }}" alt="Gallery Image">
                        </div>
                        <div class="content">
                            <a href="{{ route('wisatawan.detail_destinasi', $destination->id) }}">
                                <h3 class="title">{{ $destination->tujuan }}</h3>
                            </a>
                            <p>{{ Str::limit(strip_tags($destination->desk), 150, '...') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="blog-section pt-80 pb-80 mb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-title text-center mb-45">
                        <span class="sub-title">Blog</span>
                        <h2>Blog Terbaru</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach ($blogs as $row)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="single-blog-post-three mb-40">
                            <div class="post-thumbnail">
                                <img style="height: 290px;" src="{{ asset('storage/images/blog/' . $row->gambar) }}"
                                    alt="Blog Image">
                            </div>
                            <div class="entry-content">
                                <div class="post-meta">
                                    <span><i class="far fa-calendar-alt"></i> {{ $row->tanggal }}</span>
                                    <h3 class="title">
                                        <a
                                            href="{{ route('wisatawan.blog-detail', $row->slug) }}">{{ $row->judul }}</a>
                                    </h3>
                                    <a href="{{ route('wisatawan.blog-detail', $row->slug) }}"
                                        class="main-btn filled-btn">Selengkapnya<i class="far fa-paper-plane"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!--====== Start Gallery Section ======-->
    <section class="gallery-section mbm-150">
        <div class="container-fluid">
            <div class="slider-active-5-item wow fadeInUp">
                <!--=== Single Gallery Item ===-->
                @foreach ($galery as $item)
                    <div class="single-gallery-item">
                        <div class="gallery-img">
                            <img src="{{ asset('storage/images/galeri/' . $item->gambar) }}" alt="Gallery Image">
                            <div class="hover-overlay">
                                <a href="{{ asset('storage/images/galeri/' . $item->gambar) }}"
                                    class="icon-btn img-popup"><i class="far fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
