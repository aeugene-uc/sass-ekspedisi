<div>
    <h1 class="text-3xl font-bold mb-4">Manajemen Jangkauan Layanan</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Cari Jangkauan atau Perusahaan..." wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success mt-4">{{ session('message') }}</div>
    @endif

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama Jangkauan</th>
                        <th>Perusahaan Ekspedisi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jangkauans as $jangkauan)
                        <tr>
                            <td>{{ $jangkauan->id }}</td>
                            <td>{{ $jangkauan->nama }}</td>
                            <td>
                                <div class="badge badge-info">
                                    {{ $jangkauan->perusahaan->nama ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn-sm btn-primary" wire:click="openModalUpdate({{ $jangkauan->id }})">Edit</button>
                                <button class="btn btn-sm btn-error" wire:click="openModalDelete({{ $jangkauan->id }})">Hapus</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">
                                Data jangkauan tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Jangkauan Baru</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $jangkauans->links('pagination.daisyui') }}
    </div>

    <div class="modal {{ $modalSaveVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="save">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close">X</i> 
                </button>
            </div>

            @error('save') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <input type="hidden" wire:model="id" />

            <div>
                <label class="label mb-2">Nama Jangkauan</label>
                <input type="text" class="input input-bordered w-full" placeholder="Contoh: Jabodetabek, Nasional" wire:model="nama"/>
                @error('nama') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="label mb-2">Perusahaan Ekspedisi</label>
                <select class="select select-bordered w-full" wire:model="perusahaan_id">
                    <option value="">-- Pilih Perusahaan --</option>
                    @foreach($perusahaans as $perusahaan)
                        <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                    @endforeach
                </select>
                @error('perusahaan_id') <span class="text-error text-sm">{{ $message }}</span> @enderror
            </div>

            <button class="btn btn-primary w-full mt-4" type="submit">Simpan</button>
        </form>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>

    <div class="modal {{ $modalDeleteVisible ? 'modal-open' : '' }}">
        <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="delete">
            <div class="flex w-full justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-error">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModal">
                    <i class="fa fa-close">X</i>
                </button>
            </div>

            @error('delete') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <input type="hidden" wire:model="id" />

            <p>Apa Anda yakin mau menghapus jangkauan layanan ini? Tindakan ini tidak dapat dibatalkan.</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>

</div>