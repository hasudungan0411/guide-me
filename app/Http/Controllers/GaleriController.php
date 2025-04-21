<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\galeri;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $galery = galeri::all();
        return view('galeri.index', compact('galery'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // ambil dan simpan data 
        $gambar = $request->file('gambar')->hashName();
        $request->file('gambar')->storeAs('images/galeri', $gambar, 'public');

        // simpan data ke database 
        galeri::create([
            'gambar' => $gambar,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Berhasil Menmabahkan Gambar');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // mengambil dan menghapus gambar 
        $galeri = galeri::findOrFail($id);
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Berhasil menghapus gambar');
    }
}
