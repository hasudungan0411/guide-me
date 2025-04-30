<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KelolaAkunController extends Controller
{
    public function pemilik_wisata()
    {
        return view('akun_pemilik-wisata.index');
    }

    public function wisatawan()
    {
        return view('akun_wisatawan.index');
    }
}
