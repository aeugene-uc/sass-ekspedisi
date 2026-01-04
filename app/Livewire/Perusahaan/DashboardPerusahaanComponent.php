<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;
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
    
    public function logout() {
        Auth::logout();
        return redirect()->route('perusahaan.login', ['subdomain' => $this->subdomain]);
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
                        'Layanan' => route('perusahaan.layanan', ['subdomain' => $subdomain]),
                        'Daftar Pesanan' => route('perusahaan.pesanan', ['subdomain' => $subdomain]),
                        'Daftar Muat' => route('perusahaan.daftar-muat', ['subdomain' => $subdomain]),
                        'Penjemputan' => route('perusahaan.penjemputan', ['subdomain' => $subdomain]),
                        // 'Laporan Keuangan' => route('platform.laporan-keuangan')
                    ],
                    'Buat Pesanan' => route('perusahaan.buat-pesanan', ['subdomain' => $subdomain]),
                    'Histori Pesanan' => route('perusahaan.histori-pesanan', ['subdomain' => $subdomain])
                ]
            ]);
    }
}
