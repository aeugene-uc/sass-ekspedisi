<?php

namespace App\Livewire\Perusahaan;

use App\Livewire\Perusahaan\DashboardPerusahaanComponent;
use Livewire\Component;

class PeranUser extends DashboardPerusahaanComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.peran-user', []);
    }
}
