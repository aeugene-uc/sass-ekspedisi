<?php

namespace App\Livewire\Platform;

use Livewire\Component;

class ComponentName extends DashboardPlatformComponent
{
    public function render()
    {
        return $this->viewExtends('livewire.platform.component-name');
    }
}
