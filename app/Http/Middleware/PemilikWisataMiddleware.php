<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Pemilikwisata;
use Auth;

class PemilikWisataMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::guard('pemilik_wisata')->check() ) {
            return redirect()->route('login')->with('error', 'bukan pemilik');
        }

        return $next($request);
    }
}
