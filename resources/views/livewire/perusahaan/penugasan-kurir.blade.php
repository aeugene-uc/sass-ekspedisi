<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Penugasan Kurir</h1>

    <form class="flex gap-2" wire:submit.prevent="$refresh">
        <input type="text" class="input w-full" placeholder="Search" wire:model="daftarMuatQuery" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="flex items-center gap-2">
        Tipe Penugasan:
        <select class="select" wire:model.change="tipe">
            <option value="daftar_muat">Daftar Muat</option>
            <option value="penjemputan">Penjemputan</option>
        </select>
    </div>

    <div class="w-full mt-4">
        <div class="overflow-x-auto">
            <table class="table table-sm min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>
                            @if($tipe === 'daftar_muat')
                                Counter Asal
                            @elseif($tipe === 'penjemputan')
                                Counter Tujuan
                            @endif
                        </th>
                        <th>Tanggal Dibuat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($tipe === 'daftar_muat')
                        @foreach ($this->daftarMuats as $daftarMuat)
                            <tr>
                                <td>{{ $daftarMuat->id }}</td>
                                <td>{{ $daftarMuat->counter->nama }}</td>
                                <td>{{ $daftarMuat->tanggal_dibuat }}</td>
                                <td>
                                    <button class="btn btn-primary" wire:click="openModalLihatDetail({{ $daftarMuat->id }})">Lihat Detail</button>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($this->daftarMuats) === 0)
                            <tr>
                                <td colspan="4" class="p-10 text-center text-sm">Belum ada penugasan daftar muat.</td>
                            </tr>
                        @endif
                    @elseif($tipe === 'penjemputan')
                        @foreach ($this->penjemputans as $penjemputan)
                            <tr>
                                <td>{{ $penjemputan->id }}</td>
                                <td>{{ $penjemputan->counter->nama }}</td>
                                <td>{{ $penjemputan->tanggal_dibuat }}</td>
                                <td>
                                    <button class="btn btn-primary" wire:click="openModalLihatDetail({{ $penjemputan->id }})">Lihat Detail</button>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($this->penjemputans) === 0)
                            <tr>
                                <td colspan="4" class="p-10 text-center text-sm">Belum ada penugasan penjemputan.</td>
                            </tr>
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal {{ $modalLihatDetailVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-11/12 max-w-[90vw] max-h-[90vh] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">
                    Penugasan {{ $tipe === 'daftar_muat' ? 'Daftar Muat' : 'Penjemputan' }} {{ $detailId }}
                </h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalLihatDetail">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @if($detail)
                <div class="flex flex-col gap-2 text-sm mt-4">
                    <div class="flex gap-2 items-center">
                        <strong>Counter {{ $tipe == 'daftar_muat' ? 'Asal' : 'Tujuan' }}:</strong>
                        <span>{{ $detail->counter->nama }}</span>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Kendaraan:</strong>
                        <span>{{ $detail->kendaraan->plat_nomor }} - {{ $detail->kendaraan->jenis->jenis }}</span>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Daftar Kurir:</strong>
                        <span>{{ $detail->kurir->pluck('full_name')->join(', ') }}</span>
                    </div>

                    <div class="flex gap-2 items-center">
                        <strong>Tanggal Dibuat:</strong>
                        <span>{{ $detail->tanggal_dibuat }}</span>
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
                            @foreach ($detail->pesanan as $pesanan)
                                <tr>
                                    <td>{{ $pesanan->id }}</td>
                                    <td>{{ $pesanan->user->full_name }}
                                    <td>{{ $pesanan->alamat_destinasi }}</td>
                                    <td>{{ $pesanan->tanggal_terkirim ?? 'N/A' }}</td>
                                    <td>
                                        @if (isset($fotoTerkirim[$pesanan->id]))
                                            <img 
                                                src="{{ $fotoTerkirim[$pesanan->id]->temporaryUrl() }}" 
                                                alt="Logo" class="h-15 w-15 object-cover mb-4 cursor-pointer"
                                                wire:click="openModalGambar('{{ $fotoTerkirim[$pesanan->id]->temporaryUrl() }}')"
                                            >
                                        @elseif ($pesanan->foto_terkirim != null)
                                            <img 
                                                src="{{ asset('storage/images/pesanan/' . $pesanan->foto_terkirim) }}" 
                                                alt="Logo" class="h-15 w-15 object-cover mb-4 cursor-pointer"
                                                wire:click="openModalGambar('{{ asset('storage/images/pesanan/' . $pesanan->foto_terkirim) }}')"
                                            >
                                        @endif
                                        <input id="fotoTerkirim_{{ $pesanan->id }}" type="file" class="hidden" wire:model="fotoTerkirim.{{ $pesanan->id }}" />
                                        <button class="btn btn-primary btn-xs" type="button" x-on:click="document.querySelector('#fotoTerkirim_{{ $pesanan->id }}').click()">Unggah Foto</button>
                                    </td>
                                    <td>
                                        @php $kasus = $pesanan->bukuKasus()->whereNull('tanggal_selesai'); @endphp
                                        @if ($kasus->exists())
                                            @php $kasus = $kasus->first(); @endphp
                                            @if (isset($kasus->foto))
                                                <img 
                                                    src="{{ asset('storage/images/kasus/' . $kasus->foto) }}" 
                                                    alt="Logo" class="h-15 w-15 object-cover mb-4 cursor-pointer mb-2"
                                                    wire:click="openModalGambar('{{ asset('storage/images/kasus/' . $kasus->foto) }}')"
                                                >
                                            @endif
                                            
                                            <span class="badge badge-warning">
                                                {{ $kasus->first()->kasus }}
                                            </span>
                                        @else
                                            <button class="btn btn-primary btn-xs" wire:click="openModalTambahKasus({{ $pesanan->id }})">Tambah Kasus</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div> 

            @endif
        </div>
    </div>

    @if($tipe == 'daftar_muat')
        <div class="mt-2 flex justify-end">
            {{ $this->daftarMuats->links('pagination.daisyui') }}
        </div>
    @elseif($tipe == 'penjemputan')
        <div class="mt-2 flex justify-end">
            {{ $this->penjemputans->links('pagination.daisyui') }}
        </div>
    @endif  


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

    <div class="modal {{ $modalTambahKasusVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="buatKasus">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">Tambah Kasus</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalTambahKasus">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <div>
                <label class="label mb-2">Kasus</label>
                <input type="text" class="input w-full" placeholder="Kasus" wire:model="kasus_kasus" required />
            </div>

            <div>
                <label class="label mb-2">Foto</label>
                <input type="file" class="file-input w-full" wire:model="kasus_foto" required accept="image/*" />
            </div>

            <button class="btn w-full btn-primary mt-4" type="submit">Simpan</button>
        </form>
    </div>
</div>
