<?php

namespace App\Http\Livewire\WebCheck;

use App\Actions\WebCheck\CreateWebChecksAction;
use App\Actions\WebCheck\DiscoverWebChecks;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Http\Livewire\Concerns\WithWebChecks;
use App\Models\WebCheck;
use App\Rules\ResolvableConnectRule;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class WebCheckCreate extends Component
{
    use AuthorizesRequests, TrimAndNullEmptyStrings, WithRateLimiting,
        WithLiveWireTraitValidation, WithWebChecks;

    public $dialog = false;

    public $connect;

    protected $listeners = ['showCreate' => 'showCreate'];

    protected $validationAttributes = [
        'connect' => 'URL/FQDN',
    ];

    public function rules()
    {
        return [
            'connect' => [
                'required', 'string',
                new ResolvableConnectRule,
            ],
        ];
    }

    public function render()
    {
        return view('livewire.web-check.create');
    }

    public function discover()
    {
        $this->validate();
        $this->webChecks = [];
        $this->makeWebChecksFromUrls(resolve(DiscoverWebChecks::class)($this->connect));
    }

    public function create(CreateWebChecksAction $createWebChecksAction)
    {
        $this->rateLimit(8);
        $this->authorize('create', WebCheck::class);
        $this->validate();

        $createWebChecksAction($this->user, $this->buildCreateWebCheckDataCollection());

        $this->reset();
        $this->emitUp('webCheckCreated');

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

    public function closeDialog()
    {
        $this->dialog = false;
        $this->reset();
        $this->resetValidation();
    }
}
