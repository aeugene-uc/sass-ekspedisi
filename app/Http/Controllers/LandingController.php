<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriInformasiUmum;
use App\Models\Jangkauan;
use App\Models\Layanan;


class LandingController extends Controller
{
    public function profilPerusahaan() {
        return view('pages.landing.profil-perusahaan');
    }

    public function beranda() {
        return view('pages.landing.beranda');
    }

    public function tarif() {
        return view('pages.landing.tarif');
    }

    public function informasiUmum() {
        return view('pages.landing.informasi-umum');
    }
}
