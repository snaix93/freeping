<?php

namespace App\Http\Livewire\SslCheck;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class SslCheckIndex extends Component
{
    use WithPagination, AuthorizesRequests;

    public $perPage = 10;

    public function render()
    {
        return view('livewire.ssl-check.ssl-check-index',[
            'sslChecks' => $this->getSslChecks()
        ]);
    }

    private function getSslChecks(): Paginator
    {
        return auth()->user()->sslChecks()
            ->orderBy('host')
            ->paginate($this->perPage);
    }
}
