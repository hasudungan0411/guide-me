<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Destination;
use App\Models\Acara;
use OpenAI\Laravel\Facades\OpenAI;
use Carbon\Carbon;

class BuatRingkasanDataInternal extends Command
{
    protected $signature = 'data:ringkas-internal';
    protected $description = 'Membuat ringkasan (embedding) dari data destinasi dan acara untuk chatbot.';

    public function handle()
    {
        $this->info('Mulai membuat ringkasan untuk Destinasi...');
        foreach (Destination::with('kategori', 'ulasan', 'acara', 'tiket')->cursor() as $destinasi) {
            $teksUntukRingkasan = $this->siapkanTeksDestinasi($destinasi);
            $this->buatDanSimpanRingkasan($destinasi, $teksUntukRingkasan);
            $this->info("Ringkasan Destinasi: {$destinasi->tujuan} selesai.");
        }

        $this->info('Mulai membuat ringkasan untuk Acara...');
        foreach (Acara::with('destination')->cursor() as $acara) {
            $teksUntukRingkasan = $this->siapkanTeksAcara($acara);
            $this->buatDanSimpanRingkasan($acara, $teksUntukRingkasan);
            $this->info("Ringkasan Acara: {$acara->Nama_acara} selesai.");
        }

        $this->info('Proses pembuatan ringkasan data internal selesai!');
        return Command::SUCCESS;
    }

    // Fungsi untuk menggabungkan teks dari model Destinasi
    private function siapkanTeksDestinasi(Destination $destinasi): string
    {
        $teks = "Destinasi wisata: {$destinasi->tujuan}. ";
        if ($destinasi->kategori) {
            $teks .= "Kategori: {$destinasi->kategori->nama_kategori}. ";
        }
        $teks .= "Deskripsi singkat: {$destinasi->desk}. Deskripsi lengkap: {$destinasi->long_desk}. ";

        $ulasanPopuler = $destinasi->ulasan->sortByDesc('rating')->take(3); // Ambil 3 ulasan terbaik
        if ($ulasanPopuler->isNotEmpty()) {
            $teks .= "Beberapa ulasan pengunjung: " . $ulasanPopuler->pluck('ulasan')->implode('; ') . ". ";
        }

        if ($destinasi->tiket) {
            $teks .= "Harga tiket: Rp " . number_format($destinasi->tiket->Harga, 0, ',', '.') . ". ";
            $teks .= "Ketersediaan tiket: {$destinasi->tiket->Persediaan} unit. ";
        }

        if ($destinasi->acara->isNotEmpty()) {
            $teks .= "Acara yang terkait: " . $destinasi->acara->pluck('Nama_acara')->implode(', ') . ". ";
        }

        return $teks;
    }

    // Fungsi untuk menggabungkan teks dari model Acara
    private function siapkanTeksAcara(Acara $acara): string
    {
        $teks = "Acara: {$acara->Nama_acara}. ";
        if ($acara->destination) {
            $teks .= "Lokasi acara di destinasi: {$acara->destination->tujuan}. ";
        }
        $tanggalMulai = Carbon::parse($acara->Tanggal_mulai_acara)->format('d F Y');
        $tanggalBerakhir = Carbon::parse($acara->Tanggal_berakhir_acara)->format('d F Y');
        $teks .= "Tanggal acara dari {$tanggalMulai} sampai {$tanggalBerakhir}. ";
        $teks .= "Deskripsi acara: {$acara->Deskripsi}.";

        return $teks;
    }

    // Fungsi untuk memanggil OpenAI dan menyimpan ringkasan
    private function buatDanSimpanRingkasan(\Illuminate\Database\Eloquent\Model $model, string $teks)
    {
        try {
            $response = OpenAI::embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $teks,
            ]);
            $model->embedding = json_encode($response->embeddings[0]->embedding);
            $model->save();
        } catch (\Exception $e) {
            $this->error("Gagal membuat ringkasan untuk {$model->getTable()} ID {$model->getKey()}: " . $e->getMessage());
        }
    }
}
