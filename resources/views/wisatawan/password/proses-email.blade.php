<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Link Mengatur Ulang Kata Sandi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            width: 100%;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo img {
            max-height: 80px;
            height: auto;
        }

        .content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
            margin-bottom: 15px;
        }

        .button {
            padding: 12px 24px;
            background-color: #7bb6f5;
            color: rgb(0, 0, 0);
            text-decoration: none;
            border-radius: 5px;
            margin-top: 40px;
        }

        .button:hover {
            background-color: #3b8fe8;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="email-container">
        <div class="logo">
            <img src="https://exploreperjalanan.com/assets/wisatawan/images/logo/logo-black.png" alt="Logo">
        </div>

        <div class="content">
            <h2>Atur Ulang Kata Sandi</h2>
            <p>Hallo {{ $namaPengguna ?? 'Pengguna' }}</p>
            <p>Untuk mengatur ulang kata sandi Anda, silakan klik tautan di bawah ini:</p>
            <p>
                <a href="{{ $url }}" class="button">Atur Ulang Kata Sandi</a>
            </p>
            <p style="margin-top: 40px;">Jika Anda tidak ingin mengatur ulang kata sandi, silakan abaikan email ini.</p>
        </div>

        <div class="footer">
            ©2025 Guide Me. Semua hak dilindungi.
        </div>
    </div>

</body>

</html>
