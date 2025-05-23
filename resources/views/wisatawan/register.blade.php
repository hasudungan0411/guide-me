<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Guide ME</title>
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
</head>

<body
    style="margin:0; font-family:'Segoe UI', sans-serif; background:#f2f7fb; display:flex; align-items:center; justify-content:center; min-height:100vh;">

    <div id="container"
        style="display:flex; flex-direction:row; max-width:900px; width:95%; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <!-- Kiri -->
        <div class="kiri"
            style="flex:1; min-height:300px; background:linear-gradient(to bottom right, #0917d5, #86e77a); display:flex; flex-direction:column; justify-content:center; align-items:center; padding:30px; text-align:center;">
            <img src="{{ asset('assets/wisatawan/images/logo/logo-white.png') }}" alt="Logo"
                style="max-width:300px; width:100%; margin:0 auto; border-radius:12px;">
        </div>

        <!-- Kanan -->
        <div class="kanan"
            style="flex:1; background:#ffffff; padding:40px 30px; display:flex; flex-direction:column; justify-content:center;">
            <h2 style="font-size:22px; text-align:center; margin-bottom:25px;">Daftar Akun Baru</h2>

            <form method="POST" action="{{ route('wisatawan.registerPost') }}"
                style="width:100%; max-width:400px; margin:0 auto;">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div style="margin-bottom:15px;">
                    <label for="name" style="font-size:14px; display:block; margin-bottom:5px;">Nama
                        Lengkap:</label>
                    <input id="name" name="name" type="text" placeholder="Nama Lengkap"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #9575cd; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="email" style="font-size:14px; display:block; margin-bottom:5px;">Email:</label>
                    <input id="email" name="email" type="email" placeholder="email@example.com"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #9575cd; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="phone" style="font-size:14px; display:block; margin-bottom:5px;">Nomor HP:</label>
                    <input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #9575cd; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="password" style="font-size:14px; display:block; margin-bottom:5px;">Kata Sandi:</label>
                    <input id="password" name="password" type="password" placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #9575cd; outline:none; box-sizing:border-box;" />
                </div>

                <div style="margin-bottom:20px;">
                    <label for="password_confirmation"
                        style="font-size:14px; display:block; margin-bottom:5px;">Konfirmasi
                        Kata Sandi:</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #9575cd; outline:none; box-sizing:border-box;" />
                </div>

                <button type="submit"
                    style="width:100%; padding:12px; border-radius:20px; border:none; background:linear-gradient(to right, #0917d5, #86e77a); color:white; font-weight:bold; font-size:14px; cursor:pointer;">
                    Daftar
                </button>
            </form>

            <div style="text-align:center; font-size:14px; margin-top:15px;">
                Sudah punya akun?
                <a href="{{ route('wisatawan.login') }}"
                    style="color:#9575cd; text-decoration:none; font-weight:500;">Masuk</a>
            </div>
        </div>
    </div>

    <script>
        function responsive() {
            const container = document.getElementById('container');
            const kiri = document.querySelector('.kiri');
            const kanan = document.querySelector('.kanan');
            const logo = kiri.querySelector('img');

            if (window.innerWidth <= 768) {
                container.style.flexDirection = 'column';
                kiri.style.width = '100%';
                kiri.style.minHeight = '200px';
                kiri.style.padding = '20px';
                logo.style.width = '80%';

                kanan.style.width = '100%';
                kanan.style.padding = '30px 20px';
            } else {
                container.style.flexDirection = 'row';
                kiri.style.width = '50%';
                kiri.style.padding = '30px';
                kiri.style.minHeight = 'auto';
                logo.style.width = '100%';
                logo.style.maxWidth = '300px';

                kanan.style.width = '50%';
                kanan.style.padding = '40px 30px';
            }
        }

        window.addEventListener('load', responsive);
        window.addEventListener('resize', responsive);
    </script>

    @include('sweetalert::alert')
</body>

</html>
