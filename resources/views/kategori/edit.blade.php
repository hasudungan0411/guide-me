@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kategori</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('kategori.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Data kategori {{ $kategori->nama_kategori }}</h5>
                            <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id_kategori" value="{{ $kategori->id_kategori }}">
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="inputLatitude">Kategori</label>
                                        <input name="nama_kategori" type="text" class="form-control" id="inputLatitude"
                                            placeholder="" value="{{ $kategori->nama_kategori }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="inputZip">Gambar</label>
                                        <div class="card bg-dark text-white">
                                            <img style="max-width: 100%; height: auto;"
                                                src="{{ asset('storage/images/kategori/' . $kategori->gambar) }}"
                                                class="card-img" alt="...">
                                            <div class="card-img-overlay">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="gambar" class="form-control" id="inputgambar">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-5">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
