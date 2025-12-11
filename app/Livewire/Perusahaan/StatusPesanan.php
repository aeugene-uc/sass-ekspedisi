<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StatusPesanan as StatusPesananModel;

class StatusPesanan extends Component
{
    use WithPagination;

    public $query = '';

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $statuses = StatusPesananModel::when($this->query, function($query) {
                $query->where('status', 'like', '%' . $this->query . '%');
            })
            ->paginate(10);

        return view('livewire.perusahaan.status-pesanan', compact('statuses'));
    }
}
