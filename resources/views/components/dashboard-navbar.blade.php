@props([
    'showLogin' => true
])

<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="{{  route('beranda') }}">
            <img src="{{ asset('images/logo-trans-white.png') }}" alt="Logo navbar Abeka" class="d-inline-block align-text-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse w-100 justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{  route('beranda') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tarif') }}">Tarif</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('informasi-umum') }}">Informasi Umum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profil-perusahaan') }}">Profil Perusahaan</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<style>    
    .navbar {
        padding: 0.5rem 1rem;
    }
    
    .navbar img {
        height: 40px;
    }

    .nav-link:hover {
        color: #f15a25 !important;
        transition: color 0.3s ease;
    }
</style>