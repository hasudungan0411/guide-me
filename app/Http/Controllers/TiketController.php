<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class TiketController extends Controller
{
    public function index()
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        $tiket = $destinasi ? $destinasi->tiket()->firstOrFail() : abort(404);

        return view('pemilik.tiket', compact('tiket', 'destinasi'));
    }

    public function update(Request $request)
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        $tiket = $destinasi ? $destinasi->tiket()->firstOrFail() : abort(404);

        $request->validate([
            'Persediaan' => 'required|integer|min:1',
            'Harga' => 'required|numeric|min:0',
        ]);

        $tiket->update([
            'Persediaan' => $request->Persediaan,
            'Harga' => $request->Harga,
        ]);

        return redirect()->route('pemilik.tiket')->with('success', 'Tiket berhasil diperbarui');
    }

    public function pesan(Request $request)
    {
        $request->validate([
        'ID_Wisata' => 'required|exists:destinations,id',
        'Jumlah_Tiket' => 'required|integer|min:1',
        'Harga_Satuan' => 'required|numeric|min:0',
    ]);

    $wisatawan = Auth::guard('wisatawan')->user();

    $kodeInvoice = 'INV-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(5));

    $totalHarga = $request->Jumlah_Tiket * $request->Harga_Satuan;

    $pesanan = new Transaksi();
    $pesanan->ID_Tiket = $kodeInvoice;
    $pesanan->ID_Wisata = $request->ID_Wisata;
    $pesanan->ID_Wisatawan = $wisatawan->ID_Wisatawan;
    $pesanan->Jumlah_Tiket = $request->Jumlah_Tiket;
    $pesanan->total_harga = $totalHarga;
    $pesanan->Status = 'Unpaid';
    $pesanan->Tanggal_Transaksi = now();
    $pesanan->save();

    return redirect()->back()->with('success', 'Pemesanan berhasil dengan kode: ' . $kodeInvoice);
    }
}
