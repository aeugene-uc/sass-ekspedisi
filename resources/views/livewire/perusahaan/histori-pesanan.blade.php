<div class="flex flex-col gap-4">
    <div id="pembayaran-gagal" class="w-full alert alert-error" style="display: none;">
        Pembayaran gagal. Silakan coba lagi.
    </div>

    <h1 class="text-3xl font-bold mb-4">Histori Pesanan</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Search" wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-sm min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Jenis Layanan</th>
                        <th>Asal Pengiriman</th>
                        <th>Tujuan Pengiriman</th>
                        <th>Tarif</th>
                        <th>Tanggal Pesan</th>
                        <th>Tanggal Terkirim</th>
                        <th>Foto Terkirim</th>
                        <th>Status</th>
                        <th>Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $pesanan)
                        {{-- @php dd($pesanan) @endphp --}}
                        <tr>
                            <td>{{ $pesanan->id }}</td>
                            <td>{{ $pesanan->layanan->nama }}</td>
                            <td>{{ $pesanan->metode_asal_pengiriman_id == 1 ? 'Counter ' . $pesanan->asalCounter->nama : $pesanan->alamat_asal }}</td>
                            <td>{{ $pesanan->metode_destinasi_pengiriman_id == 1 ? 'Counter ' . $pesanan->destinasiCounter->nama : $pesanan->alamat_destinasi }}</td>
                            <td>{{ 'Rp '. number_format($pesanan->tarif, 0, ',', '.') }}</td>
                            <td>{{ $pesanan->tanggal_pemesanan }}</td>
                            <td>{{ $pesanan->tanggal_terkirim ?? 'N/A' }}</td>
                            <td>
                                @if ($pesanan->foto_terkirim != null)
                                    <img 
                                        src="{{ asset('storage/images/pesanan/' . $pesanan->foto_terkirim) }}" 
                                        alt="Logo" class="h-15 w-15 object-cover"
                                        class="cursor-pointer"
                                        wire:click="openModalGambar('{{ asset('storage/images/pesanan/' . $pesanan->foto_terkirim) }}')"
                                    >
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                {{-- If Pesanan has bukuKasus where tanggal_selesai is not null --}}
                                @if ($pesanan->bukuKasus->where('tanggal_selesai', null)->count() > 0)
                                    <span class="badge badge-warning">
                                        {{ $pesanan->bukuKasus->where('tanggal_selesai', null)->first()->kasus }}
                                    </span>
                                @else
                                    {{ $pesanan->status->status }}

                                    @if($pesanan->status->id == 1)
                                        <br><br>
                                        <a class="link link-primary" href="{{ $pesanan->midtrans_snap }}">Bayar Sekarang</a>
                                        <br><br>
                                        <a class="link link-primary" wire:click="openModalBatalTransaksi({{ $pesanan->id }})">Batalkan Pesanan</a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary min-w-[130px]" wire:click="openModalReadBarang({{ $pesanan->id }})">Lihat Barang</button>
                            </td>
                        </tr>
                    @endforeach

                    @if(count($pesanans) == 0)
                        <tr>
                            <td colspan="10" class="p-10 text-center text-sm">Belum ada pesanan yang ditambahkan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $pesanans->links('pagination.daisyui') }}
    </div>

    <div class="modal {{ $modalGambarVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-96 max-w-[90vw] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">Lihat Gambar</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalGambar">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <img src="{{ $modalGambarSrc }}" alt="Gambar" class="w-full h-auto rounded">
        </div>
    </div>

    <div class="modal {{ $modalReadBarangVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-lg max-w-[90vw] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalReadBarang">
                    <i class="fa fa-close"></i>
                </button>
            </div> 
            
            <div class="flex-1 overflow-x-auto overflow-y-auto">
                <table class="table table-sm w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Berat (g)</th>
                            <th>Dimensi (cm<sup>3</sup>)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangPesanan as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img 
                                        src="{{ asset('storage/images/barang/' . $barang->foto) }}" 
                                        alt="Foto Barang" class="h-15 w-15 object-cover cursor-pointer"
                                        wire:click="openModalGambar('{{ asset('storage/images/barang/' . $barang->foto) }}')"
                                    >
                                </td>
                                <td>{{ $barang->berat_g }}g</td>
                                <td>{{ $barang->panjang_cm }}x{{ $barang->lebar_cm }}x{{ $barang->tinggi_cm }} cm<sup>3</sup></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal {{ $modalBatalTransaksiVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="batal">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('batal') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <p>Apa Anda yakin mau membatalkan pesanan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Batalkan</button>
        </form>
    </div>

    @script
    <script>
        $wire.on('snapToken', snapToken => {
            snap.pay(snapToken[0], {
                onSuccess: function(result) {
                    document.getElementById('pembayaran-gagal').style.display = 'hidden';
                    window.location.reload();
                },
                onPending: function(result) {
                },
                onError: function(result) {
                    document.getElementById('pembayaran-gagal').style.display = 'block';
                }
            });
        })
    </script>
    @endscript
</div>
