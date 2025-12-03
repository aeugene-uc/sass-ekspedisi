@extends('layouts.dashboard')

@section('modelName', 'Layanan')

@section('table')
    <x-dashboard-table>
        <x-dashboard-thead>
            <x-dashboard-th>Id</x-dashboard-th>
            <x-dashboard-th>Judul</x-dashboard-th>
            <x-dashboard-th>Deskripsi</x-dashboard-th>
            <x-dashboard-th>Harga Per Km</x-dashboard-th>
            <x-dashboard-th>Harga Per Kg</x-dashboard-th>
            <x-dashboard-th>Biaya Minimum</x-dashboard-th>
            <x-dashboard-th>Berat Maks Kg</x-dashboard-th>
            <x-dashboard-th>Volume Maks M3</x-dashboard-th>
            <x-dashboard-th>Berat Volumetrik Ratio</x-dashboard-th>
            <x-dashboard-th>Image</x-dashboard-th>
        </x-dashboard-thead>

        @foreach($layanans as $layanan)
            <x-dashboard-tr :id="$layanan->id">
                <td class="text-muted" data-name="id">
                    {{ $layanan->id }}
                </td>
                <td class="text-muted" data-name="judul">
                    {{ $layanan->judul }}
                </td>
                <td class="text-muted text-truncate" data-name="deskripsi" style="max-width: 200px;">
                    {{ $layanan->deskripsi }}
                </td>
                <td class="text-muted" data-name="harga_per_km">
                    {{ $layanan->harga_per_km }}
                </td>
                <td class="text-muted" data-name="harga_per_kg">
                    {{ $layanan->harga_per_kg }}
                </td>
                <td class="text-muted" data-name="biaya_minimum">
                    {{ $layanan->biaya_minimum }}
                </td>
                <td class="text-muted" data-name="berat_maks_kg">
                    {{ $layanan->berat_maks_kg }}
                </td>
                <td class="text-muted" data-name="volume_maks_m3">
                    {{ $layanan->volume_maks_m3 }}
                </td>
                <td class="text-muted" data-name="berat_volumetrik_ratio">
                    {{ $layanan->berat_volumetrik_ratio }}
                </td>
                <td class="text-muted" data-name="image">
                    <img src="{{ asset('images/layanan/' . $layanan->image) }}">
                </td>
            </x-dashboard-tr>
        @endforeach
    </x-dashboard-table>
@endsection

@section('paginationLinksContent')
    {{ $layanans->onEachSide(0)->links('pagination.limit-5') }}
@endsection

@section('createModalBody')
    <x-modal-item-large label="Judul">
        <input 
            type="text"
            class="form-control" 
            name="judul" 
            placeholder="Judul"
            value="{{ old('judul') }}"
            required
        >
    </x-modal-item-large>
    <x-modal-item-large label="Deskripsi">
        <textarea 
            class="form-control" 
            name="deskripsi" 
            placeholder="Deskripsi"
            required
        >{{ old('deskripsi') }}</textarea>
    </x-modal-item-large>
    <x-modal-item-small label="Harga Per Km">
        <input 
            type="number"
            class="form-control" 
            name="harga_per_km" 
            placeholder="Harga Per Km"
            value="{{ old('harga_per_km') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Harga Per Kg">
        <input 
            type="number"
            class="form-control" 
            name="harga_per_kg" 
            placeholder="Harga Per Kg"
            value="{{ old('harga_per_kg') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Biaya Minimum">
        <input 
            type="number"
            class="form-control" 
            name="biaya_minimum" 
            placeholder="Biaya Minimum"
            value="{{ old('biaya_minimum') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Berat Maks Kg">
        <input 
            type="number"
            class="form-control" 
            name="berat_maks_kg" 
            placeholder="Berat Maks Kg"
            value="{{ old('berat_maks_kg') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Volume Maks M3">
        <input 
            type="number"
            class="form-control" 
            name="volume_maks_m3" 
            placeholder="Volume Maks M3"
            value="{{ old('volume_maks_m3') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Berat Volumetrik Ratio">
        <input 
            type="number"
            class="form-control" 
            name="berat_volumetrik_ratio" 
            placeholder="Berat Volumetrik Ratio"
            value="{{ old('berat_volumetrik_ratio') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-large label="Image">
        <input 
            type="file"
            class="form-control" 
            name="image" 
            accept="image/*"
            required
        >
    </x-modal-item-large>
@endsection

@section('updateModalBody')
    <x-modal-item-large label="Judul">
        <input 
            type="text"
            class="form-control" 
            name="judul" 
            placeholder="Judul"
            value="{{ old('judul') }}"
            required
        >
    </x-modal-item-large>
    <x-modal-item-large label="Deskripsi">
        <textarea 
            class="form-control" 
            name="deskripsi" 
            placeholder="Deskripsi"
            required
        >{{ old('deskripsi') }}</textarea>
    </x-modal-item-large>
    <x-modal-item-small label="Harga Per Km">
        <input 
            type="number"
            class="form-control" 
            name="harga_per_km" 
            placeholder="Harga Per Km"
            value="{{ old('harga_per_km') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Harga Per Kg">
        <input 
            type="number"
            class="form-control" 
            name="harga_per_kg" 
            placeholder="Harga Per Kg"
            value="{{ old('harga_per_kg') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Biaya Minimum">
        <input 
            type="number"
            class="form-control" 
            name="biaya_minimum" 
            placeholder="Biaya Minimum"
            value="{{ old('biaya_minimum') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Berat Maks Kg">
        <input 
            type="number"
            class="form-control" 
            name="berat_maks_kg" 
            placeholder="Berat Maks Kg"
            value="{{ old('berat_maks_kg') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Volume Maks M3">
        <input 
            type="number"
            class="form-control" 
            name="volume_maks_m3" 
            placeholder="Volume Maks M3"
            value="{{ old('volume_maks_m3') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Berat Volumetrik Ratio">
        <input 
            type="number"
            class="form-control" 
            name="berat_volumetrik_ratio" 
            placeholder="Berat Volumetrik Ratio"
            value="{{ old('berat_volumetrik_ratio') }}"
            min="1" step="any"
            required
        >
    </x-modal-item-small>
    <x-modal-item-large label="Image">
        <input 
            type="file"
            class="form-control" 
            name="image" 
            accept="image/*"
        >
    </x-modal-item-large>
@endsection
