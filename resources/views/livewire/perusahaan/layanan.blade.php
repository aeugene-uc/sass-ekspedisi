<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Layanan</h1>

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
                        <th>Nama</th>
                        <th>Model Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($layanans as $layanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $layanan->nama }}</td>
                            <td>{{ $layanan->model_harga }}</td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn-primary" wire:click="openModalUpdate({{ $layanan->id }})">Edit</button>
                                <button class="btn btn-error" wire:click="openModalDelete({{ $layanan->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Layanan</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $layanans->links('pagination.daisyui') }}
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
                <label class="label mb-2">Nama</label>
                <input type="text" class="input" placeholder="Nama" wire:model="nama" required/>
            </div>

            <div>
                <label class="label mb-2">Model Harga</label>
                <textarea class="textarea" placeholder="Model Harga" wire:model="model_harga" required></textarea>
            </div>

            <div class="text-sm space-y-2">
                <div>
                    <p>Variabel yang dapat digunakan dalam model harga:</p>

                    <ul class="list-disc list-inside">
                        <li><code>berat</code>: Berat dalam gram</li>
                        <li><code>volume</code>: Volume dalam cm³</li>
                        <li><code>jarak</code>: Jarak dalam km</li>
                    </ul>
                </div>

                <div>
                    <p>Contoh penggunaan variabel dalam model harga:</p>
                    <input class="input input-bordered w-full" readonly value="berat * volume * jarak">
                </div>

                <div>
                    <p>Lihat selengkapnya di <a href="https://symfony.com/doc/current/components/expression_language.html" class="link link-primary" target="_blank">dokumentasi Symfony Expression Language</a>.</p>
                </div>
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

            <p>Apa Anda yakin mau menghapus layanan ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>
</div>