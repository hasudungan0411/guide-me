<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Carbon\Carbon;

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

        foreach ($transaksi as $item) {
        if (
            in_array($item->Status, ['Unpaid', 'Paid']) &&
            Carbon::parse($item->Tanggal_Transaksi)->addDays(2)->isPast()
        ) {
            $item->Status = 'Hangus';
            $item->save();
        }
        }

        return view('pemilik.transaksi', compact('transaksi', 'destinasi'));
    }

    public function showpesananwisatawan()
    {
        $wisatawan = Auth::guard('wisatawan')->user();

        $transaksi = Transaksi::with('destinasi')
            ->where('ID_Wisatawan', $wisatawan->ID_Wisatawan)
            ->get();

        return view('wisatawan.pesanan', compact('transaksi', 'wisatawan'));
    }

    public function pesan(Request $request)
    {
        $request->validate([
        'ID_Wisata' => 'required|exists:destinations,id',
        'Jumlah_Tiket' => 'required|integer|min:1',
        'Harga_Satuan' => 'required|numeric|min:0',
    ]);

    $wisatawan = Auth::guard('wisatawan')->user();

    $tiket = Tiket::where('ID_Wisata', $request->ID_Wisata)->first();

    if ($tiket->Persediaan < $request->Jumlah_Tiket) {
        return redirect()->back()->with('error', 'Tiket tidak cukup.');
    }

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


    $tiket->Persediaan -= $request->Jumlah_Tiket;
    $tiket->save();

    return redirect()->back()->with('success', 'Pemesanan berhasil dengan kode: ' . $kodeInvoice);
    }

    public function showdetailtiket($id)
    {
        $wisatawan = Auth::guard('wisatawan')->user();

        $tiket = Transaksi::where('ID_Transaksi', $id)
                    ->where('ID_Wisatawan', $wisatawan->ID_Wisatawan)
                    ->first();

        if (!$tiket) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        $destinasi = $tiket->destinasi;

        return view('wisatawan.detail_tiket', compact('tiket', 'destinasi'));
    }

        public function uploadbukti(Request $request, $id)
    {
        // Validasi file
        $request->validate([
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cari transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);

        // Ambil file yang di-upload
        $file = $request->file('bukti_transaksi');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Pindahkan file ke folder 'bukti' di public
        $file->move(public_path('bukti'), $filename);

        // Simpan nama file ke dalam database
        $transaksi->Bukti_Transaksi = $filename;
        $transaksi->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function konfirmasitiket($id)
    {
        $pesanan = Transaksi::find($id);

        if (!$pesanan) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if ($pesanan->Status === 'Batal' && $pesanan->Status === 'Hangus') {
            Alert::error('Error', 'Pesanan ini tidak dapat dikonfirmasi.');
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

        if ($pesanan->Status === 'Batal' && $pesanan->Status === 'Hangus') {
            Alert::error('Error', 'Pesanan ini tidak dapat digunakan.');
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

        if ($pesanan->Status === 'Hangus') {
            if (!Carbon::parse($pesanan->Tanggal_Transaksi)->addDays(3)->isPast()) {
                Alert::error('Error', 'Pesanan ini belum dapat dihapus.');
                return redirect()->back();
            }
        }   

        $pesanan->delete();
        Alert::success('Sukses', 'Tiket berhasil dihapus.');
        return redirect()->back();
    } 
}
