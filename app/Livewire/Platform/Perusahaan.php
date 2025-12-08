<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Dashboard\DashboardComponent;

class Perusahaan extends DashboardComponent
{
    #[Layout('livewire.layouts.dashboard')]
    public function render()
    {
        return view('livewire.platform.perusahaan')
            ->layoutData([
                'title' => 'Platform Admin Dashboard',
                'links' => [
                    'Perusahaan' => route('platform.perusahaan')
                ]
            ]);
    }
}
