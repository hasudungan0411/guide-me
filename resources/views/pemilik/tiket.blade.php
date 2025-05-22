@extends('layouts.pemilik')

@section('title', 'Dashboard')

@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Pemilik</a></li>
                <li class="breadcrumb-item active" aria-current="page">Acara</li>
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
            </div>
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
    </div>
</div>
@endsection
