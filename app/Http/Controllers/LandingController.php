<?php

namespace App\Http\Controllers;


class LandingController extends Controller
{
    public function tentangKami() {
        return view('pages.landing.tentang-kami');
    }

    public function beranda() {
        return view('pages.landing.beranda');
    }
}
