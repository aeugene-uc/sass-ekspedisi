<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Perusahaan</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Search" wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>Logo</th>
                        <th>Subdomain</th>
                        <th>Link</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($perusahaans as $perusahaan)
                        <tr>
                            <td>{{ $perusahaan->id }}</td>
                            <td>{{ $perusahaan->nama }}</td>
                            <td>
                                @if ($perusahaan->logo)
                                    <img src="{{ asset('storage/images/perusahaan/' . $perusahaan->logo) }}" alt="Logo" class="h-15 w-15 object-cover">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $perusahaan->subdomain }}</td>
                            <td>
                                <a href="http://{{ $perusahaan->subdomain . '.' . config('app.domain') }}" target="_blank" class="link link-primary">
                                    Link
                                </a>
                            </td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn-primary" wire:click="openModalUpdate({{ $perusahaan->id }})">Edit</button>
                                <button class="btn btn-error" wire:click="openModalDelete({{ $perusahaan->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Perusahaan</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $perusahaans->links('pagination.daisyui') }}
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

            <input type="hidden" wire:model="id" />

            <div>
                <label class="label mb-2">Nama Perusahaan</label>
                <input type="text" class="input" placeholder="Nama Perusahaan" wire:model="nama"/>
            </div>

            <div>
                <label class="label mb-2">Subdomain</label>
                <input type="text" class="input" placeholder="Subdomain" wire:model="subdomain"/>
            </div>
            
            <div>
                <label class="label  mb-2">Logo Perusahaan</label>
                <input type="file" class="file-input"  class="mb-6" accept="image/*" wire:model="logo" />
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

            <p>Apa Anda yakin mau menghapus perusahaan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>

</div>