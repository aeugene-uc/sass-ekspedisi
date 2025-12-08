<?php

namespace App\Livewire\Platform;

use App\Livewire\Platform\DashboardPlatformComponent;
use Livewire\Component;

class LaporanKeuangan extends DashboardPlatformComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.platform.laporan-keuangan', []);
    }
}
