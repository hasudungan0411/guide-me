<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset kata sandi</title>
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
</head>

<body style="margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, rgba(76, 175, 80, 0.7), rgba(0, 123, 255, 0.5)), url('{{ asset('assets/wisatawan/images/background/bg.png') }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;">

    <div style="display:flex; max-width:900px; width:95%; height:650px; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <!-- Kiri (form reset) -->
        <div class="form-container"
            style="flex:1; background:#e8ebf9; padding:40px 30px; display:flex; flex-direction:column; justify-content:center;">
            <h2 style="font-size:22px; text-align: center; margin-bottom:25px;">Atur Ulang Kata Sandi</h2>
            <form method="POST" action="{{ route('wisatawan.password.email') }}">
                @csrf
                <div style="margin-bottom:15px;">
                    <label for="email" style="font-size:14px; display:block; margin-bottom:5px;">Email:</label>
                    <input id="email" name="email" type="email" placeholder="email@example.com"
                        style="width:100%; max-width:95%; padding:10px 15px; border-radius:20px; border:1.5px solid #4CAF50; outline:none; transition:0.3s; box-sizing:border-box; font-size:14px;"
                        onfocus="this.style.boxShadow='0 0 8px rgba(76,175,80,0.3)'"
                        onblur="this.style.boxShadow='none'" />
                </div>
                <button type="submit"
                 style="width:100%; max-width:95%; padding:10px; border-radius:20px; border:none; background:#4caf50; color:white; font-weight:bold; font-size:14px; cursor:pointer; transition:all 0.3s ease; box-sizing:border-box;"
                 onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(76,175,80,0.3)'"
                 onmouseout="this.style.opacity='1'; this.style.transform='none'; this.style.boxShadow='none'">
                 Berikutnya
                </button>
            </form>
            <div style="text-align:center; font-size:14px; margin-top:15px;">
                Sudah ingat kata sandi?
                <a href="{{ route('wisatawan.login') }}"
                    style="color: #4caf50; text-decoration:none; font-weight:500;">Masuk</a>
            </div>
        </div>

        <!-- Kanan (logo) -->
        <div class="logo-container"
            style="flex:1; min-height:300px; background:linear-gradient(to bottom right, #0917d5, #86e77a); display:flex; flex-direction:column; justify-content:center; align-items:center; padding:30px; text-align:center; box-sizing:border-box;">
            <img id="logo-img" src="{{ asset('assets/wisatawan/images/logo/logo-white.png') }}" alt="Logo"
            style="max-width:300px; width:100%; margin:0 auto; border-radius:12px; height:auto;">
        </div>
    </div>

    <script>
    function handleResponsiveLayout() {
        const container = document.querySelector('body > div');
        const form = document.querySelector('.form-container');
        const logo = document.querySelector('.logo-container');
        const logoImg = document.getElementById('logo-img');

        if (window.innerWidth <= 768) {
            // Mobile: Logo di atas, form di bawah
            container.style.flexDirection = 'column-reverse';
            container.style.height = 'auto';
            container.style.width = '95%'; // Lebar
            container.style.margin = '20px 0';

            form.style.width = '100%';
            form.style.padding = '15px 10px'; // Padding 
            form.style.borderRadius = '0 0 12px 12px';

            logo.style.width = '100%';
            logo.style.minHeight = '120px'; // Tinggi 
            logo.style.padding = '15px'; // Padding 
            logo.style.borderRadius = '12px 12px 0 0';
            if (logoImg) logoImg.style.maxWidth = '180px'; // Ukuran logo
        } else {
            // Desktop: Form di kiri, logo di kanan
            container.style.flexDirection = 'row';
            container.style.height = '620px';
            container.style.width = '95%';

            form.style.width = '50%';
            form.style.padding = '40px 30px';
            form.style.borderRadius = '12px 0 0 12px';

            logo.style.width = '50%';
            logo.style.minHeight = '300px';
            logo.style.padding = '30px';
            logo.style.borderRadius = '0 12px 12px 0';
            if (logoImg) logoImg.style.maxWidth = '300px';
        }
    }

    window.addEventListener('load', handleResponsiveLayout);
    window.addEventListener('resize', handleResponsiveLayout);
    </script>
    
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
       @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        html: `{!! session('success') !!}`
    });
    @elseif ($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ $errors->first() }}'
    });
  @endif
    </script>

    @include('sweetalert::alert')
</body>
</html>