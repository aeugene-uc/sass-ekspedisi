<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardPerusahaanComponent extends Component
{
    #[Layout('livewire.layouts.dashboard')]
    public function viewExtends($view, $viewData)
    {
        $subdomain = explode('.', request()->getHost())[0];

        return view($view, $viewData)
            ->layoutData([
                'title' => Perusahaan::where('subdomain', $subdomain)->first()->nama ?? 'Dashboard Perusahaan',
                'links' => [
                    'Peran User' => route('perusahaan.peran-user', ['subdomain' => $subdomain]),
                    // 'Laporan Keuangan' => route('platform.laporan-keuangan')
                ]
            ]);
    }
}
