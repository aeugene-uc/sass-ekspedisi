<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\LandingController;
use App\Livewire\Platform;


Route::domain(config('app.domain'))->group(function () {
    // Landing
    Route::get('/', [LandingController::class, 'beranda'])->name('beranda');
    Route::get('/tentang-kami', [LandingController::class, 'profilPerusahaan'])->name('profil-perusahaan');

    // Platform Dashboard
    Route::middleware('platform.admin.access')->prefix('admin')->group(function () {
        Route::get('/login', Platform\Login::class)
            ->name('platform.login');

        Route::get('/', function() {
            return redirect()->route('platform.perusahaan');
        })->name('platform.dashboard');

        Route::get('/perusahaan', Platform\Perusahaan::class)
            ->name('platform.perusahaan');
    });
});

Route::domain('{subdomain}.' . config('app.domain'))->group(function () {
    // Other subdomain routes can be defined here
});
