<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in') || session('admin_role') !== 'super_admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak! Hanya Super Admin yang diizinkan.');
        }

        return $next($request);
    }
}
