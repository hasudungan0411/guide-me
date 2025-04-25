<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Masuk - Guide ME</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #e8ebf9;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      display: flex;
      max-width: 900px;
      width: 95%;
      height: 500px;
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .container:hover {
      transform: translateY(-5px);
    }

    .left {
      flex: 1;
      padding: 40px 30px;
      background-color: #e8ebf9;
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: relative;
    }

    .left a {
      text-decoration: none;
      font-size: 14px;
      color: black;
      margin-bottom: 20px;
      display: inline-block;
      transition: color 0.3s ease;
    }

    .left a:hover {
      color: #4CAF50;
    }

    .left h2 {
      font-size: 22px;
      margin-bottom: 25px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      font-size: 14px;
      display: block;
      margin-bottom: 5px;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 20px;
      border-radius: 20px;
      border: 1.5px solid #4CAF50;
      outline: none;
      transition: all 0.3s ease;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #45a049;
      box-shadow: 0 0 8px rgba(76,175,80,0.3);
    }

    .forgot-password {
      font-size: 13px;
      color: #333;
      margin: 8px 0 20px 0;
      cursor: pointer;
      transition: color 0.3s ease;
    }

    .forgot-password:hover {
      color: #4CAF50;
    }

    button {
      width: 100%;
      padding: 12px;
      border-radius: 20px;
      border: none;
      background: linear-gradient(to right, #4CAF50, #8BC34A);
      color: white;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
      margin-bottom: 15px;
      transition: all 0.3s ease;
    }

    button:hover {
      opacity: 0.9;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(76,175,80,0.3);
    }

    .register {
      text-align: center;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .register a {
      color: #4CAF50;
      text-decoration: none;
      font-weight: 500;
    }

    .google-login {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 12px;
      border: 1px solid #aaa;
      border-radius: 20px;
      background-color: white;
      cursor: pointer;
      font-size: 14px;
      gap: 8px;
      width: 100%;
      transition: all 0.3s ease;
    }

    .google-login:hover {
      border-color: #4CAF50;
      background-color: #f8f8f8;
    }

    .google-login img {
      width: 18px;
      height: 18px;
    }

    .right {
      flex: 1;
      background-color: #7ac16e;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      transition: all 0.3s ease;
    }

    .right img {
      width: 160px;
      height: auto;
      margin-bottom: 10px;
      transition: transform 0.3s ease;
    }

    .right:hover img {
      transform: scale(1.05);
    }

    .right h1 {
      font-size: 36px;
      font-weight: bold;
      color: black;
      text-align: center;
      line-height: 1;
      transition: all 0.3s ease;
    }

    .right h1 span {
      font-size: 28px;
      display: block;
    }

    .error-message {
      color: #ff4444;
      font-size: 12px;
      margin-top: 4px;
      height: 16px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
        margin: 20px 0;
      }

      .right, .left {
        width: 100%;
        padding: 30px 20px;
      }

      .right img {
        width: 120px;
      }

      .right h1 {
        font-size: 28px;
      }

      .right h1 span {
        font-size: 22px;
      }
    }

    @media (max-width: 480px) {
      input[type="email"],
      input[type="password"] {
        padding: 10px 15px;
      }
      
      button {
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <a href="#">&lt; Kembali</a>
      <h2>Masuk!</h2>
      <form method="POST" action="{{ route('pemilikwisata.login') }}">
  @csrf
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" placeholder="email@example.com" required />
    @error('email')
    <div class="error-message">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-group">
    <label for="password">Kata Sandi:</label>
    <input type="password" name="password" id="password" placeholder="********" required />
    @error('password')
    <div class="error-message">{{ $message }}</div>
    @enderror
  </div>
  <div class="forgot-password"><a href="#">Lupa Kata Sandi?</a></div>
  <button type="submit">Masuk</button>
</form>

      <div class="register">Belum Punya Akun? <a href="{{ route('register') }}">Daftar</a></div>
      <div class="google-login" onclick="googleLogin()">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" alt="Google logo" />
        Login dengan Google
      </div>
    </div>
    <div class="right">
      <img src="https://upload.wikimedia.org/wikipedia/commons/e/e3/Location_dot_green_icon.svg" alt="Logo" />
      <h1>Guide <span>ME</span></h1>
    </div>
  </div>

  <script>
    function login() {
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const emailError = document.getElementById("email-error");
      const passwordError = document.getElementById("password-error");

      emailError.textContent = '';
      passwordError.textContent = '';

      if (!email) {
        emailError.textContent = 'Mohon isi email';
        return;
      }
      if (!password) {
        passwordError.textContent = 'Mohon isi kata sandi';
        return;
      }

      if (!validateEmail(email)) {
        emailError.textContent = 'Format email tidak valid';
        return;
      }

      // Simulasi login berhasil
      alert(`Login berhasil!\nEmail: ${email}`);
    }

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    function googleLogin() {
      // Simulasi login Google
      window.location.href = 'https://accounts.google.com';
    }
  </script>
</body>
</html>