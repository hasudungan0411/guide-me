<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\Transaksi;
use App\Models\Wisatawan;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder\Function_;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function generateInvoicePDF($id)
    {
        $pesanan = Transaksi::with('wisatawan')->findOrFail($id);

        $pdf = Pdf::loadView('wisatawan.invoice', compact('pesanan'));

        return $pdf->download('Invoice_'.$pesanan->ID_Tiket.'_Guide-Me.pdf');
    }

    public function adminIndex() 
    {
        $transaksi = Transaksi::all();
        $totalTransaksi = Transaksi::count();
        $totalWisatawan = Wisatawan::count();
        $totalPemilik = Pemilikwisata::count();

        foreach ($transaksi as $item) {
            if (
                in_array($item->Status, ['Unpaid', 'Paid']) &&
                Carbon::parse($item->Tanggal_Transaksi)->addDays(2)->isPast()
            ) {
                $item->Status = 'Hangus';
                $item->save();
            }
        }

        return view('admin.data-transaksi', compact('transaksi','totalTransaksi','totalWisatawan','totalPemilik'));
    }
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

    public function updateRekening(Request $request)
    {
        $request->validate([
            'nomor_rekening' => 'required|string|max:255',
            'gambar_qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pemilik = Auth::guard("pemilikwisata")->user();

        if (!$pemilik) {
            return redirect()->back()->withErrors('Pemilik tidak ditemukan.');
        }

        $pemilik->nomor_rekening = $request->nomor_rekening;

        if ($request->hasFile('gambar_qris')) {

            if ($pemilik->Qris) {
                $filePath = public_path('gambar_qris/' . $pemilik->Qris);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $file = $request->file('gambar_qris');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('gambar_qris'), $filename);
            
            $file = $filename;
            $pemilik->Qris = $file;
        }

        $pemilik->save();

        return redirect()->back()->with('success', 'Nomor rekening dan QRIS berhasil diperbarui.');
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
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $wisatawan = Auth::guard('wisatawan')->user();

        $tiket = Tiket::where('ID_Wisata', $request->ID_Wisata)->first();

        if ($tiket->Persediaan < $request->Jumlah_Tiket) {
            return redirect()->back()->with('error', 'Tiket tidak cukup.');
        }

        $kodeInvoice = 'INV-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(5));

        $totalHarga = $request->Jumlah_Tiket * $request->Harga_Satuan;

        $file = $request->file('bukti_transaksi');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('bukti'), $filename);

        $pesanan = new Transaksi();
        $pesanan->ID_Tiket = $kodeInvoice;
        $pesanan->ID_Wisata = $request->ID_Wisata;
        $pesanan->ID_Wisatawan = $wisatawan->ID_Wisatawan;
        $pesanan->Jumlah_Tiket = $request->Jumlah_Tiket;
        $pesanan->total_harga = $totalHarga;
        $pesanan->Status = 'Pending';
        $pesanan->Tanggal_Transaksi = now();
        $pesanan->Bukti_Transaksi = $filename;
        $pesanan->save();


        $tiket->Persediaan -= $request->Jumlah_Tiket;
        $tiket->save();

        return redirect()->route('wisatawan.pesanan')->with('success', 'Pemesanan berhasil dengan kode: ' . $kodeInvoice);
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
        $pemilik = $destinasi->pemilikwisata;

        return view('wisatawan.detail_tiket', compact('tiket', 'destinasi', 'pemilik'));
    }

    public function uploadbukti(Request $request, $id)
    {
        $request->validate([
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        $file = $request->file('bukti_transaksi');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('bukti'), $filename);

        $transaksi->Bukti_Transaksi = $filename;
        $transaksi->save();

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    public function showKonfirmasi(Request $request)
    {
        $wisatawan = Auth::guard('wisatawan')->user();
        if (!$wisatawan) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = [
            'ID_Wisata' => $request->input('ID_Wisata'),
            'Harga_Satuan' => $request->input('Harga_Satuan'),
            'Jumlah_Tiket' => $request->input('Jumlah_Tiket'),
            'Total_Harga' => $request->input('Jumlah_Tiket') * $request->input('Harga_Satuan')
        ];

        $destinasi = Destination::find($data['ID_Wisata']);
        $pemilik = $destinasi->pemilikwisata;

        if (!$destinasi) {
            return redirect()->route('home')->with('error', 'Destinasi tidak ditemukan.');
        }

        return view('wisatawan.konfirmasi_pesanan', compact('data', 'wisatawan', 'destinasi', 'pemilik'));
    }

    public function batalPesanan()
    {
        Session::forget('data_pesanan'); 

        return redirect()->route('wisatawan.pesanan')->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function konfirmasitiket($id)
    {
        $pesanan = Transaksi::find($id);

        if (!$pesanan) {
            Alert::error('Error', 'Pesanan tidak ditemukan.');
            return redirect()->back();
        }

        if (in_array($pesanan->Status, ['Batal', 'Hangus'])) {
            Alert::error('Error', 'Pesanan ini tidak dapat dikonfirmasi.');
            return redirect()->back();
        }

        if ($pesanan->Status === 'Paid') {
            Alert::error('Error', 'Pesanan ini sudah dikonfirmasi.');
            return redirect()->back();
        }

        if (!$pesanan->Bukti_Transaksi) {
            Alert::error('Error', 'Bukti pembayaran belum diunggah.');
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
