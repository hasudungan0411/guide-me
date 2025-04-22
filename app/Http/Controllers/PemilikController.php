<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;
use App\Models\Acara;
use App\Models\pemilikwisata;

class PemilikController extends Controller
{
    public function showlogin()
    {
        return view('pemilik.login');
    } 


    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'requied'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/Pemilik');
    }
    
    public function index()
    {
        return view('pemilik.index');
    }

    public function showtempatwisata($id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return redirect()->route('pemilik.index')->with('error', 'Halaman tidak ditemukan!');
        }

        return view('pemilik.tempatwisata', compact('destination'));
    }

    public function showacarapemilik($id)
    {
        $Destinasi = Destination::with('acara')->where('id', $id)->first();

        if (!$Destinasi) {
            return redirect()->route('pemilik.index')->with('error', 'Wisata tidak ditemukan!');
        }

        $Acara = $Destinasi->acara;

        return view('pemilik.acara', compact('Acara'));
    }

    public function showtiketpemilik($id)
    {
        return view('pemilik.tiket');
    }

    public function showtransaksipemilik($id)
    {
        return view('pemilik.transaksi');
    }
}
