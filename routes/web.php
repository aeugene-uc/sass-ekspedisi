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

    Route::get('/', function() {
        return redirect()->route('perusahaan.login', ['subdomain' => request()->route('subdomain')]);
    });

    // Login route is public
    Route::middleware('perusahaan.noauth')->group(function () {
        Route::get('/login', Perusahaan\Login::class)
            ->name('perusahaan.login');

        Route::get('/register', Perusahaan\Register::class)
            ->name('perusahaan.register');
    });

    Route::middleware('perusahaan.login.access')->group(function () {
        Route::get('/dashboard', function() {
            return redirect()->route('perusahaan.peran-user', ['subdomain' => request()->route('subdomain')]);
        })
        ->name('perusahaan.dashboard');           

        // Internal
        Route::get('/peran-user', Perusahaan\PeranUser::class)
            ->name('perusahaan.peran-user');

        Route::get('/kendaraan', Perusahaan\Kendaraan::class)
            ->name('perusahaan.kendaraan');

        Route::get('/counter', Perusahaan\Counter::class)
            ->name('perusahaan.counter');

        Route::get('/jangkauan', Perusahaan\Jangkauan::class)
            ->name('perusahaan.jangkauan');

        Route::get('/daftar-pesanan', Perusahaan\Pesanan::class)
            ->name('perusahaan.pesanan');

        // Guest
        // Route::get('/pesan', Perusahaan\Pesan::class)
        //     ->name('perusahaan.pesan');
    });
});
