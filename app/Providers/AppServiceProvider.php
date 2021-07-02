<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        Arr::macro('toggle', function (array $array, $key) {
            data_set($array, $key, ! data_get($array, $key));

            return $array;
        });
    }

    public function boot()
    {
        View::share('cloudradarLink',
            'https://www.cloudradar.io/?utm_source=freeping.io&utm_campaign=freeping-startpage'
        );

        Builder::macro('toFullSql', function () {
            // Replace all % with !@£ before vsprintf runs, then change back
            $sql = str_replace(['%'], ['!@£'], $this->toSql());
            $sql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $this->getBindings());

            return str_replace(['!@£'], ['%'], $sql);
        });
        \Illuminate\Database\Query\Builder::macro('toFullSql', function () {
            // Replace all % with !@£ before vsprintf runs, then change back
            $sql = str_replace(['%'], ['!@£'], $this->toSql());
            $sql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $this->getBindings());

            return str_replace(['!@£'], ['%'], $sql);
        });

        Builder::macro('ddFullSql', function () {
            dd($this->toFullSql());
        });
        \Illuminate\Database\Query\Builder::macro('ddFullSql', function () {
            dd($this->toFullSql());
        });
    }
}
