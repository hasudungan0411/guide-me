@extends('layouts.admin')

@section('title', 'Tambah Akun Pemilik Wisata')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">MeGuide</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('akun_pemilik-wisata.index') }}">Kelola Akun Pemilik</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
                </ol>
            </nav>
        </div>

        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('akun_pemilik-wisata.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Akun Pemilik Wisata</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('akun_pemilik-wisata.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail">Email</label>
                                        <input type="text" name="email" class="form-control" id="inputEmail"
                                            value="{{ old('email') }}" placeholder="example@misal.com" required>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputNomorHP">Nomor HP</label>
                                        <input type="text" name="nomor_hp" class="form-control" id="inputNomorHP"
                                            value="{{ old('nomor_hp') }}" required>
                                        @error('nomor_hp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputNamaWisata">Nama Wisata</label>
                                        <select name="nama_wisata" id="inputNamaWisata" class="form-control" required>
                                            <option value="">-- Pilih Wisata --</option>
                                            @foreach ($destinations as $tujuan)
                                                <option value="{{ $tujuan }}"
                                                    {{ old('nama_wisata') == $tujuan ? 'selected' : '' }}>
                                                    {{ $tujuan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nama_wisata')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputLokasi">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control" id="inputLokasi"
                                            value="{{ old('lokasi') }}" required>
                                        @error('lokasi')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword">Kata Sandi</label>
                                        <input type="password" name="password" class="form-control" id="inputPassword" required>
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inputPasswordConfirm">Konfirmasi Kata Sandi</label>
                                        <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirm" required>
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
