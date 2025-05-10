<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;
use App\Models\Acara;
use App\Models\pemilikwisata;
use App\Mail\Websitemail;

class PemilikController extends Controller
{
    // public function login()
    // {
    //     return view('pemilik.login');
    // }

    // public function login_submit(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:8',
    //     ]);

    //     $check = $request->all();
    //     $data = [
    //         'email' => $check['email'],
    //         'password' => $check['password']
    //     ];
    //     if(Auth::guard('pemilik_wisata')->attempt($data)) {
    //         return redirect()->route('pemilik.index')->with('success', 'Login Successfull');
    //     } else {
    //         return redirect()->route('pemilik.login')->with('error', 'Data Salah');
    //     }

    //     // return redirect()->route('pemilik.login')->with('error','Akun Salah');
    // }

    public function logout()
    {
        Auth::guard('pemilikwisata')->logout();
        return redirect()->route('pemilik.login')->with('success','Logout berhasil');
    }
  
    public function index()
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;
    
        return view('pemilik.index', compact('pemilik', 'destinasi'));
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
        $pemilik = Auth::guard('pemilikwisata')->user();
        $Destinasi = $pemilik->destination;
        
        if (!$Destinasi) {
            return redirect()->route('pemilik.index')->with('error', 'Destinasi tidak ditemukan!');
        }

        $Acara = $Destinasi->acara;

        return view('pemilik.acara', compact('Acara', 'Destinasi'));
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
