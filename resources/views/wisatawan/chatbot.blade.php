@extends('layouts.wisatawan')

@section('title', 'Halaman Teman Wisata')

@section('content')
    <style>
        .modal-header {
            background-color: #4caf50;
            color: white;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
        }

        .modal-content {
            border: none;
            border-radius: 10px;
        }

        .modal-body {
            padding: 2rem;
            font-family: 'Segoe UI', sans-serif;
        }

        .btn-primary {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        .btn-outline-primary {
            border-color: #4caf50;
            color: #4caf50;
        }

        .btn-outline-primary:hover {
            background-color: #4caf50;
            color: white;
        }

        #input::placeholder {
            color: white;
            opacity: 1;
            /* supaya tidak transparan */
        }
    </style>

    <div class="w-100 min-vh-100 d-flex flex-column mt-4" style="background-color: #05113b;">
        {{-- Headernya  --}}
        <div class="container-fluid d-flex align-items-center p-2 mt-3">
            <div style="width: 40px; height: 50px;"></div>
            <div style="width: 50px;height: 50px;">
                <img src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="">
            </div>
            <div class="text-white fw-semibold ms-2 fs-5">
                Teman Wisata
            </div>
        </div>

        <div style="background: #061128;height: 2px;"></div>

        {{-- chat content  --}}
        <div id="content-box" class="container-fluid px-3 py-2 mt-3 overflow-auto"
            style="flex-grow: 1; min-height: 100px; max-height: calc(100vh - 162px);">



            {{-- wisatawan --}}

            {{-- chatbot  --}}
            <div class="d-flex mb-3 align-items-start">
                <div class="me-2" style="width: 45px; height: 45px;">
                    <img src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="">
                </div>
                <div class="text-white px-3 py-2"
                    style="background: #13254b; border-radius: 10px; font-size: 85%; max-width: 270px;">
                    Hai, saya chatbot
                </div>
            </div>
            <div class="d-flex mb-3 align-items-start">
                <div class="me-2" style="width: 45px; height: 45px;">
                    <img src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="">
                </div>
                <div class="text-white px-3 py-2"
                    style="background: #13254b; border-radius: 10px; font-size: 85%; max-width: 270px;">
                    Ada yang bisa saya bantu?
                </div>
            </div>
        </div>
        {{-- Input Area --}}
        <div class="container-fluid w-100 px-3 py-2 d-flex" style="background: #131f45; height: 62px;">
            <div class="me-2 pl-2" style="background: #ffffff1c; width: calc(100% - 45px); border-radius: 5px;">
                <input type="text" id="input" name="input" class="text-white" placeholder=" Tanyakan apa saja..."
                    style="background: none; width: 100%; height: 100%; border: 0; outline: none;">
            </div>
            <div id="button-submit" class="text-center"
                style="background: #027e40; height: 100%; width: 50px; border-radius: 5px;">
                <i class="fa fa-paper-plane text-white" aria-hidden="true" style="line-height: 45px;"></i>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade show" id="chatModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-body text-center">
                    <p class="fs-5 text-success fw-semibold mb-4">
                        👋 Halo, Selamat Datang di <strong>Teman Wisata</strong>!
                    </p>
                    <p class="text-secondary fw-semibold mb-3">
                        Saya adalah asisten virtual kamu, siap membantu menemukan destinasi terbaik, tips perjalanan, dan
                        info wisata menarik lainnya yang ada diBatam.
                    </p>
                    <p class="text-dark fw-bold mt-3">
                        Pilih salah satu untuk mulai berbagi cerita:)
                    </p>

                    <div class="d-grid gap-2 mt-4">
                        <a href="" class="btn btn-primary">Masuk</a>
                        <a href="" class="btn btn-outline-primary">Daftar Gratis</a>
                        <button class="btn btn-secondary" onclick="closeModal()">Tetap Keluar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- script cdn  --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        const profileImage = "{{ asset('assets/images/avatars/profile-image-1.png') }}";

        function scrollToBottom() {
            const contentBox = $('#content-box')[0];
            contentBox.scrollTop = contentBox.scrollHeight;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Mengirim pesan menggunakan tombol submit
        $('#button-submit').on('click', function() {
            let value = $('#input').val();
            if (value.trim() === '') return;

            // Menambah chat ke tampilan
            $('#content-box').append(`
            <div class="d-flex justify-content-end mb-3 align-items-center">
                <div class="px-3 py-2 text-white" style="background:#4acfee; border-radius: 10px; font-size: 85%; max-width: 270px;">
                    ${value}
                </div>
                <div class="ms-2" style="width: 45px; height: 45px;">
                    <img src="${profileImage}" alt="" class="img-fluid rounded-circle">
                </div>
            </div>
        `);

            $('#input').val('');
            scrollToBottom();

            // Kirim pesan menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: '{{ url('send') }}',
                data: {
                    'input': value,
                    '_token': $('meta[name="csrf-token"]').attr('content') // ← ini tambahan pentingnya
                },

                success: function(data) {
                    // Menambahkan balasan dari chatbot ke chat
                    $('#content-box').append(`
                    <div class="d-flex mb-3 align-items-start">
                        <div class="me-2" style="width: 45px; height: 45px;">
                            <img src="{{ asset('assets/images/avatars/profile-image.png') }}" alt="">
                        </div>
                        <div class="text-white px-3 py-2"
                            style="background: #13254b; border-radius: 10px; font-size: 85%; max-width: 270px;">
                            ${data}
                        </div>
                    </div>
                `);
                    scrollToBottom();
                }
            });
        });

        // Mengirim pesan menggunakan Enter key
        $('#input').on('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault(); // Mencegah newline
                $('#button-submit').click(); // Mengklik tombol submit secara otomatis
            }
        });

        // Scroll ke bawah ketika halaman pertama kali dimuat
        $(document).ready(function() {
            scrollToBottom();
        });
    </script>




    {{-- Script Modal --}}
    <script>
        function closeModal() {
            const modal = document.getElementById('chatModal');
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }

        // Lock scroll while modal is open
        document.body.classList.add('modal-open');
    </script>
@endsection
