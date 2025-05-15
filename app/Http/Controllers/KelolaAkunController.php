<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisatawan;
class KelolaAkunController extends Controller
{
    public function wisatawan()
    {
        $data = Wisatawan::all();
        return view('akun_wisatawan.index', compact('data'));
    }

    public function createWisatawan()
    {
        return view('akun_wisatawan.create');
    }

    public function storeWisatawan(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:wisatawan,Email',
            'nomor_hp' => 'required|min:10|max:15',
            'password' => 'required|min:8|confirmed',
        ]);

        Wisatawan::create([
            'Nama' => $request->nama,
            'Email' => $request->email,
            'Nomor_HP' => $request->nomor_hp,
            'Kata_Sandi' => bcrypt($request->password),
            'Foto_Profil' => null,
        ]);

        return redirect()->route('akun_wisatawan.index')->with('success', 'Wisatawan berhasil ditambahkan');
    }

    public function destroyWisatawan($ID_Wisatawan)
    {
        Wisatawan::destroy($ID_Wisatawan);
        return redirect()->route('akun_wisatawan.index')->with('success', 'Wisatawan berhasil dihapus');
    }

}
