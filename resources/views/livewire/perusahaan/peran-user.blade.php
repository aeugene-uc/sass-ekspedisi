<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Peran User</h1>

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
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>Peran Saat ini</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="badge badge-warning">
                                    {{ $user->peran->nama ?? 'Tidak ada Peran' }}
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-primary" wire:click="openModalUpdate({{ $user->id }})">Ubah Peran</button>
                            </td>
                        </tr>
                        {{-- @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">Data pengguna tidak ditemukan</td>
                            </tr> --}}
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-2 flex justify-end">
            {{ $users->links('pagination.daisyui') }}
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

                {{-- <div>
                    <label class="label mb-2">Pengguna yang diubah</label>
                    <input type="text" class="input input-bordered w-full" value="{{ $name }}"disabled />
                </div> --}}

                <div>
                    <label class="label  mb-2">Pilih Peran</label>
                    <select class="select select-bordered w-full" wire:model="peran_id">
                        @foreach ($perans as $peran)
                            <option value="{{ $peran->id }}">{{ $peran->nama }}</option>
                        @endforeach
                    </select>
                    @error('peran_id')
                        <span class="text-error text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button class="btn btn-primary w-full mt-4" type="submit">Simpan</button>
            </form>
        </div>
        </form>
    </div>
</div>
