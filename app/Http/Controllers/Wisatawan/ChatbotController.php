<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Acara;
use App\Models\Kategori;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;

class ChatbotController extends Controller
{
    // treshold (batas minimum kemiripan) agar dianggap relevan
    const AMBANG_BATAS_KEMIRIPAN = 0.75; // 75% kemiripan

    public function balaspesan(Request $request)
    {
        // Validasi input
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $pesanPengguna = strtolower($request->input('message'));

        if (empty($pesanPengguna)) {
            return response()->json(['balasan' => 'Pesan tidak boleh kosong. Silakan coba lagi.'], 400);
        }

        // cth pertanyaan simple dari db tanpa ai yg kompleks
        // jumlah destinasi
        if (str_contains($pesanPengguna, 'total destinasi') || str_contains($pesanPengguna, 'jumlah destinasi') !== false) {
            $totalDestinasi = Destination::count();
            return response()->json([
                'balasan' => "Saat ini ada {$totalDestinasi} destinasi yang terdaftar di website kami.",
                'dari_data_internal' => true
            ]);
        }

        // deteksi permintaan lokasi destinasi
        if (str_contains($pesanPengguna, 'maps') || str_contains($pesanPengguna, 'peta') || str_contains($pesanPengguna, 'lokasi')) {
            $kataKunci = ['maps', 'lokasi', 'dimana', 'peta', 'berikan', 'saya', 'untuk', 'destinasi'];
            $namaDestinasi = str_replace($kataKunci, '', $pesanPengguna);
            $namaDestinasi = trim($namaDestinasi);

            $destinasi = null;
            if (!empty($namaDestinasi)) {
                // mencari destinasi di db lngsng
                $destinasi = Destination::where('tujuan', 'like', "%{$namaDestinasi}%")->first();
            }

            // jika gagal, gunakan kemiripan RAG
            if (!$destinasi) {
                $informasiRelevan = $this->cariDataInternalRelevan($pesanPengguna);
                $destinasiRAG = $informasiRelevan->Where('tipe', 'destinasi')->first();
                if ($destinasiRAG) {
                    $destinasi = $destinasiRAG['data'];
                }
            }

            if ($destinasi) {
                $mapsUrl = "https://www.google.com/maps/search/?api=1&query={$destinasi->latitude},{$destinasi->longitude}";
                return response()->json([
                    'balasan' => "Berikut tautan Google Maps untuk lokasi {$destinasi->tujuan} dapat ditemukan di: {$mapsUrl}",
                    'dari_data_internal' => true
                ]);
            }
        }

        // deteksi perimntaan destinasi populer
        $kataKunci = ['destinasi populer', 'wisata populer', 'wisata rekomendasi', 'destinasi disukai', 'rekomendasi destinasi', 'rekomendasi wisata'];
        $isPopuler = false;
        foreach ($kataKunci as $kata) {
            if (str_contains($pesanPengguna, $kata)) {
                $isPopuler = true;
                break;
            }
        }

        if ($isPopuler) {
            $rekomendasi = $this->getTopRecommendations(); // ambil rekomendasi destinasi populer

            if ($rekomendasi->isNotEmpty()) {
                $balasanRekomendasi = "Berikut adalah beberapa destinasi populer yang sering dikunjungi:\n";
                foreach ($rekomendasi as $index => $destinasi) {
                    $balasanRekomendasi .= ($index + 1) . ". $destinasi->tujuan";
                    if ($destinasi->kategori) {
                        $balasanRekomendasi .= "({$destinasi->kategori->nama_kategori})";
                    }
                    $balasanRekomendasi .= " - " . substr($destinasi->desk, 0, 100) . (strlen($destinasi->desk) > 100 ? '...' : '') . "\n";
                }
                $balasanRekomendasi .= "semoga anda menemukan destinasi yang menarik!";

                return response()->json([
                    'balasan' => $balasanRekomendasi,
                    'dari_data_internal' => true
                ]);
            }
        }

        // detail destinasi
        $kataKunciDetail = ['detail destinasi', 'deskripsi destinasi', 'link destinasi', 'detail wisata', 'detail tempat wisata', 'detail tempat'];
        $isDetailDestinasi = false;
        foreach ($kataKunciDetail as $kata) {
            if (str_contains($pesanPengguna, $kata)) {
                $isDetailDestinasi = true;
                break;
            }
        }

        // mengambil nama destinasi
        if ($isDetailDestinasi) {
            $namaDetailDestinas = (str_contains($pesanPengguna, '', $kataKunciDetail));
            // hapus spasi kosong yg sisa
            $namaDetailDestinas = trim($namaDetailDestinas);

            if (!empty($namaDetailDestinas)) {
                // mencari destinasi di db
                $destinasi = Destination::where('tujuan', 'like', "%{$namaDetailDestinas}%")->first();

                if ($destinasi) {
                    // kalo ditemukan destinasi, buat deskripsi singkat
                    $deskripsiSingkat = substr($destinasi->desk, 0, 100) . (strlen($destinasi->desk) > 100 ? '...' : '');

                    // buat url nya dan balasannya
                    $detailUrl = route('wisatawan.detail_destinasi', ['id' => $destinasi->id]);
                    $balasan = "Berikut detail singkat dari destinasi {$destinasi->tujuan}:\n" .
                        "Deskripsi: {$deskripsiSingkat}\n" .
                        "untuk detail selengkapnya, silahkan klik link ini: {$detailUrl}";

                    return response()->json([
                        'balasan' => $balasan,
                        'dari_data_internal' => true
                    ]);
                }
            }
        }

        // deteksi permintaan total kategori
        if (str_contains($pesanPengguna, 'total kategori') || str_contains($pesanPengguna, 'jumlah kategori') !== false) {
            $totalKategori = Kategori::count();
            return response()->json([
                'balasan' => "Saat ini ada {$totalKategori} kategori yang terdaftar di website kami.",
                'dari_data_internal' => true
            ]);
        }

        // konsep internal RAG
        $informasiRelevan = $this->cariDataInternalRelevan($pesanPengguna);

        $konteksUntukAI = '';
        $apakahPakaiDataInternal = false;

        if ($informasiRelevan->isNotEmpty()) {
            $konteksUntukAI = "Berikut adalah informasi yang relevan dari data kami:\n";
            foreach ($informasiRelevan as $item) {
                // ambil data relevan dari destinasi atau acara
                if ($item['tipe'] === 'destinasi') {
                    $destinasi = $item['data'];
                    $konteksUntukAI .= "--- informasi destinasi ---\n";
                    $konteksUntukAI .= "Nama Destinasi: {$destinasi->tujuan}\n";
                    $konteksUntukAI .= "Deskripsi: {$destinasi->long_desk}\n";
                    if ($destinasi->kategori) {
                        $konteksUntukAI .= "Kategori: {$destinasi->kategori->nama_kategori}\n";
                    }
                    if ($destinasi->tiket) {
                        $konteksUntukAI .= "Harga Tiket: Rp " . number_format($destinasi->tiket->Harga, 0, ',', '.') . "\n";
                        $konteksUntukAI .= "Stok Tiket: {$destinasi->tiket->Persediaan} unit\n";
                    }
                    if ($destinasi->acara->isNotEmpty()) {
                        $konteksUntukAI .= "Acara Terkait: " . $destinasi->acara->pluck('Nama_acara')->implode(', ') . "\n";
                    }
                    if ($destinasi->ulasan->isNotEmpty()) {
                        $ulasanSingkat = $destinasi->ulasan->pluck('ulasan')->implode('; ');
                        $konteksUntukAI .= "Ulasan Pengunjung singkat: " . substr($ulasanSingkat, 0, 100) . (strlen($ulasanSingkat) > 100 ? '...' : '') . "\n";
                    }
                    $konteksUntukAI .= "\n";
                } elseif ($item['tipe'] === 'acara') {
                    $acara = $item['data'];
                    $konteksUntukAI .= "--- informasi acara ---\n";
                    $konteksUntukAI .= "Nama Acara: {$acara->Nama_acara}\n";
                    $konteksUntukAI .= "Lokasi: " . ($acara->destination ? $acara->destination->tujuan : 'Tidak diketahui') . "\n"; // cari relasi destinasi
                    $konteksUntukAI .= "Tanggal: " . Carbon::parse($acara->Tanggal_mulai_acara)->format('d F Y') . " - " . Carbon::parse($acara->Tanggal_berakhir_acara)->format('d F Y') . "\n";
                    $konteksUntukAI .= "Deskripsi: {$acara->Deskripsi}\n";
                    $konteksUntukAI .= "\n";
                }
            }
            $apakahPakaiDataInternal = true; // ada data internal yang relevan

        }

        // bantuan AI tanpa konteks
        $pesanUntukAI = [];

        // intuksi untuk AI
        $pesanUntukAI[] = [
            'role' => 'system',
            'content' => 'Anda adalah asisten informasi wisata di Batam, Riau Islands, Indonesia. ' .
                'Jawab pertanyaan pengguna dengan jelas dan ringkas. ' .
                'Prioritaskan informasi dari data internal jika relevan. ' .
                'Jika informasi internal digunakan, sebutkan bahwa jawaban didasarkan pada data internal. ' .
                'Jika tidak ada data internal yang cocok, jawab berdasarkan pengetahuan umum Anda sebagai AI. ' .
                'Sebutkan jika Anda tidak menemukan informasi spesifik di database internal.'
        ];

        if ($apakahPakaiDataInternal) {
            $pesanUntukAI[] = [
                'role' => 'user',
                'content' => $konteksUntukAI . "\n\nPertanyaan" . $pesanPengguna .
                    "\n\nBerdasarkan informasi di atas (jika relevan), jawablah pertanyaan.
                Jika informasinya tidak cukup, sebutkan itu dan berikan jawaban umum."
            ];
        } else {
            $pesanUntukAI[] = [
                'role' => 'user',
                'content' => $pesanPengguna
            ];
        }

        try {
            $responsAI = OpenAI::chat()->create([
                'model' => 'gpt-4.1-mini',
                'messages' => $pesanUntukAI,
                'max_tokens' => 250,
            ]);

            $balasanBot = $responsAI->choices[0]->message->content;

            return response()->json([
                'balasan' => $balasanBot,
                'dari_data_internal' => $apakahPakaiDataInternal
            ]);

        } catch (\Exception $e) {
            \Log::error('Error saat memanggil OpenAI: ' . $e->getMessage());
            return response()->json([
                'balasan' => 'Maaf, Terjadi masalah teknis saat memproses permintaan anda.'
            ], 500);
        }
    }

    // Fungsi untuk mendapatkan rekomendasi destinasi populer
    private function getTopRecommendations()
    {
        // Mengambil destinasi berdasarkan jumlah ulasan dan pembelian tiket terbanyak
        $rekomendasi = Destination::with('kategori')
            ->leftJoin('ulasan', 'destinations.id', '=', 'ulasan.destinations_id')
            ->leftJoin('transaksi', 'destinations.id', '=', 'transaksi.ID_Wisata')
            ->select(
                'destinations.id',
                'destinations.tujuan',
                'destinations.desk',
                'destinations.gambar',
                'destinations.latitude',
                'destinations.longitude',
                'destinations.kategori_id',
                DB::raw('COUNT(ulasan.destinations_id) as ulasan_count'),
                DB::raw('COUNT(transaksi.ID_Wisata) as tiket_count')
            )
            // Menambahkan semua kolom non-agregat ke dalam GROUP BY
            ->groupBy(
                'destinations.id',
                'destinations.tujuan',
                'destinations.desk',
                'destinations.gambar',
                'destinations.latitude',
                'destinations.longitude',
                'destinations.kategori_id'
            )
            ->orderByDesc('ulasan_count')
            ->orderByDesc('tiket_count')
            ->take(6)
            ->get();

        // Jika hasilnya kosong, fallback ke semua destinasi
        if ($rekomendasi->isEmpty()) {
            $rekomendasi = Destination::with('kategori')->take(6)->get();
        }

        return $rekomendasi;
    }

    // Fungsi Pembantu untuk menghitung kemiripan vektor (Cosine Similarity)
    // Diberi nama berbeda agar tidak bentrok dengan hitungKemiripan di bawah
    private function hitungKemiripanVektorKecil($vec1, $vec2)
    {
        $dot = 0;
        $normA = 0;
        $normB = 0;
        foreach ($vec1 as $key => $val) {
            $v2 = $vec2[$key] ?? 0;
            $dot += $val * $v2;
            $normA += $val * $val;
            $normB += $v2 * $v2;
        }
        return ($normA && $normB) ? ($dot / (sqrt($normA) * sqrt($normB))) : 0;
    }

    // fungsi utk bantu cari data internal relevan
    private function cariDataInternalRelevan(string $kataKunciPengguna)
    {
        try {
            // ubah pertanyaan menjadi embedding
            $responEmbeddingQuery = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $kataKunciPengguna,
            ]);
            $vektorPesanPengguna = $responEmbeddingQuery->embeddings[0]->embedding;
        } catch (\Exception $e) {
            \Log::error('Error saat membuat embedding untuk pertanyaan: ' . $e->getMessage());
            return collect();
        }

        $itemRelevan = collect();

        // cari data relevan dari destinasi
        foreach (Destination::whereNotNull('embedding')->cursor() as $destinasi) {
            $vektorData = json_decode($destinasi->embedding, true);
            $tingkatKemiripan = $this->hitungKemiripan($vektorPesanPengguna, $vektorData);

            if ($tingkatKemiripan >= self::AMBANG_BATAS_KEMIRIPAN) {
                $itemRelevan->push([
                    'tipe' => 'destinasi',
                    'skor' => $tingkatKemiripan,
                    'data' => $destinasi->load('kategori', 'acara', 'tiket', 'ulasan'),
                ]);
            }
        }

        // cari data relevan dari acara
        foreach (Acara::whereNotNull('embedding')->cursor() as $acara) {
            $vektorData = json_decode($acara->embedding, true);
            $tingkatKemiripan = $this->hitungKemiripan($vektorPesanPengguna, $vektorData);

            if ($tingkatKemiripan >= self::AMBANG_BATAS_KEMIRIPAN) {
                $itemRelevan->push([
                    'tipe' => 'acara',
                    'skor' => $tingkatKemiripan,
                    'data' => $acara->load('destination'),
                ]);
            }
        }

        // urutkan dan ambil berdasarkan skor kemiripan tertinggi (max 5 item)
        return $itemRelevan->sortByDesc('skor')->take(5);
    }


    // Fungsi Pembantu untuk menghitung kemiripan vektor (Cosine Similarity)
    private function hitungKemiripan(array $vektorA, array $vektorB)
    {
        $produkTitik = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        for ($i = 0; $i < count($vektorA); $i++) {
            $produkTitik += $vektorA[$i] * $vektorB[$i];
            $normA += $vektorA[$i] * $vektorA[$i];
            $normB += $vektorB[$i] * $vektorB[$i];
        }

        $pembagi = sqrt($normA) * sqrt($normB);
        return $pembagi > 0 ? $produkTitik / $pembagi : 0.0;
    }

}
