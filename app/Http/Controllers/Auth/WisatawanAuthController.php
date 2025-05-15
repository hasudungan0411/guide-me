<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use RealRashid\SweetAlert\Facades\Alert;

class WisatawanAuthController extends Controller
{
    public function login()
    {
        return view('wisatawan.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = [
            'Email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('wisatawan')->attempt($credentials)) {
            $request->session()->regenerate();
            // Alert::success('Berhasil', 'Selamat datang DiGuide-Me');
            return redirect()->route('wisatawan.home')->with('success','Selamat datang di Guide-Me');
        }

        Alert::error('Error', 'Email atau Password tidak sesuai');
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $existingUser = Wisatawan::where('Email', $googleUser->getEmail())->first();

            if ($existingUser) {
                Auth::guard('wisatawan')->login($existingUser);
                session()->regenerate();

                // $existingUser->last_login = now();
                // $existingUser->save();

                // Alert::success('Login Berhasil', 'Selamat datang kembali, ' . $existingUser->Nama . '!');
                return redirect()->route('wisatawan.home')->with('success','Selamat datang kembali, ' . $existingUser->Nama .'!');
            }

            $newUser = Wisatawan::create([
                'Nama' => $googleUser->getName(),
                'Email' => $googleUser->getEmail(),
                'Kata_Sandi' => bcrypt(Str::random(16)),
                'Foto_Profil' => $googleUser->getAvatar(),
                'Nomor_HP' => '-',
            ]);

            Auth::guard('wisatawan')->login($newUser);
            session()->regenerate();

            // Alert::success('Registrasi & Login Berhasil', 'Selamat datang, ' . $newUser->Nama . '!');
            return redirect()->route('wisatawan.home')->with('success','Selamat datang, ' . $newUser->Nama .'!');

        } catch (\Exception $e) {
            Alert::error('Login Gagal', $e->getMessage());
            return redirect()->route('wisatawan.login');
        }
    }

    public function register()
    {
        return view('wisatawan.register');
    }

    public function registerPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:wisatawan,Email',
            'phone' => 'required|string|min:10|max:15',
            'password' => [
                'required',
                'min:8',
                'regex:/[a-z]/',     // huruf kecil
                'regex:/[A-Z]/',     // huruf kapital
                'regex:/[0-9]/',     // angka
                'confirmed'
            ],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'phone.required' => 'Nomor HP wajib diisi',
            'password.required' => 'Kata sandi wajib diisi',
            'password.min' => 'Kata Sandi wajib minimal 8 karakter',
            'password.regex' => 'Kata sandi wajib mengandung huruf kecil, kapital, dan angka',
            'password.confirmed' => 'Konfirmasi tidak sama',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->route('wisatawan.register');
        }

        Wisatawan::create([
            'Nama' => $request->name,
            'Email' => $request->email,
            'Nomor_HP' => $request->phone,
            'Kata_Sandi' => bcrypt($request->password),
            'Foto_Profil' => null,
        ]);

        Alert::success('Success', 'Akun berhasil dibuat');
        return redirect()->route('wisatawan.login');
    }

    public function logout(Request $request)
    {
        Auth::guard('wisatawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Alert::success('success', 'Anda Berhasil Keluar');
        return redirect()->route('wisatawan.home')->with('success','Anda Berhasil Keluar');
    }
}
