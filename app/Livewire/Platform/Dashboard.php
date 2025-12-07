<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Dashboard\DashboardComponent;

class Dashboard extends DashboardComponent
{
    #[Layout('livewire.layouts.dashboard', [
        'title' => 'Platform Admin Dashboard',
        'links' => [
            
        ]
    ])]
    public function render()
    {
        return view('livewire.platform.dashboard');
    }
}
