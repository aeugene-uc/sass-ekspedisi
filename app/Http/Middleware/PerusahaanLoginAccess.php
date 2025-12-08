<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Auth;

// class PerusahaanLoginAccess
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle($request, Closure $next)
//     {
//         $path = trim($request->path(), '/'); 
//         $isLoginPage = $path === 'login';
//         $isDestinationBase = $path === '';

//         // User is NOT logged in
//         if (!Auth::check()) {
//             if ($isDestinationBase) {
//                 return redirect('/login');
//             }
//             return $next($request);
//         }

//         // User IS logged in
//         if ($isLoginPage) {
//             return redirect('/');
//         }

//         return $next($request);
//     }
// }
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerusahaanLoginAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $subdomain = explode('.', $request->getHost())[0];

        $path = trim($request->path(), '/');
        $guestPaths = ['login', 'register'];

        // If visiting login/register while authenticated, redirect to dashboard
        if (in_array($path, $guestPaths) && $user) {
            return redirect()->route('perusahaan.dashboard', ['subdomain' => $subdomain]);
        }

        // All other routes require login
        if (!in_array($path, $guestPaths) && !$user) {
            return redirect()->route('perusahaan.login', ['subdomain' => $subdomain]);
        }

        // Tenant validation: ensure user belongs to correct subdomain
        if ($user && !$user->peran->is_platform_admin && ($user->peran->perusahaan?->subdomain !== $subdomain)) {
            Auth::logout();
            return redirect()->route('perusahaan.login', ['subdomain' => $subdomain]);
        }

        return $next($request);
    }
}
