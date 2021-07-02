<?php

namespace App\Http\Livewire\Pulse;

use App\Http\Livewire\Concerns\HasDeleteableEntities;
use App\Models\Pulse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class PulseIndex extends Component
{
    use WithPagination, HasDeleteableEntities, AuthorizesRequests;

    public $perPage = 10;

    public ?int $selectedPulseId = null;

    public function render()
    {
        return view('livewire.pulse.index', [
            'pulses' => $this->getPulses(),
        ]);
    }

    private function getPulses(): Paginator
    {
        return auth()->user()->pulses()
            ->orderBy('hostname')
            ->paginate($this->perPage);
    }

    public function deleteEntity(int $entityId)
    {
        $pulse = Pulse::findByOId($entityId);

        $this->authorize('delete', $pulse);
        $pulse->delete();

        $this->resetDeleteProperties();
        $this->resetPage();
    }
}
