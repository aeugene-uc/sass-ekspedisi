<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Kendaraan</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Search" wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Plat Nomor</th>
                        <th>Jenis</th>
                        <th>Operasional</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kendaraans as $kendaraan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kendaraan->plat_nomor }}</td>
                            <td>{{ $kendaraan->jenis->jenis }}</td>
                            <td>{{ $kendaraan->operasional ? 'Ya' : 'Tidak' }}</td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn-primary" wire:click="openModalUpdate({{ $kendaraan->id }})">Edit</button>
                                <button class="btn btn-error" wire:click="openModalDelete({{ $kendaraan->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Kendaraan</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $kendaraans->links('pagination.daisyui') }}
    </div>

    <div class="modal {{ $modalSaveVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="save">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('save') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror
{{-- 
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}

            <input type="hidden" wire:model="id" />

            <div>
                <label class="label mb-2">Plat Nomor</label>
                <input type="text" class="input" placeholder="Plat Nomor" wire:model="plat_nomor"/>
            </div>

            <div>
                <label class="label mb-2">Operasional</label>
                <select class="select" wire:model="operasional">
                    <option value="1">
                        Ya
                    </option>
                    <option value="0">
                        Tidak
                    </option>
                </select>
            </div>
            
            <div>
                <label class="label mb-2">Jenis Kendaraan</label>
                <select class="select" wire:model="jenis_kendaraan_id">
                    @foreach ($jenis_kendaraans as $jenis_kendaraan)
                        <option 
                            value="{{ $jenis_kendaraan->id }}"
                        >
                            {{ $jenis_kendaraan->jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary w-full mt-4" type="submit">Simpan</button>
        </form>
    </div>

    <div class="modal {{ $modalDeleteVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="delete">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('delete') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <input type="hidden" wire:model="id" />

            <p>Apa Anda yakin mau menghapus kendaraan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>

</div>