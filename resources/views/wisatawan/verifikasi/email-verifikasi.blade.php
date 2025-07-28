{{-- <h3>Kode OTP Anda:</h3>
<p><strong>{{ $otp }}</strong></p>
<p>Kode ini berlaku selama 5 menit.</p> --}}

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Email Verifikasi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .email-container {
      background-color: #ffffff;
      max-width: 600px;
      margin: 40px auto;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .logo {
      text-align: center;
      margin-bottom: 20px;
    }
    .logo img {
      max-height: 50px;
    }
    .content {
      text-align: center;
    }
    .code {
      font-size: 32px;
      font-weight: bold;
      color: #333333;
      letter-spacing: 5px;
      margin: 20px 0;
      background-color: #f0f0f0;
      display: inline-block;
      padding: 15px 25px;
      border-radius: 6px;
    }
    .footer {
      font-size: 12px;
      color: #888;
      text-align: center;
      margin-top: 30px;
    }
  </style>
</head>
<body>

  <div class="email-container">
    <div class="logo">
        <img src="https://exploreperjalanan.com/assets/wisatawan/images/logo/logo-black.png" alt="Logo">
      {{-- <img src="{{ asset('assets/wisatawan/images/logo/logo-white.png') }}" alt="Logo"> --}}
    </div>

    <div class="content">
      <h2>Verifikasi Akun Anda</h2>
      <p>Gunakan kode OTP berikut untuk menyelesaikan proses pendaftaran Anda:</p>

      <div class="code">{{ $otp }}</div>

      <p>Kode ini berlaku selama 5 menit. Jangan bagikan kode ini kepada siapa pun.</p>
    </div>

    <div class="footer">
      ©2025 Guide Me. Semua hak dilindungi.
    </div>
  </div>

</body>
</html>
