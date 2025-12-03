@extends('layouts.landing')

@section('title', 'Abeka Transportation')

@section('content')

<div class="jumbotron container-fluid position-relative">
  <div class="overlay position-absolute top-0 start-0 w-100 h-100"></div>

  <div class="container position-relative text-white text-center d-flex flex-column justify-content-center align-items-center h-100">
      <h1 class="fw-bold display-4">Solusi Terpercaya untuk Pengiriman Anda</h1>
      <p class="lead mt-3">
          Abeka Transportation — Mitra ekspedisi andalan sejak 1994, melayani pengiriman antar kota dengan aman dan tepat waktu.
      </p>
      <a href="#layanan" class="btn btn-lg theme-button">Pelajari Layanan Kami</a>
  </div>
</div>

<section class="section-vert-p bg-light" id="layanan">
    <div class="container">
        <x-section-heading-and-container 
            heading_1="DAFTAR" 
            heading_2="LAYANAN" 
        >
            <p class="text-muted">Kami menawarkan berbagai layanan pengiriman yang dirancang untuk memenuhi kebutuhan logistik Anda. Dari pengiriman reguler hingga layanan khusus, kami siap membantu Anda mengirimkan barang dengan aman dan tepat waktu.</p>
        </x-section-heading-and-container>
        <x-card-grid grid_id="layanan" :list="$layanan"  />
    </div>
</section>

<section class="section-vert-p">
    <div class="container">
        <x-section-heading-and-container 
            heading_1="Mengapa" 
            heading_2="Memilih Kami" 
        >
            <p>
                Kami percaya bahwa layanan pengiriman terbaik harus didukung oleh kualitas, kecepatan, dan kepercayaan. Berikut adalah empat alasan utama mengapa ABEKA Transportation adalah mitra logistik yang tepat untuk Anda :
            </p>
        </x-landiherdng.section-heading-and-container>
        
        <div class="row g-4">
            <x-mengapa-col
                number="1"
                title="Efisiensi Biaya dan Waktu Maksimal"
                body="Kami menjamin layanan pengiriman yang cepat tanpa mengorbankan dompet Anda dan kami berkomitmen untuk memberikan solusi logistik yang hemat biaya dengan tetap menjaga standar ketepatan waktu yang tinggi."
            />
            <x-mengapa-col 
                number="2"
                title="Kekuatan Tim Operasional yang Profesional"
                body="Di balik setiap pengiriman sukses adalah tim kami yang solid, terlatih, dan berdedikasi tinggi. Setiap anggota tim bekerja secara profesional untuk memastikan barang Anda ditangani dengan hati-hati dan keahlian terbaik."
            />
            <x-mengapa-col 
                number="3"
                title="Jaringan Luas dan Keandalan Regional"
                body="Kami telah membangun fokus operasional yang kuat di berbagai wilayah strategis, menawarkan jangkauan yang luas dan keandalan yang telah teruji di daerah tersebut."
            />
            <x-mengapa-col 
                number="4"
                title="Komitmen Penuh terhadap Keamanan"
                body="Kami menempatkan keamanan barang Anda sebagai prioritas utama dan kami sangat menjamin setiap paket diangkut dengan integritas penuh dan tiba di tujuan dalam kondisi utuh dan sesuai jadwal yang telah disepakati."
            />
        </div>
    </div>
</section>

<section class="section-vert-p bg-light">
    <div class="container">
        <x-section-heading-and-container 
            heading_1="Jangkauan" 
            heading_2="Layanan" 
        >
            <p class="text-muted">
                Dengan jaringan yang luas dan tim operasional yang profesional, kami siap melayani pengiriman Anda ke berbagai wilayah dengan efisiensi dan keandalan tinggi.
            </p>
        </x-section-heading-and-container>
        <x-card-grid grid_id="jangkauan" :list="$jangkauan"  />
    </div>
</section>

<div class="container-fluid">
    <x-contact-section />
</div>

@endsection

<style>
    .jumbotron {
        background-image: url('{{ asset('images/jumbotron-test.jpg') }}');
        background-size: cover;
        background-position: bottom;
        background-repeat: no-repeat;
        height: calc(100vh - 66px);
    }

    .jumbotron .overlay {
        background-color: rgba(0, 0, 0, 0.5);
    }
</style>



{{-- halo --}}