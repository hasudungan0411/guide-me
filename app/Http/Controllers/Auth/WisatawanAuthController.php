<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wisatawan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class WisatawanAuthController extends Controller
{
    public function showRegister()
    {
        return view('wisatawan.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:wisatawan,Email',
            'no_hp' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Wisatawan::create([
            'Nama' => $request->nama,
            'Email' => $request->email,
            'Nomor_HP' => $request->no_hp,
            'Kata_Sandi' => $request->password,
        ]);

        event(new Registered($user));
        Auth::guard('wisatawan')->login($user);

        return redirect()->route('verification.notice');
    }

    public function showLogin()
    {
        return view('wisatawan.login');
    }

    public function login(Request $request)
    {
        $credentials = [
            'Email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('wisatawan')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/wisatawan');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout(Request $request)
    {
        Auth::guard('wisatawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('wisatawan.login');
    }
}
