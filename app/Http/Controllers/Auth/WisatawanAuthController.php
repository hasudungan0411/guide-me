<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use App\Models\EmailOtp;
use App\Mail\EmailOtpMail;
use Carbon\Carbon;
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
            return redirect()->route('wisatawan.home')->with('success', 'Selamat datang di Guide-Me');
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
                return redirect()->route('wisatawan.home')->with('success', 'Selamat datang kembali, ' . $existingUser->Nama . '!');
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
            return redirect()->route('wisatawan.home')->with('success', 'Selamat datang, ' . $newUser->Nama . '!');

        } catch (\Exception $e) {
            Alert::error('Login Gagal', $e->getMessage());
            return redirect()->route('wisatawan.login');
        }
    }

    public function register()
    {
        return view('wisatawan.register');
    }

    public function showOtpForm()
    {
        if (!session('wisatawan_register')) {
            return redirect()->route('wisatawan.register');
        }

        return view('wisatawan.verifikasi.form-otp');
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

      session([
        'wisatawan_register' => [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
          ]
       ]);

        $otp = rand(100000, 999999);

        EmailOtp::updateOrCreate(
        ['email_wisatawan' => $request->email],
         [
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
           ]
        );

        Mail::to($request->email)->send(new EmailOtpMail($otp));

        $maskedEmail = $this->maskEmail($request->email);
        Alert::html('OTP Dikirim', 'Kode OTP telah dikirim ke email <b>' . $maskedEmail . '</b>.', 'success');

        return redirect()->route('wisatawan.otp.form');
}

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $sessionData = session('wisatawan_register');

        if (!$sessionData) {
            Alert::error('Gagal', 'Email tidak ditemukan.');
            return redirect()->route('wisatawan.register');
        }

        $otpData = EmailOtp::where('email_wisatawan', $sessionData['email'])
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpData) {
            Alert::error('OTP Salah', 'Kode OTP tidak valid atau sudah kedaluwarsa.');
            return redirect()->route('wisatawan.otp.form');
        }

        Wisatawan::create([
            'Nama' => $sessionData['name'],
            'Email' => $sessionData['email'],
            'Nomor_HP' => $sessionData['phone'],
            'Kata_Sandi' => $sessionData['password'],
            'Foto_Profil' => null,
            'email_verified_at' => now(),
        ]);

        session()->forget('wisatawan_register');
        EmailOtp::where('email_wisatawan', $sessionData['email'])->delete();

        Alert::success('Berhasil', 'Akun berhasil dibuat. Silakan login.');
        return redirect()->route('wisatawan.login');
    }

    public function logout(Request $request)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::guard('wisatawan')->user();

        Auth::guard('wisatawan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget('favorit_' . $user->id);

        // Alert::success('success', 'Anda Berhasil Keluar');
        return redirect()->route('wisatawan.home')->with('success', 'Anda Berhasil Keluar');
    }

    private function maskEmail($email)
    {
    $emailParts = explode("@", $email);
    $namePart = $emailParts[0];
    $domainPart = $emailParts[1];

    $visibleChars = strlen($namePart) >= 3 ? 2 : 1;
    $maskedName = substr($namePart, 0, $visibleChars) . str_repeat("*", max(1, strlen($namePart) - $visibleChars - 1)) . substr($namePart, -1);

    return $maskedName . '@' . $domainPart;
    }
}
