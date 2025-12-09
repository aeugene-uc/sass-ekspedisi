<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;

class StatusPesananIndex extends DashboardPerusahaanComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.status-pesanan', []);
    }
}
