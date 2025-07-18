<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Verifikasi OTP</title>
    <style>

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, rgba(76, 175, 80, 0.7), rgba(0, 123, 255, 0.5)), url('{{ asset('assets/wisatawan/images/background/bg.png') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            height: 100%;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center; /* Posisi konten berada di tengah vertikal */
            align-items: center; /* Menyusun elemen di tengah secara horizontal */
            padding: 40px;
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .icon {
            background-color: #4CAF50;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            margin-bottom: 20px; /* Jarak antara ikon dan form OTP */
            margin-left: auto;  /* Menjaga ikon tetap di tengah */
            margin-right: auto; /* Menjaga ikon tetap di tengah */
        }

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        .otp-input-container {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 30px;
        }

        .otp-input {
            width: 60px;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
            outline: none;
            transition: border 0.3s ease;
        }

        .otp-input:focus {
            border-color: #4CAF50;
        }

        button {
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Mobile responsiveness */
        @media (max-width: 600px) {
            .otp-input-container {
                flex-direction: column;
                gap: 10px;
            }

            .otp-input {
                width: 50px;
                height: 50px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <form action="{{ route('wisatawan.otp.verify') }}" method="POST">
            @csrf
            <div class="icon">
                <i class="fa fa-shield"></i>
            </div>
            <h2>Masukkan Kode OTP</h2>
            <p>Kode OTP sudah dikirim ke email anda!</p>

            <div class="otp-input-container">
                <input type="text" id="otp1" class="otp-input" maxlength="1" oninput="moveFocus(event, 1)">
                <input type="text" id="otp2" class="otp-input" maxlength="1" oninput="moveFocus(event, 2)">
                <input type="text" id="otp3" class="otp-input" maxlength="1" oninput="moveFocus(event, 3)">
                <input type="text" id="otp4" class="otp-input" maxlength="1" oninput="moveFocus(event, 4)">
                <input type="text" id="otp5" class="otp-input" maxlength="1" oninput="moveFocus(event, 5)">
                <input type="text" id="otp6" class="otp-input" maxlength="1" oninput="moveFocus(event, 6)">
            </div>

            @error('otp') <p style="color:red">{{ $message }}</p> @enderror
            <button type="submit">Verifikasi Email</button>
        </form>
    </div>

    <script>
        function moveFocus(event, current) {
            if (event.target.value.length === 1 && current < 6) {
                document.getElementById(`otp${current + 1}`).focus();
            } else if (event.target.value.length === 0 && current > 1) {
                document.getElementById(`otp${current - 1}`).focus();
            }
        }

        // Fokus otomatis ke input pertama
        document.getElementById('otp1').focus();
    </script>
</body>
</html>
