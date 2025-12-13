<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;

class BuatPesanan extends DashboardPerusahaanComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.buat-pesanan', []);
    }
}
