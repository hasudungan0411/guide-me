<!-- resources/views/emails/verifikasi.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Halo, {{ $user->nama }}!</h1>
    <p>Terima kasih telah mendaftar. Klik link di bawah ini untuk memverifikasi email Anda:</p>

    @if ($user instanceof App\Models\Wisatawan)
        <a href="{{ route('verification.verify', ['id' => $user->ID_Wisatawan, 'hash' => sha1($user->Email)]) }}">Verifikasi Email</a>
    @elseif ($user instanceof App\Models\PemilikWisata)
        <a href="{{ route('verification.verify', ['id' => $user->ID_Pemilik_Wisata, 'hash' => sha1($user->Email)]) }}">Verifikasi Email</a>
    @endif
</body>
</html>
