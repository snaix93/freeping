<?php

namespace App\Http\Livewire\Concerns;

use Illuminate\Support\Str;

trait WithUTM
{
    public function mountWithUTM()
    {
        collect(request()->query() ?? [])
            ->filter(fn($item, $key) => Str::contains($key, 'utm'))
            ->whenNotEmpty(function ($query) {
                session(['utm' => $query]);
            });
    }
}
