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
        $Acara = $destinasi ? $destinasi->acara()->orderBy('Tanggal_acara')->get() : [];

        return view('pemilik.acara', compact('Acara', 'destinasi'));
    }


    // Menampilkan form tambah acara
    public function create()
    {
        return view('acara.create');
    }

    // Menyimpan acara baru
    public function store(Request $request)
    {
        $request->validate([
            'Nama_acara' => 'required|string|max:255',
            'Tanggal_acara' => 'required|date',
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
            'Tanggal_acara' => $request->Tanggal_acara,
            'Deskripsi' => $request->Deskripsi,
        ]);

        Alert::success('Success','Acara berhasil ditambahkan');
        return redirect()->route('pemilik.acara');
    }

    // Menampilkan form edit acara
    public function edit($id)
    {
        $acara = Acara::findOrFail($id);
        return view('acara.edit', compact('acara'));
    }

    // Menyimpan perubahan acara
    public function update(Request $request, $id)
    {
        $request->validate([
            'Nama_acara' => 'required|string|max:255',
            'Tanggal_acara' => 'required|date',
            'Deskripsi' => 'required|string',
        ]);

        $acara = Acara::findOrFail($id);

        $acara->update([
            'Nama_acara' => $request->Nama_acara,
            'Tanggal_acara' => $request->Tanggal_acara,
            'Deskripsi' => $request->Deskripsi,
        ]);

        Alert::success('Success','Acara berhasil diubah');
        return redirect()->route('pemilik.acara');
    }

    // Menghapus acara
    public function destroy($id)
    {
        $acara = Acara::findOrFail($id);
        $acara->delete();

        Alert::success('Success','Acara berhasil dihapus');
        return redirect()->route('pemilik.acara');
    }
}
