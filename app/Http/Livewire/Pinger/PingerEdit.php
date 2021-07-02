<?php

namespace App\Http\Livewire\Pinger;

use App\Actions\Target\UpdateTargetAction;
use App\Data\Pinger\UpdatePingerData;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithPortChecks;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Models\Port;
use App\Models\Target;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;

class PingerEdit extends Component
{
    use AuthorizesRequests, WithLiveWireTraitValidation, TrimAndNullEmptyStrings,
        WithRateLimiting, WithPortChecks;

    public ?Target $target = null;

    public $dialog = false;

    public function getSelectedPortsProperty(): Collection
    {
        return $this->target->ports->pluck('port');
    }

    public function render()
    {
        return view('livewire.pinger.edit');
    }

    public function update(UpdateTargetAction $updateTargetAction)
    {
        $this->rateLimit(8);
        $this->authorize('update', $this->target);
        $this->validate();

        $target = $updateTargetAction(new UpdatePingerData(
            target: $this->target,
            user: $this->user,
            ports: $this->combinePorts()->diff($this->target->ports->pluck('port'))->all(),
        ));

        $this->emitUp('pingerUpdated', $target->encodeId());

        $this->closeDialog();
    }

    public function removeImmutablePort(Port $port)
    {
        $port->delete();
        $this->target->refresh();
        $this->resetValidation();
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function closeDialog()
    {
        $this->dialog = false;
        $this->target->refresh();
        $this->resetValidation();
        $this->reset('customPorts');
    }
}
