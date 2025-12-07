<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PlatformAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $path = trim($request->path(), '/'); 
        $isLoginPage = $path === 'admin/login';
        $isAdminBase = $path === 'admin';

        // User is NOT logged in
        if (!Auth::check()) {
            if ($isAdminBase) {
                return redirect('/admin/login');
            }
            return $next($request);
        }

        // User IS logged in
        if ($isLoginPage) {
            return redirect('/admin');
        }

        return $next($request);
    }
}
