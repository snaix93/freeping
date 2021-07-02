<?php

namespace App\Http\Livewire;

use App\Enums\EventOriginator;
use Illuminate\Contracts\Pagination\Paginator;
use Livewire\Component;
use Livewire\WithPagination;

class ProblemIndex extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $type = 'All';

    public $types = [];

    public function mount()
    {
        $this->fill([
            'types' => array_merge(['All' => 'All'], EventOriginator::asSelectArray()),
        ]);
    }

    public function updatingType()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.problem.index', [
            'problems' => $this->getProblems(),
        ]);
    }

    private function getProblems(): Paginator
    {
        return auth()->user()->problems()
            ->when($this->type !== 'All', fn($query) => $query->where('originator', $this->type))
            ->orderBy('created_at')
            ->paginate($this->perPage);
    }
}
