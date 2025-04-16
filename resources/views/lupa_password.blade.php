<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lupa Kata Sandi - GuideMe</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #e8ebf9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      display: flex;
      flex-direction: row;
      background-color: white;
      width: 90%;
      max-width: 900px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .left-section {
      background-color: #e8ebf9;
      flex: 1;
      padding: 40px 30px;
      position: relative;
    }

    .back-button {
      position: absolute;
      top: 20px;
      left: 20px;
      font-size: 14px;
      color: #000;
      text-decoration: none;
    }

    .form-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 100%;
      margin-top: 50px;
    }

    .form-container h2 {
      font-size: 18px;
      margin-bottom: 20px;
      font-weight: bold;
      color: #222;
    }

    .form-container label {
      font-size: 14px;
      margin-bottom: 5px;
    }

    .form-container input {
      padding: 10px;
      border-radius: 20px;
      border: 1px solid #68c179;
      outline: none;
      margin-bottom: 20px;
    }

    .form-container button {
      padding: 10px;
      background: linear-gradient(to right, #4CAF50, #8BC34A);
      color: white;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-weight: bold;
    }

    .right-section {
      background-color: #84c97c;
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .logo {
      width: 100px;
      height: 100px;
      background: linear-gradient(to bottom right, #9be7a0, #4CAF50);
      border-radius: 50%;
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .logo::before {
      content: '';
      width: 60px;
      height: 60px;
      background-color: white;
      border-radius: 50%;
    }

    .brand-text {
      text-align: center;
      color: black;
      font-weight: bold;
      font-size: 36px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        border-radius: 0;
      }

      .right-section {
        padding: 40px 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="left-section">
      <a href="#" class="back-button">&lt; Kembali</a>
      <div class="form-container">
        <h2>Lupa Kata Sandi</h2>
        <label for="email">Masukkan Email</label>
        <input type="email" id="email" placeholder="email@gmail.com" />
        <button onclick="ubahKataSandi()">Ubah Kata Sandi</button>
      </div>
    </div>
    <div class="right-section">
      <div class="logo"></div>
      <div class="brand-text">
        Guide <br /> <span style="font-size: 32px">ME</span>
      </div>
    </div>
  </div>

  <script>
    function ubahKataSandi() {
      const email = document.getElementById("email").value;
      if (!email) {
        alert("Silakan masukkan email terlebih dahulu.");
        return;
      }
      alert("Link reset kata sandi telah dikirim ke " + email);
    }
  </script>
</body>

</html>
