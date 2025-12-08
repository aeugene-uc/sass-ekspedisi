<?php

namespace App\Http\Middleware;

use App\Models\Perusahaan;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $subdomain = $request->route('subdomain');

        if (!Perusahaan::where('subdomain', $subdomain)->exists()) {
            abort(404); // or redirect somewhere
        }

        return $next($request);
    }
}
