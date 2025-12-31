<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckParentLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('parent_id')) {
            return redirect()->route('parent.login')->with('error', 'Silakan login terlebih dahulu');
        }

        return $next($request);
    }
}
