<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek jika user sudah login dan memiliki role yang sesuai
        if (Auth::check() && Auth::user()->role_as == $role) {
            return $next($request);
        }
    
        // Jika role tidak sesuai atau belum login, redirect ke halaman home dengan pesan error
        return redirect('/home')->with('error', 'Anda harus login sesuai role untuk mengakses halaman ini, silahkan kembali');
    }    
}
