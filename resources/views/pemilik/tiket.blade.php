@extends('layouts.pemilik')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pemilik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tiket</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Destinasi {{ $destinasi->tujuan }}</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('tiket.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group col-md-4">
                                    <label>Stok Tiket</label>
                                    <input name="Persediaan" type="number" class="form-control" id="Persediaan" min="0" required
                                    value="{{ $tiket->Persediaan }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Harga</label>
                                    <input name="Harga" type="number" class="form-control" id="Harga" min="0" required
                                    value="{{ $tiket->Harga }}"value="{{ old('Harga', $tiket->Harga ?? '') }}">
                                </div>

                                <button id="submitBtn" type="submit" class="btn btn-primary mt-3">Update Tiket</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Metode Pembayaran</h5>
                        <form action="{{ route('pemilik.rekening_update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group col-md-4">
                                <label>Nomor Rekening</label>
                                <input name="nomor_rekening" type="text" class="form-control" required
                                    value="{{ old('nomor_rekening', $pemilik->Nomor_Rekening ?? '') }}">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Upload Gambar Qris</label>
                                <input type="file" name="gambar_qris" class="form-control-file" accept="image/*">
                            </div>

                            @if($pemilik->Qris)
                                <div class="form-group col-md-4">
                                    <label>Gambar Saat Ini:</label><br>
                                    <img src="{{ asset('gambar_qris/' . $pemilik->Qris) }}" alt="{{ $pemilik->Qris }}" style="max-width:400px;">
                                </div>
                            @endif

                            <button type="submitBtn" class="btn btn-primary mt-3">Update Rekening & Qris</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
