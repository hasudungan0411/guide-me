<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atur ulang kata sandi</title>
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
</head>

<body
    style="margin:0; font-family:'Segoe UI', sans-serif; background:#e8ebf9; display:flex; align-items:center; justify-content:center; min-height:100vh;">

    <div style="display:flex; max-width:900px; width:95%; height:650px; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <!-- Kiri (form login) -->
        <div class="kiri"
            style="flex:1; background:#e8ebf9; padding:40px 30px; display:flex; flex-direction:column; justify-content:center;">
            <h2 style="font-size:22px; text-align: center; margin-bottom:25px;">Atur ulang kata sandi</h2>
                @if ($errors->any())
                    <div style="color:red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('wisatawan.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                    <label>Password Baru:</label>
                    <input type="password" name="password" required>
                    <label>Konfirmasi Password:</label>
                    <input type="password" name="password_confirmation" required>
                    <button type="submit">Reset Password</button>
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
