<?php

namespace App\Http\Livewire;

class NavigationMenu extends \Laravel\Jetstream\Http\Livewire\NavigationMenu
{
    public function render()
    {
        return view('partials.navigation-menu');
    }
}
