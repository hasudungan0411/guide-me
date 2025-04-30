@extends('layouts.wisatawan')

@section('title', 'Kategori: ' . $category->nama_kategori)

@section('content')
<section class="page-banner overlay pt-170 pb-220 bg_cover"
    style="background-image: url({{ asset('assets/wisatawan/images/bg/page-bg.png') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-banner-content text-center text-white">
                    <h1 class="page-title">Kategori: {{ $category->nama_kategori }}</h1>
                    <ul class="breadcrumb-link text-white">
                        <li><a href="{{ route('wisatawan.home') }}">Home</a></li>
                        <li><a href="{{ route('wisatawan.kategori-destinasi') }}">Kategori</a></li>
                        <li class="active">{{ $category->nama_kategori }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pt-70 pb-70">
    <div class="container">
        <div class="row">
            @forelse ($destinations as $destination)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/images/destinasi/' . $destination->gambar) }}" alt="{{ $destination->tujuan }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $destination->tujuan }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($destination->desk, 100) }}</p>
                            <a href="{{ route('wisatawan.detail_destinasi', $destination->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada destinasi di kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
