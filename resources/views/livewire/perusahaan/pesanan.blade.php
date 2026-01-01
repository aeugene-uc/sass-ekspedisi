<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Daftar Pesanan</h1>

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
                        <th>Id DM</th>
                        <th>Nama Pemesan</th>
                        <th>Jenis Layanan</th>
                        <th>Asal Pengiriman</th>
                        <th>Tujuan Pengiriman</th>
                        <th>Tarif</th>
                        <th>Tanggal Pesan</th>
                        <th>Tanggal Terkirim</th>
                        <th>Foto Terkirim</th>
                        <th>Status</th>
                        <th>Kasus</th>
                        <th>Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $pesanan)
                        {{-- @php dd($pesanan) @endphp --}}
                        <tr>
                            <td>{{ $pesanan->id }}</td>
                            <td>{{ $pesanan->daftar_muat_id ?? 'N/A' }}</td>
                            <td>{{ $pesanan->user->full_name }}</td>
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
                                    <span class="badge badge-warning">Kasus Pengiriman</span>
                                @else
                                    <select class="select">
                                        @foreach($statusPesanans as $status)
                                            <option value="{{ $status->id }}" wire:click="updateStatusPesanan({{ $pesanan->id }}, {{ $status->id }})" {{ $pesanan->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-primary min-w-[130px]" wire:click="openModalReadKasus({{ $pesanan->id }})">Lihat Kasus ({{ $pesanan->bukuKasus->where('tanggal_selesai', null)->count() }})</button>
                            </td>
                            <td>
                                <button class="btn btn-primary min-w-[130px]" wire:click="openModalReadBarang({{ $pesanan->id }})">Lihat Barang</button>
                            </td>
                        </tr>
                    @endforeach
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
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <img src="{{ $modalGambarSrc }}" alt="Gambar" class="w-full h-auto rounded">
        </div>
    </div>

    <div class="modal {{ $modalGambarVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-96 max-w-[90vw] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">Lihat Gambar</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalGambarToBarang">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <image src="{{ $modalGambarSrc }}" alt="Gambar" class="w-full h-auto rounded">
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
                                        alt="Foto Barang" class="h-15 w-15 object-cover"
                                        class="cursor-pointer"
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


    <div class="modal {{ $modalReadKasusVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-lg max-w-[90vw] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <div class="flex w-full">
                <input type="text" placeholder="Search" class="input w-full" wire:model.change="queryKasus" wire:input="openModalReadKasus({{ $modalPesananId }})" />
                {{-- <button class="btn btn-primary ml-2" wire:click="searchKasus">Search</button> --}}
            </div>
            
            <div class="flex-1 overflow-x-auto overflow-y-auto">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kasus</th>
                            <th>Foto</th>
                            <th>Selesai</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kasusPesanan as $kasus)
                            <tr>
                                <td>{{ $kasus->tanggal_dibuat }}</td>
                                <td>{{ $kasus->kasus }}</td>
                                <td>
                                    @if ($kasus->foto_kasus != null)
                                        <img 
                                            src="{{ asset('storage/images/kasus/' . $kasus->foto_kasus) }}" 
                                            alt="Foto Kasus" class="h-15 w-15 object-cover"
                                            class="cursor-pointer"
                                            wire:click="openModalGambar('{{ asset('storage/images/kasus/' . $kasus->foto_kasus) }}')"
                                        >
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($kasus->tanggal_selesai)
                                        {{ $kasus->tanggal_selesai }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="flex gap-2">
                                    <button class="btn btn-primary" wire:click="openModalUpdateKasus({{ $kasus->id }})">Edit</button>
                                    <button class="btn btn-error" wire:click="openModalDeleteKasus({{ $kasus->id }})">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button class="btn w-full btn-primary mt-4" wire:click="openModalCreateKasus">Tambah Kasus</button>
        </div>
    </div>

    <div class="modal {{ $modalCreateKasusVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="createKasus">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalCreateKasus">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <input type="hidden" wire:model="kasus_id"/>

            <div>
                <label class="label mb-2">Kasus</label>
                <input type="text" class="input w-full" placeholder="Kasus" wire:model="kasus_kasus"/>
            </div>

            <button class="btn w-full btn-primary mt-4" type="submit">Simpan</button>
        </form>
    </div>

    <div class="modal {{ $modalUpdateKasusVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="updateKasus">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalUpdateKasus">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <input type="hidden" wire:model="kasus_id"/>

            <div>
                <label class="label mb-2">Kasus</label>
                <input type="text" class="input w-full" placeholder="Kasus" wire:model="kasus_kasus"/>
            </div>

            <div>
                <label class="label mb-2">Selesai</label>
                <select class="select w-full" wire:model="kasus_selesai">
                    <option value="1">
                        Ya
                    </option>
                    <option value="0">
                        Tidak
                    </option>
                </select>
            </div>

            <button class="btn w-full btn-primary mt-4" type="submit">Simpan</button>
        </form>
    </div>

    <div class="modal {{ $modalDeleteKasusVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="deleteKasus">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalDeleteKasus">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('delete') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <input type="hidden" wire:model="kasus_id" />

            <p>Apa Anda yakin mau menghapus kendaraan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>
</div>