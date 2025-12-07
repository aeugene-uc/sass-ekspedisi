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
    Route::prefix('admin')->group(function () {
        Route::get('/login', Platform\Login::class);

        Route::middleware(['auth'])->group(function () {
            Route::get('/', Platform\Dashboard::class)->name('platform.dashboard');
        });
    });
});
