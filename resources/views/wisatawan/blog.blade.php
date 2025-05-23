@extends('layouts.wisatawan')

@section('title', 'Halaman Blog')

@section('content')
<section class="page-banner overlay pt-170 pb-170 bg_cover"
    style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-banner-content text-center text-white">
                    <h1 class="page-title">Daftar Blog</h1>
                    <ul class="breadcrumb-link text-white">
                        <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                        <li class="active">Blog</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="blog-list-section pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="blog-list-wrapper">
                    @foreach ($blogs as $blog)
                        <div class="single-blog-post-four mb-30 wow fadeInDown">
                            <div class="post-thumbnail">
                                <img src="{{ asset('storage/images/blog/' . $blog->gambar) }}" height="320px">
                            </div>
                            <div class="entry-content">
                                <div class="post-meta">
                                    <span><i class="far fa-calendar-alt"></i><a
                                            href="#">{{ \Carbon\Carbon::parse($blog->tanggal)->format('d F Y') }}</a></span>
                                </div>
                                <h3 class="title">
                                    <a href="{{ route('wisatawan.blog-detail', $blog->slug) }}">{{ $blog->judul }}</a>
                                </h3>
                                <h6 class="author"><i class="far fa-user"></i><a href="#">Admin</a></h6>
                                <a href="{{ route('wisatawan.blog-detail', $blog->slug) }}"
                                    class="main-btn filled-btn">Selengkapnya <i class="fas fa-paper-plane"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper mt-4">
                    {{ $blogs->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <div class="col-xl-4">
                <div class="sidebar-widget-area">
                    <!-- Kategori -->
                    <div class="sidebar-widget category-widget mb-30 wow fadeInUp">
                        <h4 class="widget-title">Kategori</h4>
                        <ul class="category-nav">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('wisatawan.blog-kategori', $category->id_kategori) }}">
                                        {{ $category->nama_kategori }} <i class="far fa-arrow-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recent Blog -->
                    <div class="sidebar-widget recent-post-widget mb-40 wow fadeInUp">
                        <h4 class="widget-title">Recent News</h4>
                        <ul class="recent-post-list">
                            @php
                                $recentBlogs = \App\Models\Blog::inRandomOrder()->limit(3)->get();
                            @endphp
                            @foreach ($recentBlogs as $recent)
                                <li class="post-thumbnail-content d-flex">
                                    <img style="height: 130px; margin-right: 10px;" src="{{ asset('storage/images/blog/' . $recent->gambar) }}"
                                        alt="{{ $recent->judul }}">
                                    <div class="post-title-date">
                                        <h5><a href="{{ route('wisatawan.blog-detail', $recent->slug) }}">{{ $recent->judul }}</a></h5>
                                        <span class="posted-on"><i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($recent->tanggal)->format('d F Y') }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galeri Slider -->
<section class="gallery-section mbm-150">
    <div class="container-fluid">
        <div class="slider-active-5-item wow fadeInUp">
            @foreach ($galleries as $gallery)
                <div class="single-gallery-item">
                    <div class="gallery-img">
                        <img src="{{ asset('storage/images/galeri/' . $gallery->gambar) }}" style="height: 300px">
                        <div class="hover-overlay">
                            <a href="{{ asset('storage/images/galeri/' . $gallery->gambar) }}" class="icon-btn img-popup">
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
