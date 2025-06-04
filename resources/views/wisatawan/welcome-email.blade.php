<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h4 {
            font-size: 22px;
            color: #333;
            text-align: center;
        }

        p {
            font-size: 16px;
            color: #555;
            line-height: 1.5;
        }

        .reset-link {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
            text-align: center;
        }

        .logo {
            display: block;
            width: 150px;
            margin: 20px auto;
        }

        /* Responsif untuk perangkat kecil */
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 15px;
            }

            .logo {
                width: 120px;
            }

            h4 {
                font-size: 18px;
            }

            p,
            .footer {
                font-size: 14px;
            }

            .reset-link {
                width: 100% !important;
                padding: 12px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Logo yang Bisa Diklik -->
        <a href="{{ url('/') }}" target="_blank">
            <img src="{{ asset('assets/wisatawan/images/logo/logo-white1.png') }}" alt="Logo" class="logo">
        </a>

        <!-- Email Content -->
        <h4>{{ $subject }}</h4>
        <p>{{ $mailMessage }}</p>

        <p>Untuk mereset kata sandi Anda, klik tombol di bawah ini:</p>
        <a href="{{ $resetLink }}" class="reset-link">Reset Password</a>

        <p class="footer">
            Jika Anda mengalami kesulitan dalam mengklik tombol "Reset Password", Anda dapat menyalin dan menempelkan
            URL berikut ke browser Anda:<br>
            <a href="{{ $resetLink }}" style="color: #4CAF50;">{{ $resetLink }}</a>
        </p>

        <p class="footer">
            &copy; 2025 <a href="{{ url('/') }}" target="_blank"
                style="color: #9575cd; text-decoration: none; font-weight: 500;">Guide Me 2025</a>. All rights reserved.
        </p>
    </div>
</body>

</html>
