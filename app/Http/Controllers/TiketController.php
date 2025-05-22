<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class TiketController extends Controller
{
    public function index()
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        $tiket = $destinasi ? $destinasi->tiket()->firstOrFail() : abort(404);

        return view('pemilik.tiket', compact('tiket', 'destinasi'));
    }

    public function update(Request $request)
    {
        $pemilik = Auth::guard('pemilikwisata')->user();
        $destinasi = $pemilik->destination;

        $tiket = $destinasi ? $destinasi->tiket()->firstOrFail() : abort(404);

        $request->validate([
            'Persediaan' => 'required|integer|min:1',
            'Harga' => 'required|numeric|min:0',
        ]);

        $tiket->update([
            'Persediaan' => $request->Persediaan,
            'Harga' => $request->Harga,
        ]);

        return redirect()->route('pemilik.tiket')->with('success', 'Tiket berhasil diperbarui');
    }
}
