<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Menangani permintaan yang masuk dan memverifikasi apakah pengguna sudah terautentikasi.
     * Jika belum, redirect ke halaman login.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param  mixed ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Jika tidak ada guard yang diberikan, gunakan guard default
        $guard = count($guards) > 0 ? $guards[0] : null;

        // Cek apakah pengguna sudah login dengan guard yang dipilih
        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        // Redirect ke halaman login jika pengguna belum terautentikasi
        return redirect()->route('pemilik.login');
    }
}
