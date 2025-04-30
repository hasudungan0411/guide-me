<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Kategori;
use App\Models\Galeri;

class BlogController extends Controller
{
    public function blog()
    {
        // Ambil blog dengan paginasi
        $blogs = Blog::orderBy('tanggal', 'desc')->paginate(5);

        $categories = Kategori::whereIn('id_kategori', Blog::pluck('kategori_id'))->get();

        // Determine the current page
        $halaman = $blogs->currentPage();
        $previous = $halaman - 1;
        $next = $halaman + 1;
        $total_halaman = $blogs->lastPage();

        $galleries = Galeri::all();

        // Pass pagination data to the view
        return view('wisatawan.blog', compact('blogs', 'halaman', 'previous', 'next', 'total_halaman', 'categories', 'galleries'));
    }

    public function blogdetail($slug)
    {
        $blog = Blog::with('kategori')->where('slug', $slug)->firstOrFail();  // Mengambil blog berdasarkan slug
        $categories = Kategori::whereIn('id_kategori', Blog::pluck('kategori_id'))->get();
        $recentPosts = Blog::orderBy('tanggal', 'desc')->limit(3)->get();  // Mengambil 3 artikel terbaru

        $galleries = Galeri::all();

        return view('wisatawan.blog-detail', compact('blog', 'categories', 'recentPosts', 'galleries'));
    }

    public function blogKategori($id_kategori)
    {
        // Ambil kategori berdasarkan id_kategori
        $category = Kategori::findOrFail($id_kategori);

        // Ambil blog berdasarkan kategori
        $blogs = Blog::where('kategori_id', $id_kategori)->orderBy('tanggal', 'desc')->paginate(5);

        // Ambil galeri untuk sidebar
        $galleries = Galeri::all();

        $categories = Kategori::whereIn('id_kategori', Blog::pluck('kategori_id'))->get();

        // Ambil blog terbaru untuk sidebar
        $recentBlogs = Blog::inRandomOrder()->limit(3)->get();

        // Pass data ke view
        return view('wisatawan.blog-kategori', compact('blogs', 'category', 'categories', 'galleries', 'recentBlogs'));
    }
}
