<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\galeri;

class GaleriController extends Controller
{
    public function galeri()
    {
        $galleries = Galeri::all();
        return view('wisatawan.galeri', compact('galleries'));
    }
}
