<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Status Pesanan</h1>

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
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $status)
                        <tr>
                            <td>{{ $status->id }}</td>
                            <td>
                                <div class="badge badge-info">
                                    {{ $status->status }}
                                </div>
                            </td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn btn-primary" wire:click="openModalUpdate({{ $status->id }})">Edit</button>
                                <button class="btn btn btn-error" wire:click="openModalDelete({{ $status->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Status Pesanan</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $statuses->links('pagination.daisyui') }}
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
                <label class="label mb-2">Status Pesanan</label>
                <input type="text" class="input" placeholder="Status Pesanan" wire:model="status"/>
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
                    <i class="fa fa-close"></i>
                </button>
            </div>

            @error('delete') 
                <div class="alert alert-error mb-4 w-full">
                    {{ $message }}
                </div> 
            @enderror

            <input type="hidden" wire:model="id" />

            <p>Apa Anda yakin mau menghapus status pesanan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
        <div class="modal-backdrop" wire:click="closeModal"></div>
    </div>

</div>