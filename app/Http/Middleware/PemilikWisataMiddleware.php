<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PemilikWisataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login dengan guard 'pemilikwisata'
        if (!Auth::guard('pemilikwisata')->check()) {
            // Jika tidak, redirect ke halaman login dan kirimkan pesan error
            return redirect()->route('pemilikwisata.login')->with('error', 'Anda bukan pemilik wisata, silakan login sebagai pemilik.');
        }

        // Jika pengguna sudah login sebagai pemilik wisata, lanjutkan request
        return $next($request);
    }
}
