<div class="flex flex-col gap-2">
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
        <div id="map" class="w-full h-96 rounded border" wire:ignore></div>
    </div>
</div>