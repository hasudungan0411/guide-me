<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\kategori;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('kategori')->get();
        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = kategori::all();
        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id'=> 'required|exists:kategori,id_kategori',
            'short_desk' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image',
            'tanggal' => 'required|date',
            // 'slug' => 'required|string|max:255'
        ]);

        // simpan gambar dan ambil nama file nya
        $gambar = $request->file('gambar')->hashName();
        $request->file('gambar')->storeAs('images/blog', $gambar, 'public');

        Blog::create([
            'judul' => $validatedData['judul'],
            'kategori_id' => $validatedData['kategori_id'],
            'short_desk' => $validatedData['short_desk'],
            'deskripsi' => $validatedData['deskripsi'],
            'gambar' => $gambar,
            'tanggal' => $validatedData['tanggal'],
            'slug' => Str::slug($validatedData['judul'])
        ]);

        return redirect()->route('blog.index')->with('success', 'Berhasil Menambahkan Blog');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $blog = Blog::with('kategori')->where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = Kategori::all();
        return view('blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori_id'=> 'required|exists:kategori,id_kategori',
            'short_desk' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image',
            'tanggal' => 'required|date',
            // 'slug' => 'required|string|max:255'
        ]);

        // mencari blog berdasarkan id 
        $blog = Blog::findOrFail($id);

        $blog->judul = $validatedData['judul'];
        $blog->kategori_id = $validatedData['kategori_id'];
        $blog->short_desk = $validatedData['short_desk'];
        $blog->deskripsi = $validatedData['deskripsi'];
        $blog->tanggal = $validatedData['tanggal'];
        $blog->slug = Str::slug($validatedData['judul']);

        // mengambil gambarnya 
        if ($request->hasfile('gambar')) {
            $gambar = $request->file('gambar')->hashName();
            $request->file('gambar')->storeAs('images/blog', $gambar, 'public');
            $blog->gambar = $gambar;
        }

        $blog->save();

        return redirect()->route('blog.index')->with('success', 'Berhasil Update Blog');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Berhasil Menghapus Blog');
    }
}
