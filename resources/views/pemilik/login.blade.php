<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Guide ME</title>
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
</head>

<body
    style="margin:0; font-family:'Segoe UI', sans-serif; background:#e8ebf9; display:flex; align-items:center; justify-content:center; min-height:100vh;">

    <div style="display:flex; max-width:900px; width:95%; height:650px; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <!-- Kiri (form login) -->
        <div class="kiri"
            style="flex:1; background:#e8ebf9; padding:40px 30px; display:flex; flex-direction:column; justify-content:center;">
            <h2 style="font-size:22px; text-align: center; margin-bottom:25px;">Silahkan Masuk!</h2>

            <form method="POST" action="{{ url('pemilik/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div style="margin-bottom:15px;">
                    <label for="email" style="font-size:14px; display:block; margin-bottom:5px;">Email:</label>
                    <input id="email" name="email" type="email" placeholder="email@example.com"
                        style="width:90%; padding:12px 20px; border-radius:20px; border:1.5px solid #4CAF50; outline:none; transition:0.3s;"
                        onfocus="this.style.boxShadow='0 0 8px rgba(76,175,80,0.3)'"
                        onblur="this.style.boxShadow='none'" />
                </div>

                <div style="margin-bottom:15px;">
                    <label for="password" style="font-size:14px; display:block; margin-bottom:5px;">Kata Sandi:</label>
                    <input id="password" name="password" type="password" placeholder="********"
                        style="width:90%; padding:12px 20px; border-radius:20px; border:1.5px solid #4CAF50; outline:none; transition:0.3s;"
                        onfocus="this.style.boxShadow='0 0 8px rgba(76,175,80,0.3)'"
                        onblur="this.style.boxShadow='none'" />
                    <div id="password-error" style="color:#ff4444; font-size:12px; margin-top:4px; height:16px;"></div>
                </div>

                <button type="submit"
                    style="width:100%; box-sizing:border-box; padding:12px; border-radius:20px; border:none; background:linear-gradient(to right, #4CAF50, #8BC34A); color:white; font-weight:bold; font-size:14px; cursor:pointer; transition:all 0.3s ease;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(76,175,80,0.3)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='none'; this.style.boxShadow='none'">
                    Masuk
                </button>
                <p>
                    <span style="font-size:14px; center; color:#333; margin:10px 0 25px 0; cursor:pointer;">
                        Jika belum memiliki akun atau masalah terhadap akun anda, silahkan hubungi admin guide me
                    </span>
                    <a href="https://wa.me/+6287867529822" target="blank"
                        style="color:#4CAF50; text-decoration:none;">Klink Disini
                    </a>
                </p>
            </form>
        </div>

        <!-- Kanan (logo) -->
        <div class="kanan"
            style="flex:1; min-height:300px; background:linear-gradient(to bottom right, #0917d5, #86e77a); display:flex; flex-direction:column; justify-content:center; align-items:center; padding:30px; text-align:center;">
            <img src="{{ asset('assets/wisatawan/images/logo/logo-black.png') }}" alt="Logo"
                style="width:300px; margin-bottom:10px; transition:transform 0.3s ease;"
                onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" />
        </div>
    </div>

    <script>
        function handleResponsiveLayout() {
            const kanan = document.querySelector('.kanan');
            const kiri = document.querySelector('.kiri');
            const container = document.querySelector('body > div');

            if (window.innerWidth <= 768) {
                kanan.style.display = 'none';
                kiri.style.width = '100%';
                container.style.height = 'auto';
            } else {
                kanan.style.display = 'flex';
                kiri.style.width = '50%';
                container.style.height = '650px';
            }
        }

        window.addEventListener('load', handleResponsiveLayout);
        window.addEventListener('resize', handleResponsiveLayout);
    </script>

    @include('sweetalert::alert')
</body>

</html>
