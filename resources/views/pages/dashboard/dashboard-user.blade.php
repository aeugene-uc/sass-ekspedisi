@extends('layouts.dashboard')

@section('modelName', 'User')

@section('table')
    <x-dashboard-table>
        <x-dashboard-thead>
            <x-dashboard-th>Id</x-dashboard-th>
            <x-dashboard-th>Username</x-dashboard-th>
        </x-dashboard-thead>

        @foreach($users as $user)
            <x-dashboard-tr :id="$user->id">
                <td class="text-muted" data-name="id">
                    {{ $user->id }}
                </td>
                <td class="text-muted" data-name="username">
                    {{ $user->username }}
                </td>
            </x-dashboard-tr>
        @endforeach
    </x-dashboard-table>
@endsection

@section('paginationLinksContent')
    {{ $users->onEachSide(0)->links('pagination.limit-5') }}
@endsection

@section('createModalBody')
    <x-modal-item-small label="Username">
        <input 
            type="text"
            class="form-control" 
            name="username" 
            id="username" 
            placeholder="Username"
            pattern="^[a-zA-Z0-9_]+$" 
            minlength="3" 
            maxlength="20"
            value="{{ old('username') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Password">
        <input 
            type="password"
            class="form-control" 
            name="password" 
            placeholder="Password"
            minlength="6"
            required
        >
    </x-modal-item-small>
@endsection

@section('updateModalBody')
    <x-modal-item-small label="Username">
        <input 
            type="text"
            class="form-control" 
            name="username" 
            id="username" 
            placeholder="Username"
            pattern="^[a-zA-Z0-9_]+$" 
            minlength="3" 
            maxlength="20"
            value="{{ old('username') }}"
            required
        >
    </x-modal-item-small>
    <x-modal-item-small label="Password">
        <input 
            type="password"
            class="form-control" 
            name="password" 
            placeholder="Password"
            minlength="6"
        >
    </x-modal-item-small>
@endsection