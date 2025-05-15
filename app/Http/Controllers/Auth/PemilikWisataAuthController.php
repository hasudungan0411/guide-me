<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PemilikWisataAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pemilik.login'); // Pastikan view ini ada
    }

    public function login(Request $request)
    {
        $credentials = [
            'Email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('pemilikwisata')->attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::guard('pemilikwisata')->user();
            $namawisata = $user->Nama_Wisata;

            Alert::success('Success','Selamat datang pemilik wisata, ' . $namawisata );
            return redirect()->route('pemilik.index');
        }

        Alert::error('Login Gagal', 'Email atau password salah.');
        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('pemilikwisata')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        alert::success('Success','Anda berhasil keluar');
        return redirect()->route('pemilik.login');
    }
}
