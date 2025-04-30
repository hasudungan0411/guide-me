<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;


class AuthController extends Controller
{
    public function showlogin()
    {
        return view('login');
    }
    

    public function showregister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'peran'    => 'required|in:wisatawan,pemilikwisata',
            'nama'     => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'nama_wisata'  => 'nullable|string|max: 255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->peran === 'wisatawan') {
            $user = Wisatawan::create([
                'Nama'     => $request->nama,
                'Email'    => $request->email,
                'Nomor_HP'   => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->password)
            ]);
        } else {
            $user = PemilikWisata::create([
                'Email'    => $request->email,
                'Lokasi'    => $request->lokasi,
                'Nomor_HP'   => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->password),
                'Nama_Wisata'  => $request->nama_wisata
            ]);
        }

        return view('register');

        // return response()->json([
        //     'message' => 'User registered successfully as ' . $request->peran,
        //     'user'    => $user
        // ], 201);
    }

    public function logout(Request $request){
        // Ambil peran dari session
        $peran = $request->session()->get('peran', 'wisatawan'); // Default ke wisatawan jika tidak ada

        // Logout menggunakan guard berdasarkan peran
        Auth::guard($peran)->logout();

        // Hapus semua data session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login');
}
}


