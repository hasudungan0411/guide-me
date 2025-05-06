<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pemilik Wisata</title>
</head>
<body>
    <h2>Register Pemilik Wisata</h2>

    <form action="{{ route('pemilikwisata.register') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div>
            <label for="no_hp">Nomor HP</label>
            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" required>
        </div>

        <div>
            <label for="nama_wisata">Nama Wisata</label>
            <input type="text" name="nama_wisata" id="nama_wisata" value="{{ old('nama_wisata') }}" required>
        </div>

        <div>
            <label for="lokasi">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi') }}" required>
        </div>

        <div>
            <button type="submit">Daftar</button>
        </div>
    </form>

    <p>Sudah punya akun? <a href="{{ route('pemilikwisata.login') }}">Login di sini</a></p>
</body>
</html>
