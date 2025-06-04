<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teman Wisata - Chatbot</title>

    {{-- Favicon dan Fonts --}}
    <link rel="shortcut icon" href="{{ asset('assets/wisatawan/images/favicon.ico') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="modal fade" id="chatbotModal" tabindex="-1" aria-labelledby="chatbotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center"
                    style="background-color: #1f37f1; border-bottom: none; border-radius: 8px 8px 0 0;">
                    <h5 class="modal-title flex-grow-1" id="chatbotModalLabel">
                        <img src="{{ asset('assets/wisatawan/images/logo/logo-white1.png') }}" class="me-2"
                            style="height: 30px; width: auto; display: inline-block;">
                        <span style="color: #ffffff">Teman Wisata</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body p-3" style="background-color: #ffffff; border-radius: 0 0 8px 8px;">
                    <div class="chat-messages" style="height: 350px; overflow-y: auto; padding: 10px;">
                        <div class="d-flex mb-3 align-items-start">
                            <img src="{{ asset('assets/wisatawan/images/logo/logo-white1.png') }}" class="me-2"
                                style="height: 30px; width: auto; display: inline-block;">
                            <div class="p-3 bg-light rounded"
                                style="max-width: 85%; background-color: #b7b7b7; border-radius: 15px;">
                                Halo, selamat datang di Guide Me! Kami bisa menjawab semua pertanyaanmu.
                            </div>
                        </div>
                    </div>

                    <div class="input-group mt-3" style="border-top: 1px solid #9f9c9c; padding-top: 10px;">
                        <input type="text" id="user-input" class="form-control"
                            placeholder="Apa yang mau kamu tanya?" aria-label="Apa yang mau kamu tanya?"
                            style="border-radius: 20px; padding: 10px 15px; border-color: #bababa;">
                        <button class="btn" type="button" id="button-send"
                            style="background-color: #200381; color: white; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Kirim pesan saat tombol "Kirim" diklik
            $('#button-send').click(function() {
                sendMessage();
            });

            // Kirim pesan saat tombol "Enter" ditekan
            $('#user-input').keydown(function(event) {
                if (event.key === "Enter") {
                    event.preventDefault(); // Mencegah enter membuat baris baru
                    sendMessage(); // Kirim pesan
                }
            });

            // Fungsi untuk mengirim pesan
            function sendMessage() {
                const userMessage = $('#user-input').val();
                if (!userMessage) return;

                const chatBox = $('.chat-messages');

                // Tambahkan pesan user ke chat
                chatBox.append(`
                    <div class="d-flex mb-3 justify-content-end">
                        <div class="p-3 rounded text-white" style="max-width: 85%; background-color: #04c227; border-radius: 15px;">
                            ${userMessage}
                        </div>
                    </div>
                `);

                $('#user-input').val(''); // kosongkan input

                // Kirim ke backend
                $.ajax({
                    url: "{{ url('/wisatawan/chatbot/send') }}",
                    method: "POST",
                    data: {
                        message: userMessage,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        console.log(res); // Debugging - lihat data apa yang dikirim dari backend

                        // Cek apakah ada error atau tidak
                        if (res.error) {
                            alert(res.error);
                            return;
                        }

                        // Proses balasan dari backend dan masukkan ke chat
                        let chatbotMessage = res.reply;

                        const regex = /(Klik untuk detail: )(.+)/;
                        if (regex.test(chatbotMessage)) {
                            // Mengganti bagian "Klik untuk detail:" dengan link
                            chatbotMessage = chatbotMessage.replace(regex, function(match, p1, p2) {
                                const detailLink = `<a href="${p2}" target="_blank">${p2}</a>`;
                                return p1 + detailLink;
                            });
                        }

                        chatBox.append(`
                            <div class="d-flex mb-3 align-items-start">
                                <img src="{{ asset('assets/wisatawan/images/logo/logo-white1.png') }}" class="me-2" style="height: 30px;">
                                <div class="p-3 bg-light rounded" style="max-width: 85%; background-color: #b7b7b7; border-radius: 15px;">
                                    ${chatbotMessage}
                                </div>
                            </div>
                        `);

                        chatBox.scrollTop(chatBox[0].scrollHeight); // auto scroll ke bawah
                    },

                    error: function(err) {
                        alert('Terjadi kesalahan: ' + err.responseText);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatbotTrigger = document.getElementById('chatbotTrigger');
            if (chatbotTrigger) {
                chatbotTrigger.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah link default action
                    var myModal = new bootstrap.Modal(document.getElementById('chatbotModal'));
                    myModal.show();
                });
            }
        });
    </script>
</body>

</html>
