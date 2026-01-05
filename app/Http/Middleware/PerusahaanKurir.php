<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class PerusahaanKurir
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $currentSubdomain = explode('.', $request->getHost())[0];

        if (!$user) {
            return redirect()->route('perusahaan.login', ['subdomain' => $currentSubdomain]);
        }

        if (!$user->is_platform_admin) {
            if ($user->perusahaan->subdomain !== $currentSubdomain || $user->peran_id !== 3) {
                abort(403); 
            }
        }

        return $next($request);
    }
}
