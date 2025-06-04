@extends('layouts.admin')

@section('title', 'Tambah Akun Wisatawan')

@section('content')
    <div class="page-content">
        <div class="page-info">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">MeGuide</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('akun_wisatawan.index') }}">Kelola Akun Wisatawan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Akun</li>
                </ol>
            </nav>
        </div>

        <div class="main-wrapper">
            <div class="row">
                <div class="col-xl">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('akun_wisatawan.index') }}" class="btn btn-primary mb-3">Kembali</a>
                            <h5 class="card-title">Tambah Akun Wisatawan</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('akun_wisatawan.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="inputNamaWisata">Nama Wisatawan</label>
                                    <input type="text" name="nama" class="form-control" id="inputNamaWisata"
                                        value="{{ old('nama') }}" placeholder="Nama Wisatawan" required>
                                    @error('nama')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail">Email</label>
                                    <input type="email" name="email" class="form-control" id="inputEmail"
                                        value="{{ old('email') }}" placeholder="example@misal.com" required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputNomorHP">Nomor HP</label>
                                    <input type="text" name="nomor_hp" class="form-control" id="inputNomorHP"
                                        value="{{ old('nomor_hp') }}" required>
                                    @error('nomor_hp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputPassword">Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control" id="inputPassword" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="inputPasswordConfirm">Konfirmasi Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirm" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirm">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <script>
                                        // Toggle password visibility
                                        document.getElementById('togglePassword').addEventListener('click', function() {
                                            const passwordField = document.getElementById('inputPassword');
                                            passwordField.type = (passwordField.type === 'password') ? 'text' : 'password';
                                        });

                                        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
                                            const passwordFieldConfirm = document.getElementById('inputPasswordConfirm');
                                            passwordFieldConfirm.type = (passwordFieldConfirm.type === 'password') ? 'text' : 'password';
                                        });
                                    </script>

                                    <button type="submit" class="btn btn-primary mt-3">Simpan Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
