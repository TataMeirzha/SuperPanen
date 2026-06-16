<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect('/dashboard')->with('error', 'Akses ditolak!');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun kamu dinonaktifkan.');
        }

        return $next($request);
    }
}