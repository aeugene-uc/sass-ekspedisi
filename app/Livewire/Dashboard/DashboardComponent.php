<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

class DashboardComponent extends Component
{
    public $isSidebarOpen = false;

    public function openSidebar() {
        $this->isSidebarOpen = true;
    }
}
