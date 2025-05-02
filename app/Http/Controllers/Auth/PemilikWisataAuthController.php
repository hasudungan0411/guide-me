<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilikwisata;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class PemilikWisataAuthController extends Controller
{
    public function showRegister()
    {
        return view('pemilik.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:pemilik_wisata,Email',
            'password' => 'required|confirmed|min:6',
            'no_hp' => 'required',
            'nama_wisata' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        $user = Pemilikwisata::create([
            'Email' => $request->email,
            'Kata_Sandi' => Hash::make($request->password),
            'Nomor_HP' => $request->no_hp,
            'Nama_Wisata' => $request->nama_wisata,
            'Lokasi' => $request->lokasi,
        ]);

        Auth::guard('pemilikwisata')->login($user);

        event(new Registered($user));
        return redirect()->route('pemilikwisata.verifikasi');
    }


    public function showLogin()
    {
        return view('pemilik.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'Email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('pemilikwisata')->attempt($credentials)) {
            $request->session()->regenerate();

            if (!Auth::guard('pemilikwisata')->user()->hasVerifiedEmail()) {
                return redirect()->route('pemilikwisata.verifikasi')->with('info', 'Silakan verifikasi email Anda terlebih dahulu.');
            }

            return redirect()->intended(route('pemilik.index'));
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }
}
