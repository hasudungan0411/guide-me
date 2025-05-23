<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Kategori;
use App\Models\Galeri;
use App\Models\Destination;

class KategoriController extends Controller
{
    public function kategori($id)
    {
        $category = Kategori::findOrFail($id);
        $blogs = Blog::where('id_kategori', $id)->paginate(5);

        // Untuk sidebar: ambil hanya kategori yang dipakai di blog
        $categories = Kategori::whereIn('id_kategori', Blog::pluck('id_kategori'))->get();

        $galleries = Galeri::all();

        return view('wisatawan.blog-kategori', compact('category', 'blogs', 'categories', 'galleries'));
    }

    public function destinasi()
    {
        $categories = Kategori::all();
        $gallery = Galeri::all();
        return view('wisatawan.kategori-destinasi', compact('categories', 'gallery'));
    }

    public function destinasiByKategori($id_kategori)
    {
        $category = Kategori::findOrFail($id_kategori);
        $gallery = Galeri::all();
        $destinations = Destination::where('kategori_id', $id_kategori)->get();

        return view('wisatawan.destinasi-by-kategori', compact('category', 'destinations' ,'gallery'));
    }

    public function blog()
    {
        return view('wisatawan.kategori-blog');
    }
}
