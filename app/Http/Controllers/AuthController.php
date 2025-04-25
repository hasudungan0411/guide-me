<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showlogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'peran' => 'required|in:wisatawan,pemilikwisata',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->peran;

        if ($role === 'wisatawan') {
            if (Auth::guard('wisatawan')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard/wisatawan');
            }
        } elseif ($role === 'pemilikwisata') {
            if (Auth::guard('pemilikwisata')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboard/pemilik');
            }
        }

        return back()->withErrors([
            'email' => 'Login gagal, periksa kembali kredensial Anda.',
        ]);
    }

    public function showregister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'peran'    => 'required|in:wisatawan,pemilikwisata',
            'nama'     => 'nullable|string|max:255',
            'email'    => 'required|email|max:255',
            'no_hp'    => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'nama_wisata'  => 'nullable|string|max:255',
            'lokasi'   => 'nullable|string|max:255', // Menambahkan lokasi untuk pemilik wisata
        ]);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Proses registrasi berdasarkan peran yang dipilih
        if ($request->peran === 'wisatawan') {
            // Menyimpan data wisatawan
            $user = Wisatawan::create([
                'Nama'     => $request->nama,
                'Email'    => $request->email,
                'Nomor_HP' => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->password),
            ]);
    
            // Login sebagai wisatawan
            Auth::guard('wisatawan')->login($user);
    
            // Mengarahkan setelah login
            return redirect()->route('home'); // Ganti dengan rute yang sesuai
    
        } else {
            // Menyimpan data pemilik wisata
            $user = PemilikWisata::create([
                'Email'    => $request->email,
                'Lokasi'   => $request->lokasi,
                'Nomor_HP' => $request->no_hp,
                'Kata_Sandi' => Hash::make($request->password),
                'Nama_Wisata' => $request->nama_wisata,
            ]);
    
            // Login sebagai pemilik wisata
            Auth::guard('pemilik_wisata')->login($user);
    
            // Mengarahkan setelah login
            return redirect()->route('home'); // Ganti dengan rute yang sesuai
        }
    }
    
}
