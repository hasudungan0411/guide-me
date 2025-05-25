<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function showtransaksipemilik()
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        if (!$destinasi) {
            abort(404, 'Destinasi tidak ditemukan');
        }

        $transaksi = Transaksi::where('ID_Wisata', $destinasi->id)->get();

        return view('pemilik.transaksi', compact('transaksi', 'destinasi'));
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
    $pesanan->Bukti_Transaksi = null;
    $pesanan->save();

    return redirect()->back()->with('success', 'Pemesanan berhasil dengan kode: ' . $kodeInvoice);
    }

    public function konfirmasitiket($id)
    {
        $pesanan = Transaksi::find($id);

        if (!$pesanan) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if ($pesanan->Status === 'Paid') {
            Alert::error('Error', 'Pesanan ini sudah dikonfirmasi.');
            return redirect()->back();
        }

        $pesanan->Status = 'Paid';
        $pesanan->save();

        Alert::success('Sukses', 'Tiket berhasil dikonfirmasi.');
        return redirect()->back();
    }

    public function gunakantiket($id)
    {
        $pesanan = Transaksi::find($id);

        if (!$pesanan) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if ($pesanan->Status !== 'Paid') {
            Alert::error('Error', 'Pesanan ini belum dikonfirmasi.');
            return redirect()->back();
        }

        $pesanan->Status = 'Sudah Digunakan';
        $pesanan->save();

        Alert::success('Sukses', 'Tiket berhasil digunakan.');
        return redirect()->back();
    } 

    public function hapustiket($id)
    {
        $pesanan = Transaksi::find($id);

        if (!$pesanan) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if ($pesanan->Status !== 'Batal' && $pesanan->Status !== 'Hangus') {
            Alert::error('Error', 'Pesanan ini tidak dapat dihapus.');
            return redirect()->back();
        }

        $pesanan->delete();
        Alert::success('Sukses', 'Tiket berhasil dihapus.');
        return redirect()->back();
    } 
}
