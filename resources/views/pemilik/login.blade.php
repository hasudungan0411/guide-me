<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pemilik Wisata</title>
</head>
<body>
    <h2>Login Pemilik Wisata</h2>

    <form action="{{ route('pemilikwisata.login') }}" method="POST">
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
            <button type="submit">Login</button>
        </div>
    </form>

    <p>Belum punya akun? <a href="{{ route('pemilikwisata.register') }}">Daftar di sini</a></p>
</body>
</html>
