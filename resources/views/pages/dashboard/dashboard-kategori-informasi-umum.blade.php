@extends('layouts.dashboard')

@section('modelName', 'Kategori Informasi Umum')

@section('table')
    <x-dashboard-table>
        <x-dashboard-thead>
            <x-dashboard-th>Id</x-dashboard-th>
            <x-dashboard-th>Kategori</x-dashboard-th>
        </x-dashboard-thead>

        @foreach($kategoriInformasiUmums as $kiu)
            <x-dashboard-tr :id="$kiu->id">
                <td class="text-muted" data-name="id">
                    {{ $kiu->id }}
                </td>
                <td class="text-muted" data-name="kategori">
                    {{ $kiu->kategori }}
                </td>
            </x-dashboard-tr>
        @endforeach
    </x-dashboard-table>
@endsection

@section('paginationLinksContent')
    {{ $kategoriInformasiUmums->onEachSide(0)->links('pagination.limit-5') }}
@endsection

@section('createModalBody')
    <x-modal-item-large label="Kategori">
        <input 
            type="text"
            class="form-control" 
            name="kategori" 
            placeholder="Kategori"
            value="{{ old('kategori') }}"
            required
        >
    </x-modal-item-large>
@endsection

@section('updateModalBody')
    <x-modal-item-large label="Kategori">
        <input 
            type="text"
            class="form-control" 
            name="kategori" 
            placeholder="Kategori"
            value="{{ old('kategori') }}"
            required
        >
    </x-modal-item-large>
@endsection