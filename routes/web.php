<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'beranda'])->name('beranda');

Route::get('/tarif', [LandingController::class, 'tarif'])->name('tarif');

Route::get('/profil-perusahaan', [LandingController::class, 'profilPerusahaan'])->name('profil-perusahaan');

Route::get('/informasi-umum/{kategori?}', [LandingController::class, 'informasiUmum'])->name('informasi-umum');
