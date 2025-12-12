<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlatformNoAuth
{
    /**
     * Handle an incoming request.
     *
     * Only allow guests. If authenticated, redirect them elsewhere.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in
        if (Auth::check()) {
            // Redirect authenticated users to their dashboard (or any route)
            return redirect()->route('platform.dashboard');
        }

        // Otherwise, continue to the intended route
        return $next($request);
    }
}
