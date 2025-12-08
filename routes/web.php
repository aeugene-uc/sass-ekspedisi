<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\LandingController;
use App\Livewire\Perusahaan;
use App\Livewire\Platform;


Route::domain(config('app.domain'))->group(function () {
    // Landing
    Route::get('/', [LandingController::class, 'beranda'])->name('beranda');
    Route::get('/tentang-kami', [LandingController::class, 'profilPerusahaan'])->name('profil-perusahaan');

    // Platform Dashboard
    Route::prefix('admin')->group(function () {
        Route::get('/login', Platform\Login::class)
            ->name('platform.login');

        Route::middleware('platform.admin.access')->group(function () {
            Route::get('/', function() {
                return redirect()->route('platform.perusahaan');
            })->name('platform.dashboard');

            Route::get('/perusahaan', Platform\Perusahaan::class)
                ->name('platform.perusahaan');

            Route::get('/laporan-keuangan', Platform\LaporanKeuangan::class)
                ->name('platform.laporan-keuangan');
        });
    });
});

Route::domain('{subdomain}.' . config('app.domain'))
    ->middleware(['check.subdomain']) // checks if subdomain exists
    ->group(function () {

    // Login route is public
    Route::get('/login', Perusahaan\Login::class)
        ->name('perusahaan.login');

    Route::get('/', function() {
        return redirect()->route('perusahaan.dashboard', ['subdomain' => request()->route('subdomain')]);
    });

    Route::middleware('perusahaan.login.access')->group(function () {
        Route::prefix('admin')->group(function () {
             Route::get('/', function() {
                return redirect()->route('perusahaan.peran-user', ['subdomain' => request()->route('subdomain')]);
             })
                ->name('perusahaan.dashboard');           

            Route::get('/peran-user', Perusahaan\PeranUser::class)
                ->name('perusahaan.peran-user');

            Route::get('/status-pesanan', Perusahaan\PeranUser::class)
                ->name('perusahaan.status-pesanan');
        });
    });
});
