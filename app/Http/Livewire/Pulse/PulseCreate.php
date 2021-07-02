<?php

namespace App\Http\Livewire\Pulse;

use App\Actions\Target\CreateTargetAction;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Http\Livewire\Concerns\WithRateLimiting;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class PulseCreate extends Component
{
    use AuthorizesRequests, TrimAndNullEmptyStrings, WithLiveWireTraitValidation,
        WithRateLimiting;

    public $dialog = false;

    protected $listeners = ['showCreate' => 'showCreate'];

    public function render()
    {
        return view('livewire.pulse.create');
    }

    public function updatedPingTarget()
    {
        $this->clearValidation();
        $this->validateOnly('pingTarget');
    }

    public function getWindowsCommand()
    {
        $pulseUrl = config('app.pulse_url');
        $download = config('app.url').'/download/pulse.ps1';
        $omcToken = $this->user->omc_token;

        return <<<EOT
           [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
           \$url="$download"
           Invoke-WebRequest -Uri \$url -OutFile "pulse.ps1"
           \$pulseUrl="$pulseUrl"
           \$token="$omcToken"
           powershell -ExecutionPolicy bypass .\pulse.ps1 -Install -PulseUrl \$pulseUrl -Token \$token
           del .\pulse.ps1
           EOT;
    }

    public function getLinuxCommand()
    {
        $pulseUrl = config('app.pulse_url');
        $download = config('app.url').'/download/pulse.sh';
        $omcToken = $this->user->omc_token;

        return <<<EOT
            curl -LO $download
            sudo sh ./pulse.sh -i -u $pulseUrl -t $omcToken
            rm ./pulse.sh
            EOT;
    }

    public function create(CreateTargetAction $createTargetAction)
    {
        dd('create');
        // $this->rateLimit(8);
        // $this->authorize('create', Target::class);
        // $this->validate();
        //
        // $target = $createTargetAction($this->user, new CreateTargetData(
        //     pingTarget: $this->pingTarget,
        //     ports: $this->combinePorts()->all(),
        // ));
        //
        // $this->reset('pingTarget');
        // $this->resetPortChecks(true);
        // $this->emitUp('pingerCreated', $target->encodeId());
        //
        // $this->dialog = false;
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }

    public function showCreate()
    {
        $this->dialog = true;
    }

    public function closeDialog()
    {
        $this->dialog = false;
        $this->reset();
        $this->resetValidation();
    }
}
