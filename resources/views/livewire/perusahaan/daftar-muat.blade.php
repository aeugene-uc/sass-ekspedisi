<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Daftar Muat</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Search" wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-sm min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Selesai</th>
                        <th>Counter Asal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarMuats as $daftarMuat)
                        <tr>
                            <td>{{ $daftarMuat->id }}</td>
                            <td>{{ $daftarMuat->tanggal_dibuat }}</td>
                            <td>{{ $daftarMuat->tanggal_selesai ?? 'N/A' }}</td>
                            <td>Counter {{ $daftarMuat->counter->nama }}</td>
                            <td>
                                <button class="btn btn-primary" wire:click="openModalDetailMuat({{ $daftarMuat->id }})">Lihat Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal {{ $modalDetailMuatVisible ? 'modal-open' : '' }}">
        <div class="modal-box w-11/12 max-w-[90vw] flex flex-col gap-2">
            <div class="flex w-full justify-between items-center">
                <h3 class="text-lg font-bold">{{ $modalTitle }}</h3>
                <button class="cursor-pointer" type="button" wire:click="closeModalDetailMuat">
                    <i class="fa fa-close"></i>
                </button>
            </div>

            <table class="table table-xs w-full">
                <thead>
                    <tr>
                        <th>Id Pesanan</th>
                        <th>Alamat Asal</th>
                        <th>Alamat Destinasi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($detailMuats as $detailMuat)
                        <tr>
                            <td>{{ $detailMuat->pesanan->id }}</td>
                            <td>{{ $detailMuat->pesanan->tujuan }}</td>
                            <td>{{ $detailMuat->pesanan->berat }}</td>
                            <td>{{ $detailMuat->pesanan->status }}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
        </div>
    </div>
</div>
