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
        $guard = count($guards) > 0 ? $guards[0] : null;

        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        // Redirect sesuai guard
        switch ($guard) {
            case 'admin':
                return redirect()->route('admin.login');
            case 'wisatawan':
                return redirect()->route('wisatawan.login');
            case 'pemilikwisata':
                return redirect()->route('pemilik.login');
            default:
                return redirect('/'); // fallback jika tidak dikenali
        }
    }
}
