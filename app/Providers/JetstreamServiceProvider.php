<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Http\Livewire\NavigationMenu;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use Livewire\Livewire;

class JetstreamServiceProvider extends ServiceProvider
{
    public function register()
    {
        Livewire::component('navigation-menu', NavigationMenu::class);
    }

    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
