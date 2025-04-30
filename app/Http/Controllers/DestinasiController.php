<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use App\Models\kategori;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class DestinasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua destinasi dari database
        $destinations = Destination::all();

        $totalBlog = Blog::count();
        $totalDestinasi = $destinations->count();

        // menghitung total gambar dari semua destinasi 
        $totalGambar = $destinations->reduce(function ($carry, $item)
        {
            $gambarFields = ['gambar', 'gambar2', 'gambar3', 'gambar4', 'gambar5', 'gambarM'];
            foreach ($gambarFields as $field)
            {
                if (!empty($item->$field))
                {
                    $carry++;
                }
            }
            return $carry;
        }, 0);

        // kirim datanya ke view 
        return view('destinasi.index', compact('destinations', 'totalBlog', 'totalDestinasi', 'totalGambar'));
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

        // simpan file gambar dan ambil nama filenya 
        $gambarName = $request->file('gambar')->hashName();
        $request->file('gambar')->storeAs('images/destinasi', $gambarName, 'public');

        $gambar2Name = $request->file('gambar2') ? $request->file('gambar2')->hashName() : null;
        if ($gambar2Name) $request->file('gambar2')->storeAs('images/destinasi', $gambar2Name, 'public');

        $gambar3Name = $request->file('gambar3') ? $request->file('gambar3')->hashName() : null;
        if ($gambar3Name) $request->file('gambar3')->storeAs('images/destinasi', $gambar3Name, 'public');

        $gambar4Name = $request->file('gambar4') ? $request->file('gambar3')->hashName() : null;
        if ($gambar4Name) $request->file('gambar4')->storeAs('images/destinasi', $gambar4Name, 'public');

        $gambar5Name = $request->file('gambar5') ? $request->file('gambar5')->hashName() : null;
        if ($gambar5Name) $request->file('gambar5')->storeAs('images/destinasi', $gambar5Name, 'public');

        $gambarMName = $request->file('gambarM') ? $request->file('gambarM')->hashName() : null;
        if ($gambarMName) $request->file('gambarM')->storeAs('images/destinasi', $gambarMName, 'public');

        // menyimpan destinasi ke database
        Destination::create([
            'tujuan' => $validatedData['tujuan'],
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'kategori_id' => $validatedData['kategori_id'],
            'desk' => $validatedData['desk'],
            'long_desk' => $validatedData['long_desk'],
            'gambar' => $gambarName,
            'gambar2' => $gambar2Name,
            'gambar3' => $gambar3Name,
            'gambar4' => $gambar4Name,
            'gambar5' => $gambar5Name,
            'gambarM' => $gambarMName,
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

        // karna dia kebalik jadi Cek dan swap koordinat kalau terbalik (data lama)
        if (
            // longitude valid sebagai latitude
            $destination->longitude >= -90 && $destination->longitude <= 90 &&
            // latitude valid sebagai longitude
            ($destination->latitude < -90 || $destination->latitude > 90)
        ) {
            $temp = $destination->latitude;
            $destination->latitude = $destination->longitude;
            $destination->longitude = $temp;
        }

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
            $gambarName = $request->file('gambar')->hashName();
            $request->file('gambar')->storeAs('images/destinasi', $gambarName, 'public');
            $destination->gambar = $gambarName;
        }

        if ($request->hasFile('gambar2')) {
            $gambar2Name = $request->file('gambar2')->hashName();
            $request->file('gambar2')->storeAs('images/destinasi', $gambar2Name, 'public');
            $destination->gambar2 = $gambar2Name;
        }

        if ($request->hasFile('gambar3')) {
            $gambar3Name = $request->file('gambar3')->hashName();
            $request->file('gambar3')->storeAs('images/destinasi', $gambar3Name, 'public');
            $destination->gambar3 = $gambar3Name;
        }

        if ($request->hasFile('gambar4')) {
            $gambar4Name = $request->file('gambar4')->hashName();
            $request->file('gambar4')->storeAs('images/destinasi', $gambar4Name, 'public');
            $destination->gambar4 = $gambar4Name;
        }

        if ($request->hasFile('gambar5')) {
            $gambar5Name = $request->file('gambar5')->hashName();
            $request->file('gambar5')->storeAs('images/destinasi', $gambar5Name, 'public');
            $destination->gambar5 = $gambar5Name;
        }

        if ($request->hasFile('gambarM')) {
            $gambarMName = $request->file('gambarM')->hashName();
            $request->file('gambarM')->storeAs('images/destinasi', $gambarMName, 'public');
            $destination->gambarM = $gambarMName;
        }

        $destination->save();

        return redirect()->route('destinasi.index')->with('Success', 'Destinasi Berhasil diUpdate');
    }

    /**
     * Remove the specified resource from storage..
     */
    public function destroy(string $id)
    {
        // mencari destinasi menggunakan ID  
        $destination = Destination::findOrFail($id);

        // hapus gambar dari storage 
        $gambarFields = ['gambar', 'gambar2', 'gambar3', 'gambar4', 'gambar5', 'gambarM'];
        foreach ($gambarFields as $gambar) {
            if ($destination->$gambar) {
                Storage::disk('public')->delete('images/destinasi/' . $destination->$gambar);
            }
        }

        // Hapus destinasi dari database
        $destination->delete();

        return redirect()->route('destinasi.index')->with('Success', 'Destinasi Berhasil Dihapus');
    }
}
