<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Destination;
Use App\Models\kategori;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua destinasi dari database
        $destinations = Destination::all();

        // Kirim data destinasi ke view
        return view('destinasi.index', compact('destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = kategori::all();
        return view('destinasi.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tujuan' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id_kategori', 
            'desk' => 'nullable|string',
            'long_desk' => 'nullable|string',
            'gambar' => 'required|image',
            'gambar2' => 'nullable|image',
            'gambar3' => 'nullable|image',
            'gambar4' => 'nullable|image',
            'gambar5' => 'nullable|image',
            'gambarM' => 'nullable|image',
        ]);

        // proses upload gambar
        $gambarPath = $request->file('gambar')->store('images/destinasi', 'public');
        $gambar2Path = $request->file('gambar2') ? $request->file('gambar2')->store('images/destinasi', 'public') : null;
        $gambar3Path = $request->file('gambar3') ? $request->file('gambar3')->store('images/destinasi', 'public') : null;
        $gambar4Path = $request->file('gambar4') ? $request->file('gambar4')->store('images/destinasi', 'public') : null;
        $gambar5Path = $request->file('gambar5') ? $request->file('gambar5')->store('images/destinasi', 'public') : null;
        $gambarMPath = $request->file('gambarM') ? $request->file('gambarM')->store('images/destinasi', 'public') : null;

        // menyimpan destinasi ke database
        Destination::create([
            'tujuan' => $validatedData['tujuan'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'kategori_id' => $validatedData['kategori_id'],
            'desk' => $validatedData['desk'],
            'long_desk' => $validatedData['long_desk'],
            'gambar' => $gambarPath,
            'gambar2' => $gambar2Path,
            'gambar3' => $gambar3Path,
            'gambar4' => $gambar4Path,
            'gambar5' => $gambar5Path,
            'gambarM' => $gambarMPath,
        ]);

        return redirect()->route('destinasi.index')->with('Success', 'Destinasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // mencari destinasi berdasarkan ID 
        $destination = Destination::findOrFail($id);
        return view('destinasi.show', compact('destination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // mencari destinasi dan kategori berdasarkan ID 
        $destination = Destination::findOrFail($id);
        $categories = kategori::all();
        return view('destinasi.edit', compact('destination', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tujuan' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori_id' => 'required|exists:kategori,id_kategori',
            'desk' => 'nullable|string',
            'long_desk' => 'nullable|string',
            'gambar' => 'nullable|image',
            'gambar2' => 'nullable|image',
            'gambar3' => 'nullable|image',
            'gambar4' => 'nullable|image',
            'gambar5' => 'nullable|image',
            'gambarM' => 'nullable|image',
        ]);

        // mencari destinasi berdasarkan ID 
        $destination = Destination::findOrFail($id);

        // Update data 
        $destination->tujuan = $validatedData['tujuan'];
        $destination->latitude = $validatedData['latitude'];
        $destination->longitude = $validatedData['longitude'];
        $destination->kategori_id = $validatedData['kategori_id'];
        $destination->desk = $validatedData['desk'];
        $destination->long_desk = $validatedData['long_desk'];

        // untuk gambar 
        if ($request->hasFile('gambar')) {
            $destination->gambar = $request->file('gambar')->store('images/destinasi', 'public');
        }

        if ($request->hasFile('gambar2')) {
            $destination->gambar2 = $request->file('gambar2')->store('images/destinasi', 'public');
        }

        if ($request->hasFile('gambar3')) {
            $destination->gambar3 = $request->file('gambar3')->store('images/destinasi', 'public');
        }

        if ($request->hasFile('gambar4')) {
            $destination->gambar4 = $request->file('gambar4')->store('images/destinasi', 'public');
        }
        if ($request->hasFile('gambar5')) {
            $destination->gambar5 = $request->file('gambar5')->store('images/destinasi', 'public');
        }
        if ($request->hasFile('gambarM')) {
            $destination->gambarM = $request->file('gambarM')->store('images/destinasi', 'public');
        }

        $destination->save();

        return redirect()->route('destinasi.index')->with('Success', 'Destinasi Berhasil diUpdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // mencari destinasi menggunakan ID  
        $destination = Destination::findOrFail($id);

        $destination->delete();

        return redirect()->route('destinasi.index')->with('Success', 'Destinasi Berhasil Dihapus');
    }
}
