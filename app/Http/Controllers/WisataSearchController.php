<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\Blog;
use App\Models\Kategori;

class WisataSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');

        // Ambil destinasi
        $destinasi = Destination::when($query, function ($qBuilder) use ($query) {
            $qBuilder->where('tujuan', 'like', '%' . $query . '%');
        })->inRandomOrder()->limit(10)->get(['id', 'tujuan'])->map(function ($item) {
            return [
                'tipe' => 'destinasi',
                'nama' => $item->tujuan,
                'id' => $item->id, // Ambil id-nya
            ];
        });

        // Ambil blog
        $blog = Blog::when($query, function ($qBuilder) use ($query) {
            $qBuilder->where('judul', 'like', '%' . $query . '%');
        })->inRandomOrder()->limit(10)->get(['judul', 'slug'])->map(function ($item) {
            return [
                'tipe' => 'blog',
                'nama' => $item->judul,
                'slug' => $item->slug, // Ambil slug dari blog
            ];
        });

        // Ambil kategori
        $kategori = Kategori::when($query, function ($qBuilder) use ($query) {
            $qBuilder->where('nama_kategori', 'like', '%' . $query . '%');
        })->inRandomOrder()->limit(10)->get([ 'id_kategori', 'nama_kategori'])->map(function ($item) {
            return [
                'tipe' => 'kategori',
                'nama' => $item->nama_kategori,
                'id_kategori' => $item->id_kategori, // ambil id kategori-nya
            ];
        });

        // Gabungkan semua hasil
        $results = $destinasi->merge($blog)->merge($kategori);

        return response()->json($results);
    }
}
