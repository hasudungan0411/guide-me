@extends('layouts.pemilik')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pemilik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row stats-row">
            <div class="col-lg-4 col-md-12">
                <div class="card card-transparent stats-card">
                    <div class="card-body">
                        <div class="stats-info">
                            <h5 class="card-title"><span class="stats-change stats-change-success"> Acara</span></h5>
                            <p class="stats-text">Total Pembelian Tiket</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="card card-transparent stats-card">
                    <div class="card-body">
                        <div class="stats-info">
                            <h5 class="card-title"><span class="stats-change stats-change-success"> Tiket</span></h5>
                            <p class="stats-text">Stok Tiket</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-md-12">
                <div class="card card-transparent stats-card">
                    <div class="card-body">
                        <div class="stats-info">
                            <h5 class="card-title"><span class="stats-change stats-change-success"> </span></h5>
                            <p class="stats-text">Total gambar saat ini</p>
                        </div>  
                    </div>
                </div>
            </div> -->
        </div>
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h1 style="font-size: clamp(30px, 5vw, 50px);">Welcome {{ $pemilik->Email }}</h1>
                        <h2 style="font-size: clamp(20px, 4vw, 34px);">Pemilik Wisata {{ $destinasi->tujuan }}</h>
                        
                        <h4 style="font-size: clamp(14px, 4vw, 24px); text-align: justify;"><br>{{ $destinasi->long_desk ?? 'Deskripsi wisata belum tersedia.' }}</h>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
