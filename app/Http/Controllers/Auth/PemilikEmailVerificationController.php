<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Events\Verified;
use App\Models\PemilikWisata;

class PemilikEmailVerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        $pemilik = Pemilikwisata::find($id);

        if (!$pemilik) {
            return redirect()->route('pemilikwisata.login')->with('error', 'Pemilik tidak ditemukan.');
        }

        // Gunakan Laravel default hash_equals untuk keamanan
        if (!hash_equals(sha1($pemilik->getEmailForVerification()), $hash)) {
            return redirect()->route('pemilikwisata.verifikasi')->with('error', 'Link verifikasi tidak valid.');
        }

        // Cek dan tandai sebagai terverifikasi jika belum
        if (!$pemilik->hasVerifiedEmail()) {
            $pemilik->markEmailAsVerified();
            event(new Verified($pemilik));
        }

        return redirect()->route('pemilikwisata.verified')->with('success', 'Email berhasil diverifikasi.');
    }
}
