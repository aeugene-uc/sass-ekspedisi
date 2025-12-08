<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardPlatformComponent extends Component
{
    #[Layout('livewire.layouts.dashboard')]
    public function viewExtends($view)
    {
        return view($view)
            ->layoutData([
                'title' => 'Platform Admin Dashboard',
                'links' => [
                    'Perusahaan' => route('platform.perusahaan'),
                    'Laporan Keuangan' => route('platform.laporan-keuangan'),
                    'Component Name' => route('platform.component-name')
                ]
            ]);
    }
}
