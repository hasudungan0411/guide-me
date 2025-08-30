<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Guide ME</title>
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body
    style="margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, rgba(76, 175, 80, 0.7), rgba(0, 123, 255, 0.5)), url('{{ asset('assets/wisatawan/images/background/bg.png') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;">

    <div id="container"
        style="display:flex; flex-direction:row; max-width:900px; width:100%; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <div class="kiri"
            style="flex:1; min-height:300px; background:linear-gradient(to bottom right, #0917d5, #86e77a); display:flex; flex-direction:column; justify-content:center; align-items:center; padding:30px; text-align:center; box-sizing:border-box;">
            <img src="{{ asset('assets/wisatawan/images/logo/logo-white.png') }}" alt="Logo"
                style="max-width:300px; width:100%; margin:0 auto; border-radius:12px; height:auto;">
        </div>

        <div class="kanan"
            style="flex:1; background:#ffffff; padding:40px 30px; display:flex; flex-direction:column; justify-content:center; box-sizing:border-box;">
            <h2 style="font-size:22px; text-align:center; margin-bottom:25px;">Daftar Akun Baru</h2>

            <form method="POST" action="{{ route('wisatawan.registerPost') }}"
                style="width:100%; max-width:400px; margin:0 auto;">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div style="margin-bottom:15px;">
                    <label for="name" style="font-size:14px; display:block; margin-bottom:5px;">Nama
                        Lengkap:</label>
                    <input id="name" name="name" type="text" placeholder="Nama Lengkap"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4caf50; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="email" style="font-size:14px; display:block; margin-bottom:5px;">Email:</label>
                    <input id="email" name="email" type="email" placeholder="email@example.com"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4caf50; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="phone" style="font-size:14px; display:block; margin-bottom:5px;">Nomor HP:</label>
                    <input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4caf50; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px; position:relative;">
                    <label for="password" style="font-size:14px; display:block; margin-bottom:5px;">Kata Sandi:</label>
                    <input id="password" name="password" type="password" placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4caf50; outline:none; box-sizing:border-box;" />
                    <i id="toggle-password"
                        style="position: absolute; top:70%; right:15px; transform:translateY(-50%); cursor:pointer;">
                        <i id="eye-icon" class="fa fa-eye-slash" style="font-size:20px; color:#4CAF50;"></i>
                    </i>
                </div>

                <div style="margin-bottom:20px; position: relative;">
                    <label for="password_confirmation"
                        style="font-size:14px; display:block; margin-bottom:5px;">Konfirmasi
                        Kata Sandi:</label>
                    <i id="toggle-password"
                        style="position: absolute; top:70%; right:15px; transform:translateY(-50%); cursor:pointer;">
                        <i id="eye-icon" class="fa fa-eye-slash" style="font-size:20px; color:#4CAF50;"></i>
                    </i>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4caf50; outline:none; box-sizing:border-box;" />
                </div>

                <button type="submit"
                    style="width:100%; padding:12px; border-radius:20px; border:none; background:#4caf50; color:white; font-weight:bold; font-size:14px; cursor:pointer; margin-bottom:20px;">
                    Daftar
                </button>

            </form>

            <div style="text-align:center; font-size:14px; margin-top:0;">
                Sudah punya akun?
                <a href="{{ route('wisatawan.login') }}"
                    style="color:#4caf50; text-decoration:none; font-weight:500;">Masuk</a>
            </div>
        </div>
    </div>

    <script>
        // Ambil semua ikon dengan kelas 'toggle-icon'
        const toggleIcons = document.querySelectorAll('.toggle-icon');

        // Tambahkan event listener untuk setiap ikon
        toggleIcons.forEach(icon => {
            icon.addEventListener('click', () => {
                // Ambil ID dari atribut data-target pada ikon
                const targetId = icon.getAttribute('data-target');
                // Temukan input yang sesuai dengan ID tersebut
                const passwordInput = document.getElementById(targetId);

                // Ubah tipe input dan kelas ikon
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });

        // script utk responsive
        function responsive() {
            const container = document.getElementById('container');
            const kiri = document.querySelector('.kiri');
            const kanan = document.querySelector('.kanan');
            const logo = kiri.querySelector('img');


            if (window.innerWidth <= 768) {
                container.style.flexDirection = 'column';
                container.style.height = '';
                kiri.style.width = '100%';
                kiri.style.minHeight = '150px';
                kiri.style.padding = '20px';
                logo.style.maxWidth = '200px'; // Smaller logo for mobile
                kanan.style.width = '100%';
                kanan.style.padding = '30px 20px'; // Adjusted padding for mobile
            } else {
                // Reset styles for desktop
                container.style.flexDirection = 'row';
                container.style.height = '620px';
                container.style.width = '100%'; // Reset to default width within max-width

                kiri.style.width = '50%'; // Reset to 50% for desktop
                kiri.style.minHeight = '300px'; // Reset min-height
                kiri.style.padding = '30px'; // Reset padding
                logo.style.maxWidth = '300px'; // Reset max-width for logo
                kanan.style.width = '50%'; // Reset to 50% for desktop
                kanan.style.padding = '40px 30px'; // Reset padding
            }
        }

        window.addEventListener('load', responsive);
        window.addEventListener('resize', responsive);
    </script>

    @include('sweetalert::alert')
</body>

</html>
