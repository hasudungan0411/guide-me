<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePemilikEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('pemilikwisata')->user();

        if (!$user || is_null($user->email_verified_at)) {
            return redirect()->route('pemilikwisata.verifikasi');
        }

        return $next($request);
    }
}

