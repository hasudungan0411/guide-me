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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

                        <button class="btn" type="button" id="button-mic"
                            style="background-color: #28a745; color: white; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                            <i class="fas fa-microphone"></i>
                        </button>
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
        const micButton = document.getElementById('button-mic');
        const inputField = document.getElementById('user-input');
        const sendButton = document.getElementById('button-send');

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            alert("Browser tidak mendukung voice recognition.");
        } else {
            const recognition = new SpeechRecognition();
            recognition.lang = 'id-ID';
            recognition.continuous = true;
            recognition.interimResults = true;

            let finalTranscript = '';

            micButton.addEventListener('click', () => {
                finalTranscript = '';
                inputField.value = '';
                recognition.start();
                micButton.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i>`;
            });

            recognition.onresult = (event) => {
                let interimTranscript = '';

                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    const result = event.results[i];
                    if (result.isFinal) {
                        finalTranscript += result[0].transcript + ' ';
                    } else {
                        interimTranscript += result[0].transcript;
                    }
                }

                inputField.value = finalTranscript + interimTranscript;

                if (finalTranscript.trim() !== '') {
                    sendButton.click();
                    recognition.stop();
                }
            };

            recognition.onend = () => {
                micButton.innerHTML = `<i class="fas fa-microphone"></i>`;
            };

            recognition.onerror = (event) => {
                console.warn("Voice error:", event.error);
                micButton.innerHTML = `<i class="fas fa-microphone"></i>`;
            };
        }
    </script>

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
                        console.log(res);

                        // Proses balasan dari backend dan masukkan ke chat
                        let chatbotMessage = res.balasan;

                        // menggunakan reguler expresion utk semua url
                        const urlRegex = /(https?:\/\/[^\s]+)/g;




                        if (urlRegex.test(chatbotMessage)) {
                            // Mengganti bagian "Klik untuk detail:" dengan link
                            chatbotMessage = chatbotMessage.replace(urlRegex, function(url) {
                                return `<a href="${url}" target="_blank">${url}</a>`;
                            });
                        }

                        // Menambahkan pesan chatbot ke chat
                        const chatBox = $('.chat-messages');
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
            const chatbotTriggerMobile = document.getElementById('chatbotTriggerMobile');
            const chatbotTriggerDesktop = document.getElementById('chatbotTriggerDesktop');

            // Event Listener untuk tombol mobile
            if (chatbotTriggerMobile) {
                chatbotTriggerMobile.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah link default action
                    var myModal = new bootstrap.Modal(document.getElementById('chatbotModal'));
                    myModal.show();
                });
            }

            // Event Listener untuk tombol desktop
            if (chatbotTriggerDesktop) {
                chatbotTriggerDesktop.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah link default action
                    var myModal = new bootstrap.Modal(document.getElementById('chatbotModal'));
                    myModal.show();
                });
            }
        });
    </script>
</body>

</html>
