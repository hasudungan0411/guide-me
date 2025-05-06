@extends('layouts.admin')

@section('title', 'Detail Kategori')
    
@section('content')
<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('kategori.index') }}" class="btn btn-primary mb-3">Kembali</a>
                        <h5 class="card-title">Detail kategori {{ $kategori->nama_kategori }}</h5>
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                        <label for="inputLatitude">Kategori</label>
                                        <input type="text" class="form-control" id="inputJudul" placeholder="" value="{{ $kategori->nama_kategori }}" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                <label for="inputZip">Gambar</label>
                                    <div class="card bg-dark text-white" >
                                        <img style="max-width: 100%; height: auto;" src="{{ asset('storage/images/kategori/' . $kategori->gambar ) }}" class="card-img" alt="...">
                                        <div class="card-img-overlay">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection