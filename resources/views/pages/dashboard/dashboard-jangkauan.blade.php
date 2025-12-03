@extends('layouts.dashboard')

@section('modelName', 'Jangkauan')

@section('table')
    <x-dashboard-table>
        <x-dashboard-thead>
            <x-dashboard-th>Id</x-dashboard-th>
            <x-dashboard-th>Lokasi</x-dashboard-th>
            <x-dashboard-th>Alamat</x-dashboard-th>
            <x-dashboard-th>Telepon</x-dashboard-th>
            <x-dashboard-th>Image</x-dashboard-th>
        </x-dashboard-thead>

        @foreach($jangkauans as $jangkauan)
            <x-dashboard-tr :id="$jangkauan->id">
                <td class="text-muted" data-name="id">
                    {{ $jangkauan->id }}
                </td>
                <td class="text-muted" data-name="lokasi">
                    {{ $jangkauan->lokasi }}
                </td>
                <td class="text-muted" data-name="alamat">
                    {{ $jangkauan->alamat }}
                </td>
                <td class="text-muted" data-name="telepon">
                    {{ $jangkauan->telepon }}
                </td>
                <td class="text-muted" data-name="image">
                    <img src="{{ asset('images/jangkauan/' . $jangkauan->image) }}">
                </td>
            </x-dashboard-tr>
        @endforeach
    </x-dashboard-table>
@endsection

@section('paginationLinksContent')
    {{ $jangkauans->onEachSide(0)->links('pagination.limit-5') }}
@endsection
@section('createModalBody')
    <x-modal-item-small label="Lokasi">
        <input 
            type="text"
            class="form-control" 
            name="lokasi" 
            placeholder="Lokasi"
            value="{{ old('lokasi') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Telepon">
        <input 
            type="phone"
            class="form-control" 
            name="telepon" 
            placeholder="Telepon"
            value="{{ old('telepon') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-large label="Alamat">
        <textarea 
            class="form-control" 
            name="alamat" 
            placeholder="Alamat"
            required
        >{{ old('alamat') }}</textarea>
    </x-modal-item-large>
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
    <x-modal-item-small label="Lokasi">
        <input 
            type="text"
            class="form-control" 
            name="lokasi" 
            placeholder="Lokasi"
            value="{{ old('lokasi') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Telepon">
        <input 
            type="phone"
            class="form-control" 
            name="telepon" 
            placeholder="Telepon"
            value="{{ old('telepon') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-large label="Alamat">
        <textarea 
            class="form-control" 
            name="alamat" 
            placeholder="Alamat"
            required
        >{{ old('alamat') }}</textarea>
    </x-modal-item-large>
    <x-modal-item-large label="Image">
        <input 
            type="file"
            class="form-control" 
            name="image" 
            accept="image/*"
        >
    </x-modal-item-large>
@endsection