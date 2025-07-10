<form action="{{ route('wisatawan.otp.verify') }}" method="POST">
    @csrf
    <input type="text" name="otp" placeholder="Masukkan kode OTP" required>
    @error('otp') <p style="color:red">{{ $message }}</p> @enderror
    <button type="submit">Verifikasi</button>
</form>