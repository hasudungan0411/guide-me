<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Blog;
use App\Models\galeri;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua destinasi untuk slider
        $destinations = Destination::all();

        // Ambil 3 destinasi terpopuler berdasarkan click_count
        $popularDestinations = Destination::orderBy('click_count', 'desc')->limit(3)->get();

        // ambil blog nya 
        $blogs = Blog::orderBy('id_blog', 'desc')->limit(3)->get();

        // ambil galerinya 
        $galery = Galeri::all();

        return view('wisatawan.home', compact('destinations', 'popularDestinations', 'blogs', 'galery'));
    }
}
