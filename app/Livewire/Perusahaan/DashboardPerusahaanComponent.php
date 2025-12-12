<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardPerusahaanComponent extends Component
{
    public $modalSaveVisible = false;
    public $modalDeleteVisible = false;
    
    public $modalTitle = '';
    public $query;
    public $subdomain;
    
    public function mount() {
        $this->subdomain = request()->route('subdomain');
    }

    public function search() {
        $this->resetPage();
    }
    
    #[Layout('livewire.layouts.dashboard')]
    public function viewExtends($view, $viewData)
    {
        $subdomain = $this->subdomain;

        return view($view, $viewData)
            ->layoutData([
                'title' => Perusahaan::where('subdomain', $subdomain)->first()->nama ?? 'Dashboard Perusahaan',
                'links' => [
                    'Internal' => [
                        'Peran User' => route('perusahaan.peran-user', ['subdomain' => $subdomain]),
                        'Kendaraan' => route('perusahaan.kendaraan', ['subdomain' => $subdomain]),
                        'Counter' => route('perusahaan.counter', ['subdomain' => $subdomain]),
                        'Jangkauan' => route('perusahaan.jangkauan', ['subdomain' => $subdomain]),
                        'Daftar Pesanan' => route('perusahaan.pesanan', ['subdomain' => $subdomain]),
                        // 'Layanan' => route('perusahaan.layanan', ['subdomain' => $subdomain]),
                        // 'Laporan Keuangan' => route('platform.laporan-keuangan')
                    ]
                ]
            ]);
    }
}
