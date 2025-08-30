<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'Gambar_acara' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Tanggal_mulai_acara' => 'required|date',
            'Tanggal_berakhir_acara' => 'required|date',
            'Deskripsi' => 'required|string',
        ]);

        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        if (!$destinasi) {
            return redirect()->back()->with('error', 'Destinasi tidak ditemukan.');
        }

        $namaAcara = Str::slug($request->Nama_acara); 
        $ext = $request->file('Gambar_acara')->getClientOriginalExtension();
        $filename = $namaAcara . '_gambar.' . $ext;

        $request->file('Gambar_acara')->storeAs('images/event', $filename, 'public');

        Acara::create([
            'ID_Wisata' => $destinasi->id,
            'Nama_acara' => $request->Nama_acara,
            'Gambar_acara' => $filename, 
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
            'Gambar_acara' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Tanggal_mulai_acara' => 'required|date',
            'Tanggal_berakhir_acara' => 'required|date|after_or_equal:Tanggal_mulai_acara',
            'Deskripsi' => 'required|string',
        ]);

        $acara = Acara::findOrFail($ID_Acara);

        $data = [
            'Nama_acara' => $request->Nama_acara,
            'Tanggal_mulai_acara' => $request->Tanggal_mulai_acara,
            'Tanggal_berakhir_acara' => $request->Tanggal_berakhir_acara,
            'Deskripsi' => $request->Deskripsi,
        ];

        if ($request->hasFile('Gambar_acara')) {
            // Hapus gambar lama
            if ($acara->Gambar_acara && Storage::disk('public')->exists('images/event/' . $acara->Gambar_acara)) {
                Storage::disk('public')->delete('images/event/' . $acara->Gambar_acara);
            }

            $namaAcara = Str::slug($request->Nama_acara);
            $ext = $request->file('Gambar_acara')->getClientOriginalExtension();
            $filename = $namaAcara . '_gambar.' . $ext;

            $request->file('Gambar_acara')->storeAs('images/event', $filename, 'public');

            $data['Gambar_acara'] = $filename;
        }

        $acara->update($data);

        Alert::success('Success', 'Acara berhasil diubah');
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
