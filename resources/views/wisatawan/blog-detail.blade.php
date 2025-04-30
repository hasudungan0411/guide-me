@extends('layouts.wisatawan')

@section('title', 'Detail Kategori')

@section('content')
    <section class="page-banner overlay pt-170 pb-170 bg_cover"
        style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }})">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-banner-content text-center text-white">
                        <h1 class="page-title">Blog Details</h1>
                        <ul class="breadcrumb-link text-white">
                            <li><a href="{{ route('wisatawan.blog') }}">Home</a></li>
                            <li class="active">Blog Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-details-section pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <!--=== Blog Details Wrapper ===-->
                    <div class="blog-details-wrapper pr-lg-50">
                        <div class="blog-post mb-60 wow fadeInUp">
                            <div class="post-thumbnail">
                                <!-- Gambar Blog -->
                                <img src="{{ asset('storage/images/blog/' . $blog->gambar) }}" alt="Blog Image"
                                    height="465px">
                            </div>
                            <div class="post-meta text-center pt-25 pb-15 mb-25">
                                <span><i class="far fa-user"></i><a href="#">Admin</a></span>
                                <span><i class="far fa-calendar-alt"></i><a
                                        href="#">{{ \Carbon\Carbon::parse($blog->tanggal)->format('d F Y') }}</a></span>
                                <span><i class="far fa-category"></i><a
                                        href="#">{{ $blog->kategori->nama_kategori }}</a></span>
                            </div>
                            <div class="main-post">
                                <div class="entry-content">
                                    <h3 class="title">{{ $blog->judul }}</h3>
                                    <p>{{ $blog->deskripsi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Disqus --}}
                        <div class="pb-30 mb-55 wow fadeInUp" style="max-width: 100%; width: 100%; margin: 0 auto;">
                            <div id="disqus_thread"></div>

                            <script>
                                var disqus_config = function() {
                                    this.page.url = "{{ Request::url() }}"; // URL halaman saat ini
                                    this.page.identifier = "{{ $blog->slug }}"; // Unique identifier dari blog
                                };

                                (function() {
                                    var d = document,
                                        s = d.createElement('script');
                                    s.src = 'https://meguide-org.disqus.com/embed.js'; // Ganti sesuai shortname Disqus kamu
                                    s.setAttribute('data-timestamp', +new Date());
                                    (d.head || d.body).appendChild(s);
                                })();
                            </script>

                            <noscript>Silakan aktifkan JavaScript untuk melihat <a
                                    href="https://disqus.com/?ref_noscript">komentar Disqus</a>.</noscript>
                        </div>
                    </div>
                </div>

                <!-- Sidebar for Categories and Recent Posts -->
                <div class="col-xl-4">
                    <div class="sidebar-widget-area">
                        <!--=== Category Widget ===-->
                        <div class="sidebar-widget category-widget mb-30 wow fadeInUp">
                            <h4 class="widget-title">Kategori</h4>
                            <ul class="category-nav">
                                @foreach ($categories as $category)
                                    <li><a href="{{ route('wisatawan.blog-kategori', $category->id_kategori) }}">{{ $category->nama_kategori }}<i
                                                class="far fa-arrow-right"></i></a></li>
                                @endforeach
                            </ul>
                        </div>

                        <!--=== Recent Post Widget ===-->
                        <div class="sidebar-widget recent-post-widget mb-40 wow fadeInUp">
                            <h4 class="widget-title">Saran Berita</h4>
                            <ul class="recent-post-list">
                                @foreach ($recentPosts as $post)
                                    <li class="post-thumbnail-content">
                                        <img style="height: 130px"
                                            src="{{ asset('storage/images/blog/' . $post->gambar) }}"
                                            alt="{{ $post->judul }}">
                                        <div class="post-title-date">
                                            <h5><a
                                                    href="{{ route('wisatawan.blog-detail', $post->slug) }}">{{ $post->judul }}</a>
                                            </h5>
                                            <span class="posted-on"><i class="far fa-calendar-alt"></i><a
                                                    href="#">{{ \Carbon\Carbon::parse($post->tanggal)->format('d F Y') }}</a></span>
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
