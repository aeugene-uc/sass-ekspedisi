<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Daftar Muat</h1>

    <form class="flex gap-2" wire:submit.prevent="$refresh">
        <input type="text" class="input w-full" placeholder="Search" wire:model="daftarMuatQuery" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-sm min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Selesai</th>
                        <th>Counter Asal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->daftarMuats as $daftarMuat)
                        <tr>
                            <td>{{ $daftarMuat->id }}</td>
                            <td>{{ $daftarMuat->tanggal_dibuat }}</td>
                            <td>{{ $daftarMuat->tanggal_selesai ?? 'N/A' }}</td>
                            <td>Counter {{ $daftarMuat->counter->nama }}</td>
                            <td>
                                <button class="btn btn-primary" wire:click="openModalDetailMuat({{ $daftarMuat->id }})">Lihat Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <button class="btn btn-primary mt-4 w-full">Buat Daftar Muat</button>
    </div>

    <div class="modal {{ $modalDetailMuatVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-11/12 max-w-[90vw] max-h-[90vh] flex flex-col gap-2" wire:submit.prevent="simpanDetailMuat">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalDetailMuat">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @if($dm)
                <div class="flex flex-col gap-2 text-sm mt-4">
                    <div class="flex gap-2 items-center">
                        <strong>Counter Asal:</strong>
                        <select class="select select-sm" wire:model="dm.counter_asal_id" wire:change="simpanDetailMuat">
                            @foreach($this->counters as $counter)
                                <option value="{{ $counter->id }}" wire:key="counter_asal_{{ $counter->id }}">{{ $counter->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Kendaraan:</strong>
                        <select class="select select-sm" wire:model="dm.kendaraan_id" wire:change="simpanDetailMuat">
                            @foreach($this->kendaraans as $kendaraan)
                                <option 
                                    value="{{ $kendaraan->id }}" 
                                    wire:key="kendaraan_{{ $kendaraan->id }}"
                                >{{ $kendaraan->jenis->jenis }} - {{ $kendaraan->plat_nomor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Daftar Kurir:</strong>
                        <span>{{ $dm->kurir->pluck('full_name')->join(', ') }}</span>
                        <button class="btn btn-primary btn-xs" wire:click="openModalAturKurir">Atur Kurir</button>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Tanggal Dibuat:</strong>
                        <span>{{ $dm->tanggal_dibuat }}</span>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Tanggal Selesai:</strong>
                        <span>{{ $dm->tanggal_selesai ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="w-full overflow-x-auto">
                    <table class="table table-xs w-full mt-4">
                        <thead>
                            <tr>
                                <th>Id Pesanan</th>
                                <th>Pemesan</th>
                                <th>Alamat Destinasi</th>
                                <th>Tanggal Terkirim</th>
                                <th>Foto Terkirim</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dm->pesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->id }}</td>
                                    <td>{{ $pesanan->user->full_name }}
                                    <td>{{ $pesanan->alamat_destinasi }}</td>
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
                                        <button class="btn btn-error btn-xs" wire:click="openModalHapusPesanan({{ $pesanan->id }})">Hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div> 

                <button class="btn btn-primary w-full mt-4" type="button" wire:click="openModalTambahPesanan">Tambah Pesanan</button>
            @endif
        </form>
    </div>

    <div class="modal {{ $modalTambahPesananVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-11/12 max-w-[90vw] max-h-[90vh] flex flex-col gap-2" wire:submit.prevent="simpanDetailMuat">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">Tambah Pesanan</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalTambahPesanan">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <div class="flex w-full gap-2">
                <input type="text" class="input w-full" placeholder="Search Pesanan" wire:model.change="pesananQuery" />
                <button type="button" class="btn btn-primary" wire:click="$refresh">Search</button>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="table table-xs w-full mt-2">
                    <thead>
                        <tr>
                            <th>Id Pesanan</th>
                            <th>Pemesan</th>
                            <th>Alamat Destinasi</th>
                            <th>Tanggal Terkirim</th>
                            <th>Foto Terkirim</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->allPesanans as $pesanan)
                            <tr>
                                <td>{{ $pesanan->id }}</td>
                                <td>{{ $pesanan->user->full_name }}
                                <td>{{ $pesanan->alamat_destinasi }}</td>
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
                                    <input type="checkbox" class="checkbox" value="{{ $pesanan->id }}" wire:model="dmPesanans" wire:key="{{ $pesanan->id }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div>

            <div class="mt-2 flex justify-end">
                {{ $this->allPesanans->links('pagination.daisyui') }}
            </div>

            <button class="btn btn-primary w-full mt-2" type="button" wire:click="tambahPesanan">Simpan</button>
        </form>
    </div>

    <div class="modal {{ $modalAturKurirVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] max-h-[90vh]" wire:submit.prevent="aturKurir">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Atur Kurir</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalAturKurir">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <div class="w-full overflow-x-auto">
                <table class="table table-sm w-full">
                    <tbody>
                        @foreach ($this->kurirs as $kurir)
                            <tr>
                                <td>{{ $kurir->full_name }}</td>
                                <td class="flex justify-end">
                                    <input type="checkbox" class="checkbox" value="{{ $kurir->id }}" wire:model="dmKurirs" wire:key="{{ $kurir->id }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>   
            </div> 

            <button class="btn btn-primary w-full mt-4" type="submit">Simpan</button>
        </form>
    </div>


    <div class="modal {{ $modalHapusPesananVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="hapusPesanan">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Hapus Barang dari Daftar Muat</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalHapusPesanan">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('delete') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <p>Apa Anda yakin mau menghapus pesanan ini dari daftar muat?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>

</div>
