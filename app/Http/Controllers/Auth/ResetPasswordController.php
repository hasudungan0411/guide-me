<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('wisatawan.password.reset-wisatawan', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::broker('wisatawan')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Perbarui kata sandi pengguna
                $user->forceFill([
                    'Kata_Sandi' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('wisatawan.login')->with('success', 'Kata Sandi Anda telah berhasil diperbaharui.');
        } else {
            return back()->withErrors(['Error', 'Gagal memperbaharui kata sandi. Silakan coba lagi.']);
        }
   }
}
