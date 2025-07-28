@extends('layouts.admin')

@section('title', 'Edit Akun Pemilik Wisata')

@section('content')

    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('akun_pemilik-wisata.index') }}">Akun Pemilik Wisata</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="main-wrapper"></div>
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Akun Pemilik Wisata {{ $pemilik->Nama_Wisata }}</h5>
                        <form action="{{ route('akun_pemilik-wisata.update', $pemilik->ID_Pemilik_Wisata) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Nama Pemilik Wisata</label>
                                <input type="text" name="nama_wisata" class="form-control"
                                    value="{{ $pemilik->Nama_Wisata }}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $pemilik->Email }}">
                            </div>
                             <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" value="{{ $pemilik->Lokasi }}">
                            </div>
                             <div class="form-group">
                                <label>Nomor HP</label>
                                <input type="text" name="nomor_hp" class="form-control" value="{{ $pemilik->Nomor_HP }}">
                            </div>
                            {{-- <div class="form-group">
                                <label>Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control"
                                        value="{{ $pemilik->Kata_Sandi }}" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                            <i id="eye-icon" class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}


                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Menambahkan event listener untuk ikon mata
        document.getElementById('toggle-password').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');

            // Cek apakah password sedang disembunyikan (type = 'password')
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Tampilkan password dalam bentuk teks
                eyeIcon.classList.remove('fa-eye-slash'); // Ganti ikon ke mata terbuka
                eyeIcon.classList.add('fa-eye'); // Ganti ikon menjadi eye (terlihat)
            } else {
                passwordField.type = 'password'; // Sembunyikan password (titik hitam)
                eyeIcon.classList.remove('fa-eye'); // Ganti ikon ke mata tertutup
                eyeIcon.classList.add('fa-eye-slash'); // Ganti ikon menjadi eye-slash (tersembunyi)
            }
        });
    </script>


@endsection
