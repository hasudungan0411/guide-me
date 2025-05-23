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
                                <h5 class="card-title"><span class="stats-change stats-change-success"> Pembelian
                                        Tiket</span></h5>
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
            </div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center py-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-lg w-100">
                            <div class="card-body d-flex flex-column align-items-center p-5">
                                <h1 class="display-3 text-center text-primary font-weight-bold mb-4"
                                    style="font-size: clamp(35px, 7vw, 50px);">
                                    Welcome to {{ $pemilik->Nama_Wisata }}
                                </h1>
                                <h2 class="text-center text-muted mb-5" style="font-size: clamp(18px, 4vw, 32px);">
                                    Lokasi: {{ $pemilik->Lokasi }}
                                </h2>

                                <div class="text-justify"
                                    style="font-size: clamp(16px, 4vw, 24px);">
                                    {{ strip_tags($destinasi->long_desk) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
