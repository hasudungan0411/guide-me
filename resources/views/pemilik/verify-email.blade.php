<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>
<body>
    <h2>Verifikasi Email Diperlukan</h2>
    <p>Silakan cek email kamu dan klik link verifikasi yang dikirim ke <strong>{{ Auth::guard('pemilikwisata')->user()->Email }}</strong>.</p>

    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <div style="color: green;">
            <p>{{ session('success') }}</p>
        </div>
    @elseif(session('error'))
        <div style="color: red;">
            <p>{{ session('error') }}</p>
        </div>
    @elseif(session('info'))
        <div style="color: orange;">
            <p>{{ session('info') }}</p>
        </div>
    @endif

    <!-- Form untuk mengirim ulang email verifikasi -->
    <form action="{{ route('pemilikwisata.verifikasi.resend') }}" method="POST">
        @csrf
        <button type="submit">Kirim Ulang Email Verifikasi</button>
    </form>
</body>
</html>
