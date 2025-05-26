<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Galeri;
Use App\Models\Blog;
Use App\Models\Acara;
Use App\Models\Tiket;

class DestinasiController extends Controller
{
    public function destinasi(Request $request)
    {
        // Ambil destinasi dengan paginasi
        $destinations = Destination::paginate(9);

        // Ambil semua galeri
        $galleries = Galeri::all();

        return view('wisatawan.destinasi', compact('destinations', 'galleries'));
    }

    public function detail_destinasi($id)
    {
        // data wisatawan
        $wisatawan = Auth::guard('wisatawan')->user();

        // Ambil detail destinasi
        $destination = Destination::findOrFail($id);


        // data tiket
        $tiket = Tiket::where('ID_Wisata', $destination->id)->first();

        // Ambil semua galeri
        $galleries = Galeri::all();

        // Ambil semua blog terbaru
        $blogs = Blog::orderBy('id_blog', 'desc')->limit(3)->get();

        // Ambil acara yang terkait dengan destinasi ini
        $acara = Acara::where('ID_Wisata', $destination->id)->get();

        $user = Auth::guard('wisatawan')->user();


        // Buat array isi gambar-gambar yang tersedia
        $galleryImages = collect([
            $destination->gambar,
            $destination->gambar2,
            $destination->gambar3,
            $destination->gambar4,
            $destination->gambar5,
        ])->filter(); // filter buat buang yang null

        return view('wisatawan.detail_destinasi', compact('destination', 'galleryImages', 'blogs', 'galleries', 'acara', 'tiket'));
    }
}
