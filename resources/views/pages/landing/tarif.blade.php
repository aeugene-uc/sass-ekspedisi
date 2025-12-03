@extends('layouts.landing')

@section('title', 'Tarif - Abeka Transportation')

@section('content')
<section class="section-vert-p bg-light">
    <div class="container">
        <x-section-heading-and-container
            heading_1="Tarif"
            heading_2="Layanan"
        >
            <p class="lead text-muted">
                Kami menghadirkan harga yang kompetitif dan adil untuk setiap kilometer perjalanan barang Anda.
            </p>
        </x-landing.section-heading-and-container>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            @foreach ($layanan as $index => $item)
                <div class="col-12 col-md-6 col-lg-4 layanan-card {{ $index >= 5 ? 'd-none' : '' }}">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-orange fw-bold">{{ $item->judul }}</h5>
                            <hr class="my-2">
                            <p class="text-muted mb-1"><strong>Harga per Km:</strong> Rp {{ number_format($item->harga_per_km, 0, ',', '.') }}</p>
                            <p class="text-muted mb-1"><strong>Harga per Kg:</strong> Rp {{ number_format($item->harga_per_kg, 0, ',', '.') }}</p>
                            <p class="text-muted mb-1"><strong>Biaya Minimum:</strong> Rp {{ number_format($item->biaya_minimum, 0, ',', '.') }}</p>
                            <p class="text-muted mb-1"><strong>Berat Maks:</strong> {{ $item->berat_maks_kg }} kg</p>
                            <p class="text-muted mb-1"><strong>Volume Maks:</strong> {{ $item->volume_maks_m3 }} m³</p>
                            <p class="text-muted mb-0"><strong>Rasio Berat Volumetrik:</strong> {{ $item->berat_volumetrik_ratio }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <button id="lihatSemuaBtn" class="btn theme-button">Lihat Semua</button>
            <button id="tutupBtn" class="btn btn-outline-secondary d-none">Tutup Kembali</button>
        </div>
    </div>
</section>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lihatBtn = document.getElementById('lihatSemuaBtn');
        const tutupBtn = document.getElementById('tutupBtn');
        const cards = document.querySelectorAll('.layanan-card');

        lihatBtn.addEventListener('click', () => {
            cards.forEach((card, index) => {
                if (index >= 5) card.classList.remove('d-none'); 
            });
            lihatBtn.classList.add('d-none');
            tutupBtn.classList.remove('d-none');
        });

        tutupBtn.addEventListener('click', () => {
            cards.forEach((card, index) => {
                if (index >= 5) card.classList.add('d-none');
            });
            tutupBtn.classList.add('d-none');
            lihatBtn.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' }); //little animation for closing so that the card doesnt collapse
        });
    });
</script>
