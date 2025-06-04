<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Acara;
use App\Models\Kategori;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // Ambil pesan dari user
        $userMessage = $request->input('message');

        // Kirim ke OpenAI API untuk memproses dengan NLP
        $response = $this->getNLPResponse($userMessage);

        // Cek apakah GPT memberikan respons yang relevan mengenai jumlah destinasi
        if ($this->isAskingAboutDestinationCount($response)) {
            $response = $this->getDestinationCount();
        }

        // Cek apakah GPT bertanya tentang jumlah kategori
        if ($this->isAskingAboutCategoryCount($response)) {
            $response = $this->getCategoryCount();
        }

        // Cek apakah GPT bertanya tentang jumlah tiket harga di destinasi
        if ($this->isAskingAboutTicketCount($response)) {
            $destination = $this->findDestination($userMessage);
            if ($destination) {
                $response = $this->getTicketCount($destination);
            } else {
                $response = "Maaf, saya tidak dapat menemukan destinasi yang dimaksud.";
            }
        }

        // Cek apakah GPT bertanya tentang jumlah acara di destinasi
        if ($this->isAskingAboutEventList($response)) {
            $destination = $this->findDestination($userMessage);
            if ($destination) {
                $response = $this->getEventList($destination);
            } else {
                $response = "Maaf, saya tidak dapat menemukan destinasi yang dimaksud.";
            }
        }

        // Cek apakah GPT bertanya tentang harga tiket di destinasi tertentu
        if ($this->isAskingAboutTicketPrice($response)) {
            $destination = $this->findDestination($userMessage);
            if ($destination) {
                $response = $this->getTicketPrice($destination);
            } else {
                $response = "Maaf, saya tidak dapat menemukan destinasi yang dimaksud.";
            }
        }

        // Cek apakah ada pembahasan acara, kategori, tiket atau destinasi
        if (stripos($userMessage, 'acara') !== false || stripos($userMessage, 'event') !== false) {
            $destinationsWithEvents = $this->findDestinationsWithEvents();
            if ($destinationsWithEvents->isEmpty()) {
                $response = "Maaf, saat ini tidak ada destinasi yang memiliki acara.";
            } else {
                $response = "Berikut adalah beberapa destinasi yang memiliki acara:\n";
                foreach ($destinationsWithEvents as $destination) {
                    $response .= "- " . $destination->tujuan . "\n";
                    $acara = $this->findEventForDestination($destination);
                    $response .= "  Acara: " . $acara->Nama_acara . "\n" .
                        "  Tanggal: " . $acara->Tanggal_acara . "\n" .
                        "  Deskripsi: " . substr($acara->Deskripsi, 0, 100) . "... \n";
                }
                $response .= "Apakah Anda ingin melihat lebih lanjut tentang acara di destinasi tertentu?";
            }
        }

        // Jika bertanya tentang destinasi dan informasi lengkapnya
        $destination = $this->findDestination($userMessage);
        if ($destination) {
            // Jika destinasi ditemukan, kirimkan informasi lengkap tentang destinasi
            $response = $this->formatDestinationResponse($destination);

            // Menambahkan acara terkait destinasi
            $acara = $this->findEventForDestination($destination);
            if ($acara) {
                $response .= "\nAcara Terkait: " . $acara->Nama_acara . "\n" .
                    "Tanggal: " . $acara->Tanggal_acara . "\n" .
                    "Deskripsi: " . substr($acara->Deskripsi, 0, 100) . "...";  // Deskripsi dibatasi
            }

            // Menambahkan kategori destinasi
            $kategori = $destination->kategori; // Kategori sudah dihubungkan lewat relasi
            if ($kategori) {
                $response .= "\nKategori: " . $kategori->nama_kategori;
            }

            // Menambahkan tiket terkait destinasi
            $tiket = $this->findTicketForDestination($destination);
            if ($tiket) {
                $response .= "\nHarga Tiket: Rp" . number_format($tiket->Harga, 0, ',', '.');
                $response .= "\nTersedia: " . $tiket->Persediaan . " tiket";
            }
        }

        return response()->json(['reply' => $response]);
    }

    // Fungsi untuk mendapatkan respons dari OpenAI (NLP)
    private function getNLPResponse($message)
    {
        try {
            $apiKey = env('OPENAI_API_KEY');
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4.1-mini', // Ganti dengan model yang sesuai
                        'messages' => [
                            ['role' => 'user', 'content' => $message],
                        ],
                        'max_tokens' => 100,
                    ]);

            if ($response->successful()) {
                $responseBody = $response->json();
                if (isset($responseBody['choices'][0]['message']['content'])) {
                    return $responseBody['choices'][0]['message']['content'];
                }
            }
        } catch (\Exception $e) {
            return "Terjadi kesalahan saat menghubungi API eksternal: " . $e->getMessage();
        }

        return "Maaf, saya tidak bisa memahami pertanyaan Anda.";
    }

    // Menemukan semua destinasi yang memiliki acara terkait
    private function findDestinationsWithEvents()
    {
        return Destination::whereHas('acara')->get(); // Ambil destinasi yang memiliki acara terkait
    }
    // Fungsi untuk memeriksa apakah GPT bertanya tentang acara yang terdaftar
    private function isAskingAboutEventList($response)
    {
        return stripos($response, 'acara') !== false || stripos($response, 'event') !== false;
    }
    // Fungsi untuk mendapatkan daftar acara yang terdaftar di destinasi
    private function getEventList($destination)
    {
        $events = Acara::where('ID_Wisata', $destination->id)->get();
        if ($events->isEmpty()) {
            return "Saat ini tidak ada acara yang terdaftar di destinasi ini.";
        }

        $response = "Berikut adalah acara yang terdaftar di destinasi " . $destination->tujuan . ":\n";
        foreach ($events as $event) {
            $response .= "- " . $event->Nama_acara . "\n" .
                "  Tanggal: " . $event->Tanggal_acara . "\n" .
                "  Deskripsi: " . substr($event->Deskripsi, 0, 100) . "... \n";
        }
        return $response;
    }

    // Fungsi untuk memeriksa apakah GPT bertanya tentang harga tiket di destinasi
    private function isAskingAboutTicketPrice($response)
    {
        return stripos($response, 'harga tiket') !== false || stripos($response, 'berapa harga tiket') !== false;
    }
    // Fungsi untuk memeriksa apakah GPT bertanya tentang jumlah tiket harga di destinasi
    private function isAskingAboutTicketCount($response)
    {
        return stripos($response, 'stok tiket') !== false || stripos($response, 'jumlah tiket') !== false;
    }
    // Fungsi untuk mendapatkan harga tiket di destinasi
    private function getTicketPrice($destination)
    {
        $tickets = Tiket::where('ID_Wisata', $destination->id)->get();
        if ($tickets->isEmpty()) {
            return "Saat ini tidak ada harga tiket yang terdaftar untuk destinasi ini.";
        }

        $response = "Harga tiket di destinasi " . $destination->tujuan . ":\n";
        foreach ($tickets as $ticket) {
            $response .= "- Rp" . number_format($ticket->Harga, 0, ',', '.') . " per tiket, dengan " .
                $ticket->Persediaan . " tiket tersedia.\n";
        }
        return $response;
    }

    // Fungsi untuk memeriksa apakah GPT bertanya tentang jumlah kategori
    private function isAskingAboutCategoryCount($response)
    {
        return stripos($response, 'jumlah kategori') !== false || stripos($response, 'berapa banyak kategori') !== false;
    }

    // Fungsi untuk menghitung jumlah kategori yang ada di database
    private function getCategoryCount()
    {
        $categoryCount = Kategori::count();
        return "Saat ini ada " . $categoryCount . " kategori yang tersedia.";
    }

    // Fungsi untuk menghitung jumlah harga tiket yang tersedia di suatu destinasi
    private function getTicketCount($destination)
    {
        $ticketCount = Tiket::where('ID_Wisata', $destination->id)->count();
        return "Saat ini ada " . $ticketCount . " harga tiket yang tersedia untuk destinasi ini.";
    }

    // Fungsi untuk memeriksa apakah jawaban dari GPT mengandung informasi terkait jumlah destinasi
    private function isAskingAboutDestinationCount($response)
    {
        return stripos($response, 'jumlah destinasi') !== false || stripos($response, 'berapa banyak destinasi') !== false;
    }

    // Mengambil jumlah destinasi yang ada di database
    private function getDestinationCount()
    {
        $count = Destination::count();
        return "Saat ini ada " . $count . " destinasi yang tersedia di website kami.";
    }

    // Mencari destinasi berdasarkan input pengguna
    private function findDestination($message)
    {
        return Destination::where('tujuan', 'LIKE', '%' . $message . '%')->first();
    }

    // Menemukan acara terkait destinasi
    private function findEventForDestination($destination)
    {
        return Acara::where('ID_Wisata', $destination->id)->first();
    }

    // Menemukan tiket terkait destinasi
    private function findTicketForDestination($destination)
    {
        return Tiket::where('ID_Wisata', $destination->id)->first();
    }

    // Format respons destinasi
    private function formatDestinationResponse($destination)
    {
        return "Destinasi: " . $destination->tujuan . "\n" .
            "Deskripsi: " . substr($destination->desk, 0, 100) . "...\n" .  // Deskripsi dipersingkat
            "Klik untuk detail: " . route('wisatawan.detail_destinasi', ['id' => $destination->id]);
    }
}
