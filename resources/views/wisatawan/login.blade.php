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

            <form method="POST" action="{{ url('wisatawan/login') }}">
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

                <div style="font-size:13px; color:#333; margin:8px 0 20px 0; cursor:pointer;"
                    onmouseover="this.style.color='#4CAF50'" onmouseout="this.style.color='#333'">
                    Lupa Kata Sandi?
                </div>

                <button type="submit"
                    style="width:100%; box-sizing:border-box; padding:12px; border-radius:20px; border:none; background:linear-gradient(to right, #4CAF50, #8BC34A); color:white; font-weight:bold; font-size:14px; cursor:pointer; transition:all 0.3s ease;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(76,175,80,0.3)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='none'; this.style.boxShadow='none'">
                    Masuk
                </button>
            </form>

            <div style="text-align:center; font-size:14px; margin-bottom:10px; margin-top:10px;">
                Belum Punya Akun?
                <a href="{{ route('wisatawan.register') }}"
                    style="color:#4CAF50; text-decoration:none; font-weight:500;">Daftar</a>
            </div>

            <div onclick="window.location.href='{{ route('auth.google') }}'"
                style="display:flex; box-sizing:border-box; margin-top: 10px; align-items:center; justify-content:center; padding:12px; border:1px solid #aaa; border-radius:20px; background:white; cursor:pointer; font-size:14px; gap:8px; width:100%; transition:all 0.3s ease;"
                onmouseover="this.style.borderColor='#4CAF50'; this.style.backgroundColor='#f8f8f8'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(76,175,80,0.3)'"
                onmouseout="this.style.borderColor='#aaa'; this.style.backgroundColor='white'; this.style.transform='none'; this.style.boxShadow='none'">
                <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png"
                    alt="Google" style="width:18px; height:18px;" />
                Login dengan Google
            </div>

        </div>

        <!-- Kanan (logo) -->
        <div class="kanan"
            style="flex:1; background:#7eabcb; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:20px;">
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
