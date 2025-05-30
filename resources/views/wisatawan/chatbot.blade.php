<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teman Wisata - Chatbot</title>

    {{-- Favicon dan Fonts --}}
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Icon dan CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/flaticon/flaticon_gowilds.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/fonts/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/wisatawan/css/custom.css') }}">

    <style>
        body {
            background-color: #d5d4de;
            font-family: 'Prompt', sans-serif;
        }

        .chat-header {
            background-color: transparent;
            padding: 1rem;
        }

        .chat-header img {
            width: 50px;
            height: 50px;
        }

        .chat-title {
            color: rgb(40, 27, 109);
            font-weight: 600;
            font-size: 1.2rem;
            margin-left: 10px;
        }

        #content-box {
            flex-grow: 1;
            overflow-y: auto;
            max-height: calc(100vh - 162px);
            padding: 1rem;
        }

        .chat-bubble {
            font-size: 85%;
            max-width: 270px;
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
            line-height: 1.4;
        }

        .chatbot-msg {
            background-color: #486ddb;
            color: white;
        }

        .user-msg {
            background-color: #0065F8;
            color: white;
        }

        .chat-input {
            background: #131f45;
            height: 62px;
        }

        .chat-input input {
            background: #ffffff1c;
            color: white;
            border: none;
            width: 100%;
            padding: 0.75rem;
            border-radius: 5px;
        }

        .chat-input input::placeholder {
            color: white;
            opacity: 1;
        }

        .send-btn {
            background-color: #027e40;
            color: white;
            width: 50px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="d-flex flex-column min-vh-100">
        {{-- Header --}}
        <div class="container-fluid d-flex align-items-center chat-header" style="background: #353eec">
            <img src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="Bot Avatar">
            <div class="chat-title" style="color: #e9edee">Teman Wisata</div>
        </div>
        <div style="background: #25b025; height: 2px;"></div>

        {{-- Chat Content --}}
        <div id="content-box" class="container-fluid overflow-auto">
            <div class="d-flex mb-3 align-items-start">
                <img class="avatar me-2" src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="Bot Avatar">
                <div class="chat-bubble chatbot-msg">Hai, saya Teman Wisata sebagai asisten virtual kamu.</div>
            </div>
            <div class="d-flex mb-3 align-items-start">
                <img class="avatar me-2" src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="Bot Avatar">
                <div class="chat-bubble chatbot-msg">Ada yang bisa saya bantu?</div>
            </div>
        </div>

        {{-- Input Area --}}
        <div class="container-fluid chat-input d-flex px-3">
            <input type="text" id="input" placeholder="Tanyakan apa saja...">
            <div id="button-submit" class="send-btn ms-2">
                <i class="fa fa-paper-plane"></i>
            </div>
        </div>
    </div>

    {{-- Guest Modal --}}
    @guest('wisatawan')
        <div class="modal fade show" id="chatModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-body text-center">
                        <p class="fs-5 text-success fw-semibold mb-4">👋 Halo, Selamat Datang di <strong>Teman Wisata</strong>!</p>
                        <p class="text-secondary fw-semibold mb-3">Saya adalah asisten virtual kamu, siap membantu menemukan destinasi terbaik di Batam.</p>
                        <p class="text-dark fw-bold mt-3">Pilih salah satu untuk mulai berbagi cerita :)</p>
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('wisatawan.login') }}" class="btn btn-primary">Masuk</a>
                            <a href="{{ route('wisatawan.register') }}" class="btn btn-outline-primary">Daftar</a>
                            <button class="btn btn-secondary" onclick="closeModal()">Tetap Keluar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function closeModal() {
                const modal = document.getElementById('chatModal');
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.classList.remove('modal-open');
            }
            document.body.classList.add('modal-open');
        </script>
    @endguest

    {{-- Script --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @php
        $user = auth('wisatawan')->user();
        $profileImage = $user && $user->Foto_Profil ? $user->Foto_Profil : asset('assets/images/avatars/profile-image-1.png');
    @endphp

    <script>
        const profileImage = "{{ $profileImage }}";

        function scrollToBottom() {
            const box = document.getElementById('content-box');
            box.scrollTop = box.scrollHeight;
        }

        function appendMessage(message, sender = 'bot') {
            const container = document.createElement('div');
            container.classList.add('d-flex', 'mb-3', 'align-items-start');
            if (sender === 'user') {
                container.classList.add('justify-content-end');
                container.innerHTML = `
                    <div class="chat-bubble user-msg">${message}</div>
                    <img class="avatar ms-2" src="${profileImage}" alt="User Avatar">
                `;
            } else {
                container.innerHTML = `
                    <img class="avatar me-2" src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="Bot Avatar">
                    <div class="chat-bubble chatbot-msg">${message}</div>
                `;
            }
            document.getElementById('content-box').appendChild(container);
            scrollToBottom();
        }

        $('#button-submit').on('click', function () {
            const value = $('#input').val().trim();
            if (!value) return;

            appendMessage(value, 'user');
            $('#input').val('');

            $.ajax({
                method: 'POST',
                url: '{{ url("send") }}',
                data: {
                    input: value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    appendMessage(response, 'bot');
                },
                error: function () {
                    appendMessage('Maaf, terjadi kesalahan.', 'bot');
                }
            });
        });

        $('#input').on('keydown', function (e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                $('#button-submit').click();
            }
        });

        $(document).ready(function () {
            scrollToBottom();
        });
    </script>
</body>
</html>
