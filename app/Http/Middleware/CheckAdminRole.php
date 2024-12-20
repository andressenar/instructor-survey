<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::checkuser()->role == 'admin') {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
