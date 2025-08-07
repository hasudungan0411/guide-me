<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi OTP</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, rgba(76, 175, 80, 0.7), rgba(0, 123, 255, 0.5)), 
                url('{{ asset('assets/wisatawan/images/background/bg.png') }}') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
  }

  .container {
    background-color: #fff;
    padding: 30px 10px; /* lebih kecil supaya tidak sempit */
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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
    margin: 0 auto 20px auto;
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
    justify-content: center;
    gap: 6px;
    flex-wrap: nowrap; /* agar tidak turun */
    overflow-x: auto; /* bisa scroll kanan kiri kalau terlalu sempit */
    margin-bottom: 5px;
  }

  .otp-input {
    width: 40px;
    height: 50px;
    font-size: 18px;
    text-align: center;
    border: 2px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    outline: none;
    transition: border 0.3s ease;
  }

  .otp-input:focus {
    border-color: #4CAF50;
  }

  .resend-wrapper {
      width: 100%;
      display: flex;
      justify-content: flex-end; 
      margin-top: 10px;
      margin-bottom: 40px;

  }

  .resend-link {
      color: #4CAF50;
      text-decoration: none;
      font-weight: 600;
      cursor: pointer;
      font-size: 14px;
      margin-top: 10px;
      display: inline-block;
      transition: color 0.3s ease;
      background: none;
      padding: 0;
      border-radius: 0;
      border: none;
      align-self: flex-end; 
      text-align: right;

      margin-bottom: 40px
  }

        
  .resend-link:hover {
      color:rgb(24, 110, 28);
      text-decoration: none;
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

  @media (max-width: 400px) {
    .otp-input {
      width: 35px;
      height: 45px;
      font-size: 16px;
    }

    h2 {
      font-size: 20px;
    }

    .otp-input-container {
      gap: 4px;
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
      <p>
        Kode OTP akan kedaluwarsa dalam <span id="timer"></span>
      </p>

      <div class="otp-input-container">
        <input type="text" id="otp1" class="otp-input" maxlength="1" oninput="moveFocus(event, 1)">
        <input type="text" id="otp2" class="otp-input" maxlength="1" oninput="moveFocus(event, 2)">
        <input type="text" id="otp3" class="otp-input" maxlength="1" oninput="moveFocus(event, 3)">
        <input type="text" id="otp4" class="otp-input" maxlength="1" oninput="moveFocus(event, 4)">
        <input type="text" id="otp5" class="otp-input" maxlength="1" oninput="moveFocus(event, 5)">
        <input type="text" id="otp6" class="otp-input" maxlength="1" oninput="moveFocus(event, 6)">
      </div>

   
        <a href="{{ route('wisatawan.otp.resend') }}" class="resend-link">Kirim ulang</a>


      <input type="hidden" name="otp" id="otp-field">
      <button type="submit">Verifikasi Email</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //form
        function moveFocus(event, current) {
            const value = event.target.value;

            if (value.length === 1 && current < 6) {
                document.getElementById(`otp${current + 1}`).focus();
            } else if (value.length === 0 && current > 1) {
                document.getElementById(`otp${current - 1}`).focus();
            }

            const otpValues = [];
            for (let i = 1; i <= 6; i++) {
                const val = document.getElementById(`otp${i}`).value;
                if (val === '') return; 
                otpValues.push(val);
            }

            const otp = otpValues.join('');
            document.getElementById('otp-field').value = otp;

            setTimeout(() => {
                document.querySelector('form').submit();
            }, 100);
        }

        // countdown 
        let timeLeft = 300; 

        function updateCountdown() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            const formatted = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            document.getElementById('timer').textContent = formatted;

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                disableOtpInputs();

                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Kode OTP telah kedaluwarsa. Kamu akan diarahkan kembali ke halaman pendaftaran.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = "{{ route('wisatawan.register') }}"; // arahkan ke halaman pendaftaran
                });
            }


            timeLeft--;
        }

        function disableOtpInputs() {
            for (let i = 1; i <= 6; i++) {
                document.getElementById(`otp${i}`).disabled = true;
            }
            document.querySelector('button[type="submit"]').disabled = true;
            document.querySelector('button[type="submit"]').style.backgroundColor = '#aaa';
            document.querySelector('button[type="submit"]').style.cursor = 'not-allowed';
        }

        const timerInterval = setInterval(updateCountdown, 1000);
    </script>

  @include('sweetalert::alert')
</body>
</html>
