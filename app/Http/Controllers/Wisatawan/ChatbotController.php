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
        $userMessage = strtolower($request->input('message')); // Ubah ke lowercase untuk pencarian yang lebih baik

        // --- Pengecekan untuk pertanyaan statistik atau umum ---
        if (stripos($userMessage, 'jumlah destinasi') !== false || stripos($userMessage, 'ada berapa destinasi') !== false) {
            return response()->json(['reply' => $this->getDestinationCount()]);
        }

        if (stripos($userMessage, 'jumlah kategori') !== false || stripos($userMessage, 'ada berapa kategori') !== false) {
            return response()->json(['reply' => $this->getCategoryCount()]);
        }

        // --- Pengecekan untuk pertanyaan terkait destinasi, acara, atau tiket ---
        // Prioritaskan pencarian destinasi dari pesan pengguna yang lebih umum
        $destination = $this->extractAndFindDestination($userMessage);

        // Jika destinasi ditemukan, coba cari informasi detail, tiket, atau acara
        if ($destination) {
            if (stripos($userMessage, 'harga tiket') !== false || stripos($userMessage, 'stok tiket') !== false || stripos($userMessage, 'tiket') !== false) {
                return response()->json(['reply' => $this->getTicketPrice($destination)]);
            }

            if (stripos($userMessage, 'acara') !== false || stripos($userMessage, 'event') !== false) {
                $acara = $this->findEventForDestination($destination);
                if ($acara) {
                    $response = "Acara di " . $destination->tujuan . ":\n";
                    $response .= "Nama Acara: " . $acara->Nama_acara . "\n" .
                        "Tanggal: " . $acara->Tanggal_acara . "\n" .
                        "Deskripsi: " . substr($acara->Deskripsi, 0, 150) . "..."; // Deskripsi lebih panjang
                    return response()->json(['reply' => $response]);
                } else {
                    return response()->json(['reply' => "Maaf, tidak ada acara yang terdaftar untuk destinasi " . $destination->tujuan . " saat ini."]);
                }
            }

            // Jika tidak ada kata kuncii spesifik tiket/acara, berikan informasi umum tentang destinasi
            return response()->json(['reply' => $this->formatDestinationResponse($destination)]);
        }

        // Pengecekan untuk pertanyaan acara umum (jika tidak ada destinasi spesifik yang ditanyakan)
        if (stripos($userMessage, 'acara apa saja') !== false || stripos($userMessage, 'event apa saja') !== false || stripos($userMessage, 'daftar acara') !== false) {
            $destinationsWithEvents = $this->findDestinationsWithEvents();
            if ($destinationsWithEvents->isEmpty()) {
                return response()->json(['reply' => "Maaf, saat ini tidak ada destinasi yang memiliki acara."]);
            } else {
                $response = "Berikut adalah beberapa destinasi yang memiliki acara:\n";
                foreach ($destinationsWithEvents as $destination) {
                    $acara = $this->findEventForDestination($destination);
                    if ($acara) { // Pastikan ada acara terkait
                        $response .= "- " . $destination->tujuan . " (Acara: " . $acara->Nama_acara . ", Tanggal: " . $acara->Tanggal_acara . ")\n";
                    }
                }
                $response .= "\nApakah Anda ingin melihat lebih lanjut tentang acara di destinasi tertentu?";
                return response()->json(['reply' => $response]);
            }
        }

        // Jika pertanyaan tidak ada di database, kirimkan permintaan ke OpenAI
        $openAiResponse = $this->getNLPResponse($userMessage);
        return response()->json(['reply' => $openAiResponse]);
    }

    // Fungsi untuk mendapatkan respons dari OpenAI (NLP)
    private function getNLPResponse($message)
    {
        try {
            $apiKey = env('OPENAI_API_KEY');
            if (!$apiKey) {
                return "Kunci API OpenAI tidak ditemukan. Silakan atur variabel lingkungan OPENAI_API_KEY.";
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json', // Tambahkan header ini
            ])->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4.1-mini', //
                        'messages' => [
                            ['role' => 'user', 'content' => $message],
                        ],
                        'max_tokens' => 100,
                        'temperature' => 0.5, // Sesuaikan untuk kreativitas vs. faktual
                    ]);

            if ($response->successful()) {
                $responseBody = $response->json();
                if (isset($responseBody['choices'][0]['message']['content'])) {
                    return $responseBody['choices'][0]['message']['content'];
                }
            } else {
                return "Gagal mendapatkan respons dari OpenAI. Status: " . $response->status() . ", Pesan: " . ($response->json()['error']['message'] ?? 'Tidak ada pesan kesalahan.');
            }
        } catch (\Exception $e) {
            return "Terjadi kesalahan saat menghubungi API eksternal: " . $e->getMessage();
        }

        return "Maaf, saya tidak bisa memahami pertanyaan Anda.";
    }

    // Fungsi untuk menghitung jumlah destinasi
    private function getDestinationCount()
    {
        $count = Destination::count();
        return "Saat ini ada " . $count . " destinasi yang tersedia di website kami.";
    }

    // Fungsi untuk menghitung jumlah kategori
    private function getCategoryCount()
    {
        $categoryCount = Kategori::count();
        return "Saat ini ada " . $categoryCount . " kategori yang tersedia.";
    }

    // Fungsi untuk mendapatkan harga tiket di destinasi
    private function getTicketPrice($destination)
    {
        $tickets = Tiket::where('ID_Wisata', $destination->id)->get();
        if ($tickets->isEmpty()) {
            return "Saat ini tidak ada harga tiket yang terdaftar untuk destinasi " . $destination->tujuan . ".";
        }

        $response = "Harga tiket di destinasi " . $destination->tujuan . ":\n";
        foreach ($tickets as $ticket) {
            $response .= "- Rp" . number_format($ticket->Harga, 0, ',', '.') . " per tiket, dengan " .
                $ticket->Persediaan . " tiket tersedia.\n";
        }
        return $response;
    }

    /**
     * Fungsi untuk mengekstrak nama destinasi dari pesan pengguna dan mencarinya.
     * Meningkatkan fleksibilitas pencarian.
     */
    private function extractAndFindDestination($message)
    {
        // Daftar kata kunci yang mungkin mendahului nama destinasi atau frasa yang diikuti nama destinasi
        $keywords = [
            'tentang',
            'informasi',
            'dimana',
            'apa',
            'bagaimana',
            'berapa',
            'jumlah',
            'ada berapa',
            'total',
            'berapa harga tiket di',
            'deskripsi',
            'stok tiket di',
            'acara di',
            'event di',
            'wisata',
            'destinasi',
            'tempat'
        ];

        // Coba mencari nama destinasi dengan menghapus kata kunci umum
        $cleanedMessage = $message;
        foreach ($keywords as $keyword) {
            $cleanedMessage = str_ireplace($keyword, '', $cleanedMessage);
        }
        $cleanedMessage = trim($cleanedMessage);

        // Coba cari destinasi berdasarkan bagian-bagian pesan
        $words = explode(' ', $cleanedMessage);
        foreach ($words as $word) {
            if (strlen($word) > 2) { // Hindari kata terlalu pendek
                $destination = Destination::where('tujuan', 'LIKE', '%' . $word . '%')->first();
                if ($destination) {
                    return $destination;
                }
            }
        }

        // Coba cari langsung dari pesan asli jika ada yang cocok
        $destination = Destination::where('tujuan', 'LIKE', '%' . $message . '%')->first();
        if ($destination) {
            return $destination;
        }

        return null; // Tidak ditemukan
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

    // Menemukan destinasi yang memiliki acara terkait
    private function findDestinationsWithEvents()
    {
        return Destination::whereHas('acara')->get();
    }

    // Format respons destinasi
    private function formatDestinationResponse($destination)
    {
        $response = "Informasi Destinasi: " . $destination->tujuan . "\n";
        $response .= "Deskripsi: " . substr($destination->desk, 0, 200) . "...\n"; // Deskripsi lebih panjang

        // Menambahkan kategori destinasi
        $kategori = $destination->kategori;
        if ($kategori) {
            $response .= "Kategori: " . $kategori->nama_kategori . "\n";
        }

        // Menambahkan acara terkait destinasi
        $acara = $this->findEventForDestination($destination);
        if ($acara) {
            $response .= "Acara Terkait: " . $acara->Nama_acara . " (Tanggal: " . $acara->Tanggal_acara . ")\n";
        }

        // Menambahkan tiket terkait destinasi
        $tiket = $this->findTicketForDestination($destination);
        if ($tiket) {
            $response .= "Harga Tiket: Rp" . number_format($tiket->Harga, 0, ',', '.') . "\n";
            $response .= "Tersedia: " . $tiket->Persediaan . " tiket\n";
        }

        $response .= "Klik untuk detail: " . route('wisatawan.detail_destinasi', ['id' => $destination->id]);
        return $response;
    }
}
