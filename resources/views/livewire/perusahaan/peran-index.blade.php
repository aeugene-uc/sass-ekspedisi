<div>
    @if (session()->has('message'))
        <div class="alert alert-success shadow-lg mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <h2 class="text-3xl font-bold mb-6">Manajemen Peran Pengguna</h2>

    <div class="flex justify-between items-center mb-6 p-4 bg-base-100 rounded-lg shadow-md">
        <div class="relative w-full max-w-sm mr-4">
             <input type="text" placeholder="Cari berdasarkan Nama Peran..." wire:model.live="query" class="input input-bordered w-full" />
             <button class="btn btn-warning absolute right-0 top-0 rounded-l-none" wire:click="search">Search</button>
        </div>
       
        <button wire:click="openModalCreate" class="btn btn-warning">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Tambah Peran Baru
        </button>
    </div>

    <div class="overflow-x-auto bg-base-100 p-4 rounded-lg shadow-md">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="text-lg">
                    <th>ID</th>
                    <th>Nama Peran</th>
                    <th>Admin Platform</th>
                    <th>Terikat Perusahaan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perusahaans as $peran) {{-- Menggunakan variabel 'perusahaans' dari render() --}}
                <tr>
                    <td>{{ $peran->id }}</td>
                    <td class="font-semibold">{{ $peran->nama }}</td>
                    <td>
                        <div class="badge {{ $peran->is_platform_admin ? 'badge-error' : 'badge-primary badge-outline' }}">
                            {{ $peran->is_platform_admin ? 'ADMIN' : 'STANDAR' }}
                        </div>
                    </td>
                    <td>
                        {{ $peran->perusahaan->nama ?? 'GLOBAL' }}
                    </td>
                    <td class="flex justify-center gap-2">
                        <button wire:click="openModalUpdate({{ $peran->id }})" class="btn btn-sm btn-warning">
                            Edit
                        </button>
                        <button wire:click="openModalDelete({{ $peran->id }})" class="btn btn-sm btn-error">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-gray-500">
                        <p class="text-lg">Data Peran tidak ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $perusahaans->links() }}
    </div>

    @if($modalSaveVisible)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-xl mb-4">{{ $modalTitle }}</h3>
                
                @error('save') 
                    <div class="alert alert-error mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <form wire:submit.prevent="save">
                    <div class="space-y-4">
                        
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Nama Peran</span></label>
                            <input type="text" wire:model.blur="nama" placeholder="Contoh: Manajer Keuangan" class="input input-bordered w-full @error('nama') input-error @enderror" />
                            @error('nama') <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                        </div>

                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Unggah Logo (Opsional)</span></label>
                            <input type="file" wire:model="logo" class="file-input file-input-bordered file-input-primary w-full @error('logo') input-error @enderror" />
                            <label class="label"><span class="label-text-alt">Abaikan jika tidak ingin mengubah logo.</span></label>
                            @error('logo') <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                            
                            <div wire:loading wire:target="logo" class="text-info mt-2">
                                Mengunggah...
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label cursor-pointer">
                                <span class="label-text font-medium">Peran Admin Platform? (Akses Global)</span> 
                                <input type="checkbox" wire:model.live="is_platform_admin" class="toggle toggle-error" />
                            </label>
                        </div>
                        
                        @if (!$is_platform_admin)
                        <div class="form-control w-full">
                            <label class="label"><span class="label-text font-medium">Terikat Pada Perusahaan</span></label>
                            <select wire:model.blur="perusahaan_id" class="select select-bordered w-full">
                                <option value="">-- Pilih Perusahaan (Default: Global) --</option>
                                {{-- Pastikan properti $perusahaans tersedia di komponen PHP --}}
                                @foreach($perusahaans as $perusahaan)
                                    <option value="{{ $perusahaan->id }}">{{ $perusahaan->nama }}</option>
                                @endforeach
                            </select>
                            @error('perusahaan_id') <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label> @enderror
                        </div>
                        @endif
                        
                    </div>
                    
                    <div class="modal-action">
                        <button type="button" wire:click="closeModal" class="btn btn-ghost">Batal</button>
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="save">Simpan Peran</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
            {{-- Background klik-di-luar --}}
            <div class="modal-backdrop" wire:click="closeModal"></div>
        </div>
    @endif
    
    @if($modalDeleteVisible)
        <div class="modal modal-open">
            <div class="modal-box">
                <h3 class="font-bold text-lg text-error">{{ $modalTitle }}</h3>
                <p class="py-4">Apakah Anda yakin ingin menghapus peran ini secara permanen?</p>
                
                @error('delete') 
                    <div class="alert alert-error mb-4">
                        {{ $message }}
                    </div>
                @enderror

                <div class="modal-action">
                    <button type="button" wire:click="closeModal" class="btn btn-ghost">Batal</button>
                    <button type="button" wire:click="delete" class="btn btn-error" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="delete">Hapus Permanen</span>
                        <span wire:loading wire:target="delete">Menghapus...</span>
                    </button>
                </div>
            </div>
             {{-- Background klik-di-luar --}}
            <div class="modal-backdrop" wire:click="closeModal"></div>
        </div>
    @endif
</div>