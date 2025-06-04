<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AcaraController extends Controller
{
    // Menampilkan semua acara milik pemilik wisata yang login
    public function index()
    {
        // Ambil pemilik destinasi yang login
        $pemilik = Auth::guard('pemilikwisata')->user();

        // Ambil destinasi yang dimiliki oleh pemilik
        $destinasi = $pemilik->destination;

        // Pastikan hanya acara dari destinasi miliknya yang diambil
        $Acara = $destinasi ? $destinasi->acara()->orderBy('Tanggal_mulai_acara')->get() : [];

        return view('pemilik.acara.index', compact('Acara', 'destinasi'));
    }


    // Menampilkan form tambah acara
    public function create()
    {
        return view('pemilik.acara.create');
    }

    // Menyimpan acara baru
    public function store(Request $request)
    {
        $request->validate([
            'Nama_acara' => 'required|string|max:255',
            'Tanggal_mulai_acara' => 'required|date',
            'Tanggal_berakhir_acara' => 'required|date',
            'Deskripsi' => 'required|string',
        ]);

        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        if (!$destinasi) {
            return redirect()->back()->with('error', 'Destinasi tidak ditemukan.');
        }

        Acara::create([
            'ID_Wisata' => $destinasi->id,
            'Nama_acara' => $request->Nama_acara,
            'Tanggal_mulai_acara' => $request->Tanggal_mulai_acara,
            'Tanggal_berakhir_acara' => $request->Tanggal_berakhir_acara,
            'Deskripsi' => $request->Deskripsi,
        ]);

        Alert::success('Success','Acara berhasil ditambahkan');
        return redirect()->route('pemilik.acara.index');
    }

    // Menampilkan form edit acara
    public function edit($ID_Acara)
    {
        $Acara = Acara::findOrFail($ID_Acara);
        return view('pemilik.acara.edit', compact('Acara'));
    }

    // Menyimpan perubahan acara
    public function update(Request $request, $ID_Acara)
    {
        $request->validate([
            'Nama_acara' => 'required|string|max:255',
            'Tanggal_mulai_acara' => 'required|date',
            'Tanggal_berakhir_acara' => 'required|date',
            'Deskripsi' => 'required|string',
        ]);

        $acara = Acara::findOrFail($ID_Acara);

        $acara->update([
            'Nama_acara' => $request->Nama_acara,
            'Tanggal_mulai_acara' => $request->Tanggal_mulai_acara,
            'Tanggal_berakhir_acara' => $request->Tanggal_berakhir_acara,
            'Deskripsi' => $request->Deskripsi,
        ]);

        Alert::success('Success','Acara berhasil diubah');
        return redirect()->route('pemilik.acara.index');
    }

    // Menghapus acara
    public function destroy($ID_Acara)
    {
        $acara = Acara::findOrFail($ID_Acara);
        $acara->delete();

        Alert::success('Success','Acara berhasil dihapus');
        return redirect()->route('pemilik.acara.index');
    }
}
