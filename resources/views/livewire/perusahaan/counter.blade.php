<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Counter</h1>

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
                        <th>Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($counters as $counter)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $counter->nama }}</td>
                            <td>{{ $counter->alamat }}</td>
                            <td class="inline-flex gap-2">
                                <button class="btn btn btn-primary" wire:click="openModalUpdate({{ $counter->id }})">Edit</button>
                                <button class="btn btn btn-error" wire:click="openModalDelete({{ $counter->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button class="btn w-full btn-primary mt-4" wire:click="openModalCreate">Tambah Counter</button>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $counters->links('pagination.daisyui') }}
    </div>

    <div class="modal {{ $modalSaveVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-2xl max-w-[90vw] flex flex-col gap-2">
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

            <form class="flex gap-2 w-full" wire:submit.prevent="geocodeAddress">
                <input type="text" class="input" placeholder="Cari Alamat" wire:model="alamat_query"/>
                <button class="btn btn-primary">Search</button>
            </form>

            <div x-data="
                    {
                        init() {
                            const defaultLat = {{ $lat ?? '-6.200000' }};
                            const defaultLng = {{ $lng ?? '106.816666' }};

                            const map = new maplibregl.Map({
                                container: 'map',
                                style: 'https://api.maptiler.com/maps/streets/style.json?key={{ config('app.maptiler') }}',
                                center: [defaultLng, defaultLat],
                                zoom: 12
                            });

                            let marker = new maplibregl.Marker({draggable: true})
                                .setLngLat([defaultLng, defaultLat])
                                .addTo(map);

                            map.on('click', (e) => {
                                marker.setLngLat(e.lngLat);
                                $wire.set('lat', e.lngLat.lat);
                                $wire.set('lng', e.lngLat.lng);
                            });

                            marker.on('dragend', () => {
                                const pos = marker.getLngLat();
                                $wire.set('lat', pos.lat);
                                $wire.set('lng', pos.lng);
                            });
                        }
                    }
                "
                x-init="init()"
            >
                <div id="map" class="w-full h-96 rounded border"></div>
            </div>

            <form class="flex flex-col gap-2 w-full" wire:submit.prevent="save">
                <input type="hidden" wire:model="id" />

                <div class="w-full flex flex-col">
                    <label class="label mb-2">Nama</label>
                    <input type="text" class="input" placeholder="Nama" wire:model="nama"/>
                </div>

                <button class="btn btn-primary w-full mt-4" type="submit">Simpan</button>
            </form>
        </div>
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

            <p>Apa Anda yakin mau menghapus counter ini?</p>

            <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
        </form>
    </div>

</div>