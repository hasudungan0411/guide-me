<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atur ulang kata sandi</title>
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

    <div style="display:flex; max-width:900px; width:95%; height:650px; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.1); transition:transform 0.3s ease;"
        onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='none'">

        <!-- Form kiri -->
        <div class="form-container"
            style="flex:1; background:#e8ebf9; padding:40px 30px; display:flex; flex-direction:column; justify-content:center;">
            <h2 style="font-size:22px; text-align: center; margin-bottom:25px;">Atur ulang kata sandi</h2>
            <form method="POST" action="{{ route('wisatawan.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div style="margin-bottom:15px; position: relative;">
                    <label for="password" style="font-size:14px; display:block; margin-bottom:5px;">Kata Sandi Baru:</label>
                    <input id="password" name="password" type="password" placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4CAF50; outline:none; transition:0.3s; box-sizing: border-box;"
                        onfocus="this.style.boxShadow='0 0 8px rgba(76,175,80,0.3)'"
                        onblur="this.style.boxShadow='none'" />
                    <i class="toggle-password"
                        style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;">
                        <i class="eye-icon fa fa-eye-slash" style="font-size:20px; color:#4CAF50;"></i>
                    </i>
                    <div id="password-error" style="color:#ff4444; font-size:12px; margin-top:4px; height:16px;"></div>
                </div>

                <div style="margin-bottom:15px; position: relative;">
                    <label for="password-confirmation" style="font-size:14px; display:block; margin-bottom:5px;">Konfirmasi Kata Sandi Baru:</label>
                    <input id="password-confirmation" name="password_confirmation" type="password" placeholder="********"
                        style="width:100%; padding:12px 20px; border-radius:20px; border:1.5px solid #4CAF50; outline:none; transition:0.3s; box-sizing: border-box;"
                        onfocus="this.style.boxShadow='0 0 8px rgba(76,175,80,0.3)'"
                        onblur="this.style.boxShadow='none'" />
                    <i class="toggle-password"
                        style="position:absolute; top:65%; right:15px; transform:translateY(-50%); cursor:pointer;">
                        <i class="eye-icon fa fa-eye-slash" style="font-size:20px; color:#4CAF50;"></i>
                    </i>
                </div>

                <button type="submit"
                    style="width:100%; padding:12px; border-radius:20px; border:none; background:linear-gradient(to right, #4CAF50, #8BC34A); color:white; font-weight:bold; font-size:14px; cursor:pointer; transition:all 0.3s ease;"
                    onmouseover="this.style.opacity='0.9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(76,175,80,0.3)'"
                    onmouseout="this.style.opacity='1'; this.style.transform='none'; this.style.boxShadow='none'">
                    Atur ulang kata sandi
                </button>
            </form>
            <div style="text-align:center; font-size:14px; margin-top:15px;">
                Sudah ingat kata sandi?
                <a href="{{ route('wisatawan.login') }}" style="color:#4caf50; text-decoration:none; font-weight:500;">Masuk</a>
            </div>
        </div>

        <!-- Logo kanan -->
        <div class="logo-container"
            style="flex:1; min-height:300px; background:linear-gradient(to bottom right, #0917d5, #86e77a); display:flex; flex-direction:column; justify-content:center; align-items:center; padding:30px; text-align:center;">
            <img id="logo-img" src="{{ asset('assets/wisatawan/images/logo/logo-white.png') }}" alt="Logo"
                style="max-width:300px; width:100%; margin:0 auto; height:auto;" />
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function () {
                const input = this.previousElementSibling;
                const icon = this.querySelector('.eye-icon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                }
            });
        });

        function handleResponsiveLayout() {
            const container = document.querySelector('body > div');
            const form = document.querySelector('.form-container');
            const logo = document.querySelector('.logo-container');
            const logoImg = document.getElementById('logo-img');

            if (window.innerWidth <= 768) {
                container.style.flexDirection = 'column-reverse';
                container.style.height = 'auto';
                container.style.width = '95%';
                container.style.margin = '20px 0';

                form.style.width = '95%';
                form.style.padding = '15px 10px';
                form.style.borderRadius = '0 0 30px 30px';

                logo.style.width = '100%';
                logo.style.minHeight = '120px';
                logo.style.padding = '15px';
                logo.style.borderRadius = '12px 12px 0 0';

                if (logoImg) logoImg.style.maxWidth = '180px';
            } else {
                container.style.flexDirection = 'row';
                container.style.height = '630px';
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
                text: '{{ session('success') }}'
            });
        @elseif ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}'
            });
        @endif
    </script>
</body>
</html>
