<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class Banner extends Component
{
    public function render()
    {
        return view('livewire.admin.banner')->layout('components.layouts.admin');
    }
}
