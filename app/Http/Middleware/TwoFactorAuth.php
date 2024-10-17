<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TwoFactorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('2fa_verified')) {
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}