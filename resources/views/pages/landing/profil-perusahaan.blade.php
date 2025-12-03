@extends("layouts.landing")

@section('title', 'Company Profile - Abeka Transportation')

@section('content')

<section class="section-vert-p bg-light">
    <div class="container">
        <x-section-heading-and-container
            heading_1="Profil"
            heading_2="Perusahaan"
        >
            <p class="lead text-muted">Abeka Transportation - Sejak 1994</p>
        </x-section-heading-and-container>

        {{-- <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-3 fw-bold mb-3">Profil</h1>
                <h1 class="display-3 fw-bold" style="color: #f15a25;">Perusahaan</h1>
                <div style="width: 100px; height: 4px; background-color: #f15a25;" class="my-4"></div>
                <p class="lead text-muted">Abeka Transportation - Sejak 1994</p>
            </div>

            {{-- <div class="col-lg-6 text-end position-relative">
                <div style="width: 150px; height: 150px; background-color: #f15a25; border-radius: 50%; opacity: 0.2; position: absolute; top: -50px; right: 50px;"></div>
                <div style="width: 100px; height: 100px; background-color: #f15a25; border-radius: 50%; opacity: 0.3; position: absolute; top: 60px; right: 0;"></div>
                <div style="width: 80px; height: 80px; background-color: #f15a25; border-radius: 50%; opacity: 0.2; position: absolute; top: 40px; right: 180px;"></div>
            </div> --}}

        {{-- </div> --}}
    </div>
</section>

<section class="section-vert-p">
    <div class="container">
        <div class="row align-items-center">
            <x-section-heading-and-container 
                heading_1="TENTANG" 
                heading_2="KAMI"
                :use_default_row="false"
            >
                <p class="text-muted mb-3">
                    Abeka Transportation hadir sebagai solusi logistik Anda, didirikan dengan satu tujuan utama: menyediakan layanan pengiriman barang yang Cepat, Handal, dan Terpercaya.
                    Kami memahami bahwa dalam dunia bisnis yang serba cepat, setiap pengiriman adalah janji, dan kami berkomitmen untuk memenuhi janji tersebut dengan integritas penuh.
                </p>

                <p class="text-muted mb-3">
                    Kami bangga memiliki tim yang berdedikasi dan berpengalaman, siap melayani berbagai kebutuhan logistik Anda, mulai dari pengiriman paket kecil hingga muatan besar. 
                    Dengan area operasional yang meliputi Surabaya, Tulungagung, dan Kediri, kami memastikan barang Anda sampai tujuan dengan aman dan tepat waktu.
                </p>
            </x-section-heading-and-container>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ asset('images/comp3_profile.jpg') }}" alt="Company Photo 1" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-vert-p bg-light">
    <div class="container">
        <div class="row align-items-center">
            {{-- <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold mb-4">VISI &<br><span style="color: #f15a25;">MISI</span></h2>
                <div style="width: 80px; height: 3px; background-color: #f15a25;" class="mb-4"></div>
                

            </div> --}}
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="position-relative">
                    <div style="width: 100px; height: 100px; background-color: #f15a25; border-radius: 50%; position: absolute; top: -45px; left: -45px; opacity: 0.2; z-index: 0;"></div>
                    <img src="{{ asset('images/comp2_profile.jpeg') }}" alt="Company Photo 2" class="img-fluid rounded shadow-lg position-relative" style="z-index: 1;">
                </div>
            </div>

            <x-section-heading-and-container 
                heading_1="VISI &" 
                heading_2="MISI"
                :use_default_row="false"
            >
                <h5 class="fw-bold mb-3">VISI</h5>
                <p class="text-muted mb-4">
                    Visi kami adalah menjadi perusahaan jasa pengiriman dan logistik terdepan dan terpercaya yang diakui secara luas atas keunggulan operasional dan
                    dedikasi tim yang solid dalam menciptakan solusi rantai pasok yang efisien. Kami bertekad untuk menjadi mitra logistik utama bagi
                    setiap pelanggan, memastikan bahwa setiap pengiriman dilakukan dengan kecepatan, keamanan, dan integritas tertinggi, sehingga turut mendukung
                    pertumbuhan bisnis dan perekonomian di seluruh wilayah operasional kami, khususnya di Jawa Timur.
                </p>
                
                <h5 class="fw-bold mb-3">MISI</h5>
                <ul class="text-muted">
                    <li class="mb-2">Layanan Utama : Menyediakan jasa pengiriman cepat, aman, dan terjangkau.</li>
                    <li class="mb-2">Tim Inti : Membangun tim yang profesional, solid, dan berdedikasi tinggi.</li>
                    <li class="mb-2">Jangkauan : Memperkuat jaringan di Surabaya, Tulungagung, dan Kediri</li>
                    <li class="mb-2">Integritas : Memastikan pengiriman barang tiba dalam kondisi utuh dan tepat waktu</li>
                </ul>
            </x-section-heading-and-container>
        </div>
    </div>
</section>

<section class="section-vert-p">
    <div class="container">
        <div class="row align-items-center">
            <x-section-heading-and-container heading_1="LAYANAN" heading_2="TERBAIK" :use_default_row="false">
                <p class="text-muted mb-3">
                    Abeka Transportation berdedikasi untuk menyediakan layanan pengiriman yang tidak hanya cepat tetapi juga terjangkau bagi seluruh pelanggan. 
                    Komitmen kami tercermin langsung dalam kepuasan pelanggan seperti Mr. Bayu, yang menyatakan, "Abeka Transportation adalah jasa pengiriman yang cepat dan harganya juga murah.
                    Senang sekali bisa pakai jasa pengiriman di sini.
                </p>

                <p class="text-muted mb-4">
                    Testimoni ini membuktikan bahwa kami berhasil menggabungkan efisiensi pengiriman dengan penetapan harga yang kompetitif, menjadikannya pilihan ideal untuk kebutuhan logistik Anda. 
                    Didukung oleh jaringan operasional yang mencakup wilayah seperti Surabaya dan Kediri, 
                    kami siap membantu pengiriman barang Anda dengan profesionalisme tinggi.
                </p>
                <a href="#contact" class="btn theme-button">Hubungi Kami</a>
            </x-section-heading-and-container>

            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('images/comp1_profile.jpg') }}" alt="Company Photo 3" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<div class="container-fluid bg-light">
    <x-contact-section />
</div>

@endsection

