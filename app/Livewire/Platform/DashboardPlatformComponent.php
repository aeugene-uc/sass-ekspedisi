<?php

namespace App\Livewire\Platform;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardPlatformComponent extends Component
{
    public $modalSaveVisible = false;
    public $modalDeleteVisible = false;

    public $modalTitle;
    public $query;

    public function search() {
        $this->resetPage();
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('platform.login');
    }

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
