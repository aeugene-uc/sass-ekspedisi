<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Buat Pesanan</h1>

    <ul class="steps mt-8 mb-8">
        <li class="step {{ $step >= 1 ? 'step-primary' : '' }}">Daftar Muatan</li>
        <li class="step {{ $step >= 2 ? 'step-primary' : '' }}">Tujuan</li>
        <li class="step {{ $step >= 3 ? 'step-primary' : '' }}">Asal</li>
        <li class="step {{ $step >= 4 ? 'step-primary' : '' }}">Checkout</li>
    </ul>

    <div class="w-full {{ $step == 1 ? 'block' : 'hidden' }}">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Berat</th>
                        <th>Dimensi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img 
                                    src="{{ $barang['foto'] }}" 
                                    alt="Foto Barang" class="h-15 w-15 object-cover cursor-pointer"
                                    wire:click="openModalGambar('{{ $barang['foto'] }}')"
                                >
                            </td>
                            <td>{{ $barang['berat'] }}g</td>
                            <td>
                                <p>
                                    Panjang: {{ $barang['panjang'] }}cm<br>
                                    Lebar: {{ $barang['lebar'] }}cm<br>
                                    Tinggi: {{ $barang['tinggi'] }}cm
                                </p>
                            </td>
                            <td>
                                <button class="btn btn-error" wire:click="openModalHapusBarang({{ $loop->index }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach

                    @if(count($barangs) == 0)
                        <tr>
                            <td colspan="4" class="p-10 text-center text-sm">Belum ada barang yang ditambahkan.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <button 
            class="btn w-full btn-primary mt-4" 
            wire:click="openModalTambahBarang"
            wire:loading.attr="disabled"
        >
            Tambah Barang
        </button>
    </div>

    <div class="w-full {{ $step == 2 ? 'block' : 'hidden' }}">
        <div class="flex flex-col gap-4">
            <div>
                <label class="label mb-2">Lokasi Tujuan:</label>

                <select class="select" wire:model.change="metode_destinasi_pengiriman">
                    <option value="1">Ambil di Counter</option>
                    <option value="2">Kirim ke Alamat</option>
                </select>
            </div>

            @if($metode_destinasi_pengiriman == 1)
                <div>
                    <label class="label mb-2">Counter Tujuan:</label>

                    <select class="select" wire:model.change="counter_tujuan">
                        @foreach( $counters as $counter )
                            <option value="{{ $counter->id }}">{{ $counter->nama }} - {{ $counter->alamat }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($metode_destinasi_pengiriman == 2)
                <form class="flex gap-2" wire:submit.prevent="cariAlamatTujuan">
                    <label class="label">Alamat Tujuan:</label>
                    <input 
                        type="text" 
                        class="input" 
                        placeholder="Masukkan alamat tujuan" 
                        wire:model="query_alamat_tujuan"
                    />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            @endif

            <div id="tujuan-map-container">
                <div id="tujuan-map" class="w-full h-96 rounded border" wire:ignore></div>
            </div>
        </div>
    </div>

    <div class="w-full {{ $step == 3 ? 'block' : 'hidden' }}">
        <div class="flex flex-col gap-4">
            <div>
                <label class="label mb-2">Lokasi Asal:</label>

                <select class="select" wire:model.change="metode_asal_pengiriman">
                    <option value="1">Dropoff di Counter</option>
                    <option value="2">Pick Up oleh Kurir</option>
                </select>
            </div>

            @if($metode_asal_pengiriman == 1)
                <div>
                    <label class="label mb-2">Counter Asal:</label>

                    <select class="select" wire:model.change="counter_asal">
                        @foreach( $counters as $counter )
                            @if ($counter->id != $counter_tujuan)
                                <option value="{{ $counter->id }}">{{ $counter->nama }} - {{ $counter->alamat }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            @endif

            @if($metode_asal_pengiriman == 2)
                <form class="flex gap-2" wire:submit.prevent="cariAlamatAsal">
                    <label class="label">Alamat Asal:</label>
                    <input 
                        type="text" 
                        class="input" 
                        placeholder="Masukkan alamat asal" 
                        wire:model="query_alamat_asal"
                    />
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            @endif

            <div id="asal-map-container">
                <div id="asal-map" class="w-full h-96 rounded border" wire:ignore></div>
            </div>
        </div>
    </div>

    <div class="w-full {{ $step == 4 ? 'block' : 'hidden' }}">
        <div id="pembayaran-gagal" class="w-full alert alert-error" style="display: none;">
            Pembayaran gagal. Silakan coba lagi.
        </div>

        <div class="mt-4">
            <label class="label mb-2">Pilih Layanan:</label>
            <select class="select" wire:model.change="layanan_id">
                @foreach( $layanans as $layanan )
                    <option value="{{ $layanan->id }}">{{ $layanan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Foto</th>
                        <th>Berat</th>
                        <th>Dimensi</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img 
                                    src="{{ $barang['foto'] }}" 
                                    alt="Foto Barang" class="h-15 w-15 object-cover cursor-pointer"
                                    wire:click="openModalGambar('{{ $barang['foto'] }}')"
                                >
                            </td>
                            <td>{{ $barang['berat'] }}g</td>
                            <td>
                                <p>
                                    Panjang: {{ $barang['panjang'] }}cm<br>
                                    Lebar: {{ $barang['lebar'] }}cm<br>
                                    Tinggi: {{ $barang['tinggi'] }}cm
                                </p>
                            </td>
                            <td>
                                Rp {{ number_format($total_biaya['biaya_barang'][$loop->index] ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="w-full flex justify-end mt-4">
            <p class="text-lg font-bold">
                Total Biaya: Rp {{ number_format($total_biaya['total_biaya'] ?? 0, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="w-full">
        <div class="mt-4 flex justify-end gap-2">
            @if($step > 1)
                <button class="btn btn-secondary" wire:click="$set('step', {{ $step - 1 }})">Kembali</button>
            @endif
            @if($step < 4)
                <button class="btn btn-primary" wire:click="$set('step', {{ $step + 1 }})" {{ count($barangs) === 0 ? 'disabled' : '' }}>Lanjut</button>
                {{-- <button class="btn btn-primary" wire:click="$set('step', {{ $step + 1 }})">Lanjut</button> --}}
            @else
                <button class="btn btn-primary" wire:click="checkout">Checkout</button>
            @endif
        </div>

        <x-dashboard.modal-lihat-gambar 
            :isOpen="$modalGambarOpen" 
            :src="$modalGambarSrc" 
        />

        <div class="modal {{ $modalHapusBarangOpen ? 'modal-open' : '' }}">
            <form class="modal-box w-96 max-w-[90vw]" wire:submit.prevent="hapusBarang">
                <div class="flex w-full justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Hapus Barang</h3>
                    <button class="cursor-pointer" type="button" wire:click="closeModal">
                        <i class="fa fa-close"></i>
                    </button>
                </div>

                <p>Apa Anda yakin mau menghapus barang ini?</p>

                <button class="btn btn-error w-full mt-4" type="submit">Hapus</button>
            </form>
        </div>

        <div class="modal {{ $modalBarangOpen ? 'modal-open' : '' }}">
            <form class="modal-box w-96 max-w-[90vw] flex flex-col gap-2" wire:submit.prevent="tambahBarang">
                <div class="flex w-full justify-between items-center">
                    <h3 class="text-lg font-bold">Tambah Barang</h3>
                    <button class="cursor-pointer" type="button" wire:click="closeModal">
                        <i class="fa fa-close"></i>
                    </button>
                </div>

                @error('save') 
                    <div class="alert alert-error mb-4 w-full">
                        {{ $message }}
                    </div> 
                @enderror

                @if ($errors->has('validation'))
                    <div class="alert alert-error">
                        {{ $errors->first('validation') }}
                    </div>
                @endif

                <div>
                    <label class="label mb-2">Berat (g)</label>
                    <input type="number" class="input" placeholder="Berat (g)" required min="1" step="1" wire:model="berat"/>
                </div>

                <div>
                    <label class="label mb-2">Panjang (cm)</label>
                    <input type="number" class="input" placeholder="Panjang (cm)" required min="1" step="1" wire:model="panjang"/>
                </div>

                <div>
                    <label class="label mb-2">Lebar (cm)</label>
                    <input type="number" class="input" placeholder="Lebar (cm)" required min="1" step="1" wire:model="lebar"/>
                </div>

                <div>
                    <label class="label mb-2">Tinggi (cm)</label>
                    <input type="number" class="input" placeholder="Tinggi (cm)" required min="1" step="1" wire:model="tinggi"/>
                </div>

                <div>
                    <label class="label mb-2">Foto Barang</label>
                    <input type="file" class="file-input" accept="image/*" required wire:model="foto" />
                </div>

                <button class="btn btn-primary w-full mt-4" type="submit" wire:loading.attr="disabled">Tambah Barang</button>
            </form>
        </div>
    </div>

    @script
    <script>
        let tujuanMap, tujuanMarker;
        let asalMap, asalMarker;

        window.init_tujuan_map = function init_tujuan_map() {
            const c = $wire.tujuan_lat_lng;
            if (!c) return;

            if (!tujuanMap) {
                tujuanMap = new maplibregl.Map({ container: "tujuan-map", style: 'https://api.maptiler.com/maps/streets/style.json?key={{ config('app.maptiler') }}', center: [c.lng, c.lat], zoom: 12 });
                tujuanMarker = new maplibregl.Marker().setLngLat([c.lng, c.lat]).addTo(tujuanMap);

                tujuanMap.on("click", e => {
                    if ($wire.metode_destinasi_pengiriman != 2) return;
                    tujuanMarker.setLngLat(e.lngLat);
                    $wire.set("tujuan_lat_lng", { lat: e.lngLat.lat, lng: e.lngLat.lng });
                });
            } else {
                tujuanMap.setCenter([c.lng, c.lat]);
                tujuanMarker.setLngLat([c.lng, c.lat]);
            }
        }

        window.init_asal_map = function init_asal_map() {
            const c = $wire.asal_lat_lng;
            if (!c) return;

            if (!asalMap) {
                asalMap = new maplibregl.Map({ container: "asal-map", style: 'https://api.maptiler.com/maps/streets/style.json?key={{ config('app.maptiler') }}', center: [c.lng, c.lat], zoom: 12 });
                asalMarker = new maplibregl.Marker().setLngLat([c.lng, c.lat]).addTo(asalMap);

                asalMap.on("click", e => {
                    if ($wire.metode_asal_pengiriman != 2) return;
                    asalMarker.setLngLat(e.lngLat);
                    $wire.set("asal_lat_lng", { lat: e.lngLat.lat, lng: e.lngLat.lng });
                });
            } else {
                asalMap.setCenter([c.lng, c.lat]);
                asalMarker.setLngLat([c.lng, c.lat]);
            }
        }

        function waitForElement(query) {
            return new Promise(resolve => {
                const checkExist = setInterval(() => {
                    if (document.querySelector(query)) {
                        clearInterval(checkExist);
                        resolve(document.querySelector(query));
                    }
                }, 100);
            });
        }

        $wire.$watch('tujuan_lat_lng', () => {
            waitForElement('#tujuan-map').then(() => {
                init_tujuan_map();
            });
        });
        $wire.$watch('asal_lat_lng', () => {
            waitForElement('#asal-map').then(() => {
                init_asal_map();
            });
        });

        $wire.watch('step', value => {
            if (value == 2) {
                waitForElement('#tujuan-map').then(() => {
                    console.log('Step tujuan map init');
                    init_tujuan_map();
                });
            } else if (value == 3) {
                waitForElement('#asal-map').then(() => {
                    console.log('Step asal map init');
                    init_asal_map();
                });
            }
        });

        $wire.watch('counter_tujuan', value => {
            console.log('counter_tujuan changed:', value);
        })

        $wire.watch('counter_asal', value => {
            console.log('counter_asal changed:', value);
        });

        $wire.watch('metode_asal_pengiriman', value => {
            if (value != 2) return;

            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                $wire.set('asal_lat_lng', { lat: lat, lng: lng });
            });
        });

        $wire.on('snapToken', snapToken => {
            snap.pay(snapToken[0], {
                onSuccess: function(result) {
                    alert('Pembayaran Berhasil!')
                    $wire.dispatchEvent('historiPesanan');
                },
                onPending: function(result) {
                },
                onError: function(result) {
                    document.getElementById('pembayaran-gagal').style.display = 'block';
                }
            });
        })
    </script>
    @endscript
</div>