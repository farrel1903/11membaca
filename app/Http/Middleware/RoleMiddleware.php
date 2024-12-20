<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah user sudah login dan apakah role user sesuai
        if (Auth::check() && in_array(Auth::user()->role_as, $roles)) {
            return $next($request);
        }

        // Jika user tidak memiliki role yang sesuai, arahkan ke halaman yang diinginkan
        return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
