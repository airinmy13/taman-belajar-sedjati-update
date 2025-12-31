<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckStudentLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('is_student_logged_in')) {
            return redirect()->route('home')->with('show_login', true)->with('error', 'Kamu harus login dulu untuk main game!');
        }

        return $next($request);
    }
}