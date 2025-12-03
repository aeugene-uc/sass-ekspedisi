@extends('layouts.dashboard')

@section('modelName', 'Informasi Umum')

@section('table')
    <x-dashboard-table>
        <x-dashboard-thead>
            <x-dashboard-th>Id</x-dashboard-th>
            <x-dashboard-th>Kategori</x-dashboard-th>
            <x-dashboard-th>Judul</x-dashboard-th>
            <x-dashboard-th>Isi</x-dashboard-th>
        </x-dashboard-thead>

        @foreach($informasiUmums as $iu)
            <x-dashboard-tr :id="$iu->id">
                <td class="text-muted" data-name="id">
                    {{ $iu->id }}
                </td>
                <td class="text-muted" data-name="kategori">
                    {{ $iu->kategori->kategori }}
                </td>
                <td class="text-muted" data-name="judul">
                    {{ $iu->judul }}
                </td>
                <td class="text-muted text-truncate" style="max-width: 200px;" data-name="isi">
                    {{ $iu->isi }}
                </td>
            </x-dashboard-tr>
        @endforeach
    </x-dashboard-table>
@endsection

@section('paginationLinksContent')
    {{ $informasiUmums->onEachSide(0)->links('pagination.limit-5') }}
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
    <x-modal-item-large label="Isi">
        <textarea 
            class="form-control" 
            name="isi" 
            placeholder="Isi"
            required
        >{{ old('isi') }}</textarea>
    </x-modal-item-large>
    <x-modal-item-large label="Kategori">
        <select 
            class="form-select"
            name="kategori_id"
            required
        >
            @foreach($kategoriInformasiUmums as $kiu)
                <option 
                    value="{{ $kiu->id }}"
                >
                    {{ $kiu->kategori }}
                </option>
            @endforeach
        </select>
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
    <x-modal-item-large label="Isi">
        <textarea 
            class="form-control" 
            name="isi" 
            placeholder="Isi"
            required
        >{{ old('isi') }}</textarea>
    </x-modal-item-large>
    <x-modal-item-large label="Kategori">
        <select 
            class="form-select"
            name="kategori_id"
            required
        >
            @foreach($kategoriInformasiUmums as $kiu)
                <option 
                    value="{{ $kiu->id }}"
                >
                    {{ $kiu->kategori }}
                </option>
            @endforeach
        </select>
    </x-modal-item-large>
@endsection