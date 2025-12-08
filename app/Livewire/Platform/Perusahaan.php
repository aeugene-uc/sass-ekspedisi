<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Platform\DashboardPlatformComponent;
use App\Models\Perusahaan as ModelsPerusahaan;
use Livewire\WithPagination;

class Perusahaan extends DashboardPlatformComponent
{
    use WithPagination;

    public function render()
    {
        return $this->viewExtends('livewire.platform.perusahaan', [
            'perusahaan' => ModelsPerusahaan::paginate(10)
        ]);
    }
}
