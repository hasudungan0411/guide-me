<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;
use App\Models\Acara;
use App\Models\pemilikwisata;

class AcaraController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal_acara' => 'required|date_format:d-m-Y',
            'nama_acara' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        // simpan ke database
        Destination::create([
            'Tanggal_acara' => $validatedData['tanggal_acara'],
            'Nama_acara' => $validatedData['nama_acara'],
            'Deskripsi' => $validatedData['deskripsi'],
        ]);

        return redirect()->route('pemilik.acara')->with('Success', 'Acara berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tanggal_acara' => 'required|date_format:d-m-Y',
            'nama_acara' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        // mencari berdasarkan ID
        $acara = Acara::findOrFail($id);

        // Update data
        $acara->Tanggal_acara = $validatedData['tanggal_acara'];
        $acara->Nama_acara = $validatedData['nama_acara'];
        $acara->Deskripsi = $validatedData['deskripsi'];

        $acara->save();

        return redirect()->route('pemilik.acara')->with('Success', 'Acara Berhasil diUpdate');
    }

    public function destroy(string $id)
    {
        // mencari menggunakan ID
        $acara = Acara::findOrFail($id);

        // Hapus dari database
        $acara->delete();

        return redirect()->route('pemilik.acara')->with('Success', 'Acara Berhasil Dihapus');
    }

}
