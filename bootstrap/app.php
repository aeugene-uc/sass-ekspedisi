<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'platform.admin.access' => \App\Http\Middleware\PlatformAdminAccess::class,
            'check.subdomain' => \App\Http\Middleware\CheckSubdomain::class,
            'perusahaan.noauth' => \App\Http\Middleware\PerusahaanNoAuth::class,
            'platform.noauth' => \App\Http\Middleware\PlatformNoAuth::class,
            'perusahaan.login.access' => \App\Http\Middleware\PerusahaanLoginAccess::class,
            'perusahaan.admin.access' => \App\Http\Middleware\PerusahaanAdmin::class,
            'perusahaan.kurir.access' => \App\Http\Middleware\PerusahaanKurir::class
        ]);

        $middleware->validateCsrfTokens(except: [
            'midtrans-webhook',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
