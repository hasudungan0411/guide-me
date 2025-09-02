@extends('layouts.wisatawan')

@section('title', 'Halaman Detail Acara')

@section('content')

    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">
                {{ $acara->Nama_acara }}
            </h2>
        </div>

        <div class="text-center mb-10">
            <img src="{{ asset('storage/images/event/' . $acara->Gambar_acara) }}" alt=""
                style="max-width: 100%; max-height: 500px; object-fit: cover; border-radius: 10px;">

            <h6 style="text-center; margin-top: 20px;">
                Mulai pada tanggal {{ \Carbon\Carbon::parse($acara->Tanggal_mulai_acara)->translatedFormat('d F Y') }}
                hingga berakhir pada tanggal
                {{ \Carbon\Carbon::parse($acara->Tanggal_berakhir_acara)->translatedFormat('d F Y') }}
            </h6>
        </div>

        <div class="mt-60" style="text-center font-size: 16px; color: #333; text-align: justify;">
            {{ strip_tags($acara->Deskripsi) }}
        </div>

        <div class="text-center mt-40">
            <a href="{{ url()->previous() }}" class="btn btn-info"> <- Kembali </a>
        </div>

    </div>

@endsection
