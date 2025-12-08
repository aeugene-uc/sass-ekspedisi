<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardPlatformComponent extends Component
{
    #[Layout('livewire.layouts.dashboard')]
    public function viewExtends($view, $viewData)
    {
        return view($view, $viewData)
            ->layoutData([
                'title' => 'Platform Admin Dashboard',
                'links' => [
                    'Perusahaan' => route('platform.perusahaan'),
                    'Laporan Keuangan' => route('platform.laporan-keuangan')
                ]
            ]);
    }
}
