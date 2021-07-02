<?php

namespace App\Http\Livewire\Pinger;

use App\Actions\Target\CreateTargetAction;
use App\Data\Pinger\CreateTargetData;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithPingCheck;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Http\Livewire\Concerns\WithPortChecks;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Models\Target;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PingerCreate extends Component
{
    use AuthorizesRequests, TrimAndNullEmptyStrings, WithLiveWireTraitValidation,
        WithRateLimiting, WithPortChecks, WithPingCheck;

    public $dialog = false;

    protected $listeners = ['showCreate' => 'showCreate'];

    public function render()
    {
        return view('livewire.pinger.create');
    }

    public function updatedPingTarget()
    {
        $this->clearValidation();
        $this->validateOnly('pingTarget');
    }

    public function create(CreateTargetAction $createTargetAction)
    {
        $this->rateLimit(8);
        $this->authorize('create', Target::class);
        $this->validate();

        $target = $createTargetAction($this->user, new CreateTargetData(
            pingTarget: $this->pingTarget,
            ports: $this->combinePorts()->all(),
        ));

        $this->reset('pingTarget');
        $this->resetPortChecks(true);
        $this->emitUp('pingerCreated', $target->encodeId());

        $this->dialog = false;
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function showCreate()
    {
        $this->dialog = true;
    }

    public function findPorts()
    {
        $this->validate();
    }

    public function closeDialog()
    {
        $this->dialog = false;
        $this->reset();
        $this->resetValidation();
    }
}
