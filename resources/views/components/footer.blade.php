<footer class="bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <img src="{{ asset('images/logo-trans-white.png') }}" alt="Logo Abeka" class="mb-3" style="height: 50px;">
                <p class="text-body-secondary small">Layanan ekspedisi terpercaya untuk pengiriman Anda.</p>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Navigation</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{  route('beranda') }}" class="text-decoration-none text-body-secondary">Beranda</a></li>
                    <li class="mb-2"><a href="{{ route('tarif') }}" class="text-decoration-none text-body-secondary">Tarif</a></li>
                    <li class="mb-2"><a href="{{ route('informasi-umum') }}" class="text-decoration-none text-body-secondary">Informasi Umum</a></li>
                    <li class="mb-2"><a href="{{ route('profil-perusahaan') }}" class="text-decoration-none text-body-secondary">Profil Perusahaan</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Contact Us</h5>
                <div class="mb-3">
                    <p class="mb-2"><a href="mailto:aj_care@yahoo.com" class="text-decoration-none text-body-secondary">aj_care@yahoo.com</a></p>
                </div>
                <p class="mb-2 small"><strong>Telepon:</strong></p>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="tel:085223641947" class="text-decoration-none text-body-secondary">☎️ 0852-2364-1947 (Surabaya)</a></li>
                    <li class="mb-2"><a href="tel:085100798845" class="text-decoration-none text-body-secondary">☎️ 0851-0079-8845 (Tulungagung)</a></li>
                    <li class="mb-2"><a href="tel:082348090700" class="text-decoration-none text-body-secondary">☎️ 0823-4809-0700 (Kediri)</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">Follow Us</h5>
                <div class="d-flex gap-3">
                    <a href="https://www.instagram.com/abekatransportation/" target="_blank" class="text-light" style="font-size: 1.5rem;">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@AbekaTransportation" target="_blank" class="text-light" style="font-size: 1.5rem;">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="border-secondary mt-4 mb-3">

        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0 small text-body-secondary">&copy; {{ date("Y") }} Abeka Transportation. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<style>
    footer a:hover {
        color: #f15a25 !important;
        transition: color 0.3s ease;
    }

    footer .text-body-secondary {
        color: #adb5bd !important;
    }
</style>