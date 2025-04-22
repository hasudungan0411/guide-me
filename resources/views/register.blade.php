<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar - Guide ME</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
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
      width: 1000px;
      max-width: 95%;
      background-color: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      flex-direction: row; 
      flex-wrap: wrap;     
    }

    .left {
      flex: 1;
      background: #e8ebf9;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
    }

    .left img {
      width: 160px;
      margin-bottom: 20px;
    }

    .left h1 {
      font-size: 36px;
      font-weight: bold;
      color: black;
      text-align: center;
    }

    .left h1 span {
      display: block;
      font-size: 28px;
    }

    .right {
      flex: 1.2;
      padding: 40px 30px;
      background-color: #e8ebf9;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .back-link {
      text-decoration: none;
      font-size: 14px;
      color: black;
      margin-bottom: 20px;
      display: inline-block;
    }

    .right h2 {
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

    select {
      width: 100%;
      padding: 10px;
      font-size: 14px;
      margin-top: 10px;
      border-radius: 20px;
      background:rgb(255, 255, 255);
      border: 1.5px solid #4CAF50;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
    }

    select:hover {
      border-color: #888;
      background-color: #4CAF50;
    }

    input {
      width: 100%;
      padding: 10px;
      border-radius: 20px;
      border: 1.5px solid #4CAF50;
      outline: none;
    }

    .hidden {
      display: none;
    }

    .btn-submit {
      width: 100%;
      padding: 10px;
      border-radius: 20px;
      border: none;
      background: #4CAF50;
      color: white;
      font-weight: bold;
      font-size: 14px;
      cursor: pointer;
      margin-top: 10px;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
        height: auto;
      }

      .left, .right {
        width: 100%;
        height: auto;
      }

      .left img {
        width: 100px;
      }

      .left h1 {
        font-size: 26px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <img src="https://upload.wikimedia.org/wikipedia/commons/e/e3/Location_dot_green_icon.svg" alt="GuideME Logo" />
      <h1>Guide <span>ME</span></h1>
    </div>
    <div class="right">
      <a class="back-link" href="#">&lt; Kembali</a>
      <h2>Daftar Akun!</h2>
      <div class="form-group">
        <label for="nama">Nama Lengkap:</label>
        <input type="text" id="nama" placeholder="Nama lengkap" />
      </div>
      <div class="form-group">
        <label for="peran">Peran:</label>
        <select id="peran" name="peran">
          <option value="">-- Pilih salah satu --</option>
          <option value="wisatawan">Wisatawan</option>
          <option value="pemilikwisata">Pemilik Wisata</option>
        </select>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" placeholder="Contoh: email@gmail.com" />
      </div>
      <div class="form-group">
        <label for="password">Kata Sandi:</label>
        <input type="password" id="password" placeholder="Kata Sandi">
      </div>
      <div class="form-group">
        <label for="confirm-password">Konfirmasi Kata Sandi:</label>
        <input type="password" id="confirm-password" placeholder="Konfirmasi Kata Sandi">
      </div>
      <div id="inputTambahan" class="hidden">
        <div class="input-group">
          <label>Lokasi:</label>
          <input type="text" placeholder="Lokasi">
        </div>
      </div>
      <button class="btn-submit" onclick="register()">Daftar</button>
    </div>
  </div>

  <script>
    function register() {
      const nama = document.getElementById("nama").value;
      const peran = document.getElementById("peran").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const confirmPassword = document.getElementById("confirm-password").value;

      if (!nama || !peran || !email || !password || !confirmPassword) {
        alert("Mohon lengkapi semua field.");
        return;
      }

      if (password !== confirmPassword) {
        alert("Konfirmasi kata sandi tidak cocok.");
        return;
      }

      alert("Pendaftaran berhasil!\nSelamat datang, " + nama + "!");
    }

    const selectElement = document.getElementById('peran');
    const inputTambahan = document.getElementById('inputTambahan');

    selectElement.addEventListener('change', function () {
      if (this.value === 'pemilikwisata') {
        inputTambahan.classList.remove('hidden');
      } else {
        inputTambahan.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
