<div class="flex flex-col gap-4">
    <h1 class="text-3xl font-bold mb-4">Status Pesanan</h1>

    <form class="flex gap-2" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Search" wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-2xl">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $status)
                        <tr>
                            <td>{{ $status->id }}</td>
                            <td>
                                <div class="badge badge-info">
                                    {{ $status->status }}
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-ghost" disabled>Statik</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2 flex justify-end">
        {{ $statuses->links('pagination.daisyui') }}
    </div>
</div>