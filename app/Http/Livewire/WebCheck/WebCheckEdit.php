<?php

namespace App\Http\Livewire\WebCheck;

use App\Actions\WebCheck\UpdateWebCheckAction;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Http\Livewire\Concerns\WithWebChecks;
use App\Models\WebCheck;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class WebCheckEdit extends Component
{
    use AuthorizesRequests, TrimAndNullEmptyStrings, WithRateLimiting,
        WithLiveWireTraitValidation, WithWebChecks;

    public ?WebCheck $webCheck = null;

    public $dialog = false;

    public function render()
    {
        return view('livewire.web-check.edit');
    }

    public function mount()
    {
        $this->prepWebCheck();
    }

    public function prepWebCheck()
    {
        $this->setWebChecks([
            (string) Str::orderedUuid() => [
                'url'             => $this->webCheck->url,
                'protocol'        => $this->webCheck->protocol,
                'host'            => $this->webCheck->host,
                'port'            => $this->webCheck->port,
                'path'            => $this->webCheck->path,
                'query'           => $this->webCheck->query,
                'fragment'        => $this->webCheck->fragment,
                'method'          => $this->webCheck->method,
                'expectedStatus'  => $this->webCheck->expected_http_status,
                'expectedPattern' => $this->webCheck->expected_pattern,
                'searchSource'    => $this->webCheck->search_html_source,
                'headers'         => $this->webCheck->headers,
            ],
        ]);
    }

    public function update(UpdateWebCheckAction $updateWebCheckAction)
    {
        $this->rateLimit(8);
        $this->authorize('update', $this->webCheck);
        $this->validate();

        $webCheck = $updateWebCheckAction(
            $this->webCheck,
            $this->buildWebCheckData(array_values($this->webChecks)[0])
        );

        $this->emitUp('webCheckUpdated', $webCheck->encodeId());

        $this->closeDialog();
    }

    public function closeDialog()
    {
        $this->dialog = false;
        $this->resetValidation();
    }

    public function updated()
    {
        $this->rebuildUrlForWebChecks();
    }

    public function getUserProperty(): Authenticatable
    {
        return auth()->user();
    }
}
