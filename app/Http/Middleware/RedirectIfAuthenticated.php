<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? ['pemilik_wisata', 'wisatawan'] : $guards;

        // Looping untuk memeriksa jika sudah ada yang terautentikasi
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Jika sudah login dengan salah satu guard, redirect ke halaman yang sesuai
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
