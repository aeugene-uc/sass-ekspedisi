<div>
    <h1 class="text-3xl font-bold mb-4">Daftar Status Pesanan</h1>

    <form class="flex gap-2 mb-4" wire:submit.prevent="search">
        <input type="text" class="input w-full" placeholder="Cari Status..." wire:model="query" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="w-full">
        <div class="overflow-x-auto">
            <table class="table table-xs min-w-full">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($statuses as $status)
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
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">
                                Tidak ada data status yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        {{ $statuses->links('pagination.daisyui') }}
    </div>
</div>