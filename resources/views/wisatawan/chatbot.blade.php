@extends('layouts.wisatawan')

@section('title', 'Halaman Teman Wisata')

@section('content')
    <style>
        body.modal-open {
            overflow: hidden;
        }

        .chat-box {
            background-color: #e9f5ec;
            border: 2px solid #c7e8d1;
            border-radius: 10px;
        }

        .chat-box p {
            color: #4a4a4a;
        }

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
    </style>

    <div class="container py-5" style="min-height: 90vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {{-- Chat Placeholder --}}
                <div class="chat-box p-4 shadow-sm">
                    <h5 class="text-center mb-4" style="color: #388e3c;">Teman Wisata</h5>
                    <p class="text-center">Area percakapan akan muncul di sini setelah kamu memulai obrolan.</p>
                </div>
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

    {{-- Script --}}
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
