@extends('layouts.wisatawan')

@section('title', 'Pesanan')

@section('content')
    <section class="page-banner overlay pt-170 pb-170 bg_cover" style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png')}});">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="page-banner-content text-center text-white">
                        <h1 class="page-title">Pesanan</h1>
                        <ul class="breadcrumb-link text-white">
                            <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                            <li class="active">Pesanan</li>
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
                        @foreach ($transaksi as $item)
                            <div class="single-blog-post-four mb-30 wow fadeInDown">
                                <div class="post-thumbnail">
                                    <img src="{{ asset('storage/images/destinasi/' . $item->destinasi->gambar) }}" height="320px">
                                </div>
                                <div class="entry-content">
                                    <div class="post-meta">
                                        <span><i class="far fa-calendar-alt"></i><a href="#">{{ \Carbon\Carbon::parse($item->Tanggal_Transaksi)->format('d F Y') }}</a></span>
                                        <span class="
                                        btn
                                            @if($item->Status === 'Paid') btn-success
                                            @elseif($item->Status === 'Sudah Digunakan') btn-primary
                                            @elseif($item->Status === 'Pending') btn-warning
                                            @elseif($item->Status === 'Batal' || $item->Status === 'Hangus') btn-danger
                                            @endif
                                    ">
                                        {{ $item->Status }}</span>
                                    </div>
                                    <h3 class="title">
                                        <a href="{{ route('wisatawan.detail_destinasi', $item->destinasi->id) }}">{{ $item->destinasi->tujuan }}</a>
                                    </h3>
                                    <h6 class="author"><i class="far fa-user"></i><a href="#">{{ $item->ID_Tiket }}</a></h6>
                                    <a href="{{ route('wisatawan.tiket-detail', $item->ID_Transaksi) }}"
                                        class="main-btn filled-btn">Detail Tiket <i class="fas fa-ticket"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="sidebar-widget-area">
                        <!-- Calendar -->
                        <div class="calendar-wrapper wow fadeInUp">
                            <div class="calendar-container mb-45"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
