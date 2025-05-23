<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Destination;
use App\Models\galeri;

class AcaraController extends Controller
{
    // Menampilkan acara berdasarkan destinasi
    public function acara()
    {
        // Ambil destinasi yang memiliki minimal satu acara
        $destinations = Destination::whereHas('acara')->with('acara')->paginate(6);

        $galleries = Galeri::all();

        return view('wisatawan.acara', compact('destinations', 'galleries'));
    }

    // Menampilkan detail acara
    public function show($ID_Acara)
    {
        $acara = Acara::findOrFail($ID_Acara); // Menampilkan acara berdasarkan ID

        return view('wisatawan.acara_detail', compact('acara'));
    }
}
