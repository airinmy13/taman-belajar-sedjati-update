<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRegularAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_logged_in') || !in_array(session('admin_role'), ['super_admin', 'admin'])) {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak! Login sebagai admin diperlukan.');
        }

        return $next($request);
    }
}
