<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
<<<<<<< HEAD
use Auth;
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> e85c0c8fc7ed4c07599dd37703c0e7f6d0794de3


class AuthController extends Controller
{
    public function showlogin()
    {
        return view('login');
<<<<<<< HEAD
=======
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
>>>>>>> e85c0c8fc7ed4c07599dd37703c0e7f6d0794de3
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
<<<<<<< HEAD

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
=======
    
>>>>>>> e85c0c8fc7ed4c07599dd37703c0e7f6d0794de3
}
}


