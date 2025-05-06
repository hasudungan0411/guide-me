<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class WisatawanMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('wisatawan')->check()) {
            return redirect()->route('wisatawan.login')->with('error', 'Anda bukan wisatawan, silakan login sebagai wisatawan.');
        }

        return $next($request);
    }
}

