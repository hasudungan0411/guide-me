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
            $maskedEmail = $this->maskEmail($request->email);
            return redirect()->back()->with('success', "Link sudah dikirim ke email <b>$maskedEmail</b>.");
        } else {
            return back()->withErrors(['email' => trans($status)]);
        }
    }

    /**
     * Masking alamat email menjadi format seperti ka*****4@gmail.com
     */
    private function maskEmail($email)
    {
        [$name, $domain] = explode('@', $email);

        if (strlen($name) <= 3) {
            // Jika terlalu pendek, jangan mask terlalu banyak
            $masked = substr($name, 0, 1) . str_repeat('*', max(0, strlen($name) - 1));
        } else {
            $firstTwo = substr($name, 0, 2);
            $lastChar = substr($name, -1);
            $masked = $firstTwo . str_repeat('*', strlen($name) - 3) . $lastChar;
        }

        return $masked . '@' . $domain;
    }
}
