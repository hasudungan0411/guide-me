@extends('layouts.admin')

@section('title', 'Tambah Galeri')
    
@section('content')

<div class="page-content">
    <div class="page-info">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Data</a></li>
                <li class="breadcrumb-item"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
    <div class="main-wrapper">
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('galeri.index') }}" class="btn btn-primary mb-3">Kembali</a>
                        <h5 class="card-title">Tambah Galeri</h5>
                        <form action="{{ route('galeri.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="gambar">Gambar</label>
                                    <input type="file" name="gambar" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection