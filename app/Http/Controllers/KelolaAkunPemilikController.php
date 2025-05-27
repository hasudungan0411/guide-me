<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilikwisata;
use App\Models\Destination;
use App\Models\Tiket;
use RealRashid\SweetAlert\Facades\Alert;

class KelolaAkunPemilikController extends Controller
{
    public function pemilik_wisata()
    {
        $data = Pemilikwisata::all();
        return view('akun_pemilik-wisata.index', compact('data'));
    }

    public function create()
    {
        // Ambil nama wisata (tujuan) yang belum memiliki pemilik
        $destinations = Destination::whereNotIn('tujuan', function ($query) {
            $query->select('Nama_Wisata')->from('pemilik_wisata');
        })
        ->orderBy('tujuan', 'asc')
        ->pluck('tujuan');

        return view('akun_pemilik-wisata.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:pemilik_wisata,Email',
            'nomor_hp' => 'required|min:10|max:15',
            'nama_wisata' => 'required|exists:destinations,tujuan',
            'lokasi' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        // Proteksi tambahan: cek apakah wisata sudah punya pemilik
        $sudahAda = Pemilikwisata::where('Nama_Wisata', $request->nama_wisata)->exists();
        if ($sudahAda) {
            return back()->withErrors(['nama_wisata' => 'Wisata ini sudah memiliki pemilik.'])->withInput();
        }

        $pemilik = Pemilikwisata::create([
            'Email' => $request->email,
            'Nomor_HP' => $request->nomor_hp,
            'Nama_Wisata' => $request->nama_wisata,
            'Lokasi' => $request->lokasi,
            'Kata_Sandi' => bcrypt($request->password),
        ]);

        $destinasi = Destination::where('tujuan', $request->nama_wisata)->first();

        if ($destinasi) {
            $tiket = Tiket::where('ID_Wisata', $destinasi->id)->first();
            if ($tiket) {
                $tiket->ID_Pemilik = $pemilik->ID_Pemilik_Wisata;
                $tiket->save();
            }
        }

        alert::success('Success','Akun Pemilik berhasil ditambahkan');
        return redirect()->route('akun_pemilik-wisata.index');
    }

    public function destroy($ID_Pemilik_Wisata)
    {
        Pemilikwisata::destroy($ID_Pemilik_Wisata);
        alert::success('Success','Akun pemilik berhasil dihapus');
        return redirect()->route('akun_pemilik-wisata.index');
    }
}
