<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MidtransController;
use App\Livewire\Perusahaan;
use App\Livewire\Platform;
use Illuminate\Support\Facades\Auth;

Route::domain(config('app.domain'))->group(function () {
    // Landing
    // Route::get('/', [LandingController::class, 'beranda'])->name('beranda');
    // Route::get('/tentang-kami', [LandingController::class, 'profilPerusahaan'])->name('profil-perusahaan');
    Route::get('/', function() {
        return redirect()->route('platform.login');
    });

    // Payment gateway link
    Route::post('/midtrans-webhook', [MidtransController::class, 'handleWebhook'])->name('midtrans.webhook');

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

            // Route::get('/laporan-keuangan', Platform\LaporanKeuangan::class)
            //     ->name('platform.laporan-keuangan');

            Route::get('/logout', function() {
                Auth::logout();
                return redirect()->route('platform.login');
            })->name('platform.logout');
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
            return redirect()->route('perusahaan.buat-pesanan', ['subdomain' => request()->route('subdomain')]);
        })
        ->name('perusahaan.dashboard');           

        // Internal
        Route::middleware('perusahaan.admin.access')->group(function () {
            Route::get('/peran-user', Perusahaan\PeranUser::class)
                ->name('perusahaan.peran-user');

            Route::get('/kendaraan', Perusahaan\Kendaraan::class)
                ->name('perusahaan.kendaraan');

            Route::get('/counter', Perusahaan\Counter::class)
                ->name('perusahaan.counter');

            Route::get('/daftar-pesanan', Perusahaan\Pesanan::class)
                ->name('perusahaan.pesanan');

            Route::get('/daftar-muat', Perusahaan\DaftarMuat::class)
                ->name('perusahaan.daftar-muat');

            Route::get('/penjemputan', Perusahaan\Penjemputan::class)
                ->name('perusahaan.penjemputan');

            Route::get('/layanan', Perusahaan\Layanan::class)
                ->name('perusahaan.layanan');
        });

        Route::middleware('perusahaan.kurir.access')->group(function () {
            Route::get('/penugasan-kurir', Perusahaan\PenugasanKurir::class)
                ->name('perusahaan.penugasan-kurir');
        });

        // Customer
        Route::get('/buat-pesanan', Perusahaan\BuatPesanan::class)
            ->name('perusahaan.buat-pesanan');

        Route::get('/histori-pesanan', Perusahaan\HistoriPesanan::class)
            ->name('perusahaan.histori-pesanan');

        Route::get('/logout', function() {
            Auth::logout();
            return redirect()->route('perusahaan.login', ['subdomain' => request()->route('subdomain')]);
        })->name('perusahaan.logout');
    });
});
