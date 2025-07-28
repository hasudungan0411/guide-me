<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Wisatawan; // Pastikan model Wisatawan di-import

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan formulir permintaan link reset password.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        // Mengarahkan pengguna ke halaman formulir reset password
        return view('wisatawan.password.email-wisatawan');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validasi email pengguna
        $request->validate(['email' => 'required|email']);

        // Cari pengguna berdasarkan email
        $user = Wisatawan::where('Email', $request->email)->first();

        // Pastikan pengguna ditemukan.
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Mengirimkan link reset password.
        $status = Password::broker('wisatawan')->sendResetLink(
            $request->only('email')
        );

        // Mengecek status pengiriman email
        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back()->with('success', 'Link Atur Ulang Kata Sandi telah dikirim ke email Anda.');
        } else {
            return back()->withErrors(['email' => trans($status)]);
        }
    }
}
