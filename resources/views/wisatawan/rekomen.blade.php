@extends('layouts.wisatawan')

@section('title', 'Halaman Kategori Destinasi')

@section('content')

<section class="service-section pt-100 pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-7">
                <div class="section-title text-center mb-50">
                    <span class="sub-title">Destinasi Pilihan</span>
                    <h2>Rekomendasi Untuk Anda</h2>
                </div>
            </div>
        </div>
        <div class="slider-active-3-item">
            @forelse ($recommendedItems as $item)
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
            @empty
                <p>Tidak ada rekomendasi saat ini.</p>
            @endforelse
        </div>
    </div>
</section>

@endsection
