<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategori;
use Illuminate\Support\Facades\File;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = kategori::all();
        return view('kategori.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource..
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // ambil dan simpan gambar nya 
        $gambar = $request->file('gambar')->hashName();
        $request->file('gambar')->storeAs('images/kategori', $gambar, 'public');

        // simpan ke database 
        kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'gambar' => $gambar
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // update data 
        $kategori->nama_kategori = $request->nama_kategori;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->storeAs('images/kategori', $gambar, 'public');
            $kategori->gambar = $gambar;
        }

        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // mencari kategori berdasarkan ID 
        $kategori = kategori::findOrFail($id);

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
