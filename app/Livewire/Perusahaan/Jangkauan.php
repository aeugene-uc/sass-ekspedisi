<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;

class Jangkauan extends DashboardPerusahaanComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.jangkauan', []);
    }
}
