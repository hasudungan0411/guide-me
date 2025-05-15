<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PemilikController extends Controller
{

    public function index()
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        return view('pemilik.index', compact('pemilik', 'destinasi'));
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
