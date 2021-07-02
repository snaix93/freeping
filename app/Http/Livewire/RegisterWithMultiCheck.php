<?php /** @noinspection PhpUnused */

namespace App\Http\Livewire;

use App\Actions\CreateMultiChecksAction;
use App\Actions\GetUserTimezoneData;
use App\Actions\MultiCheckDiscoveryAction;
use App\Actions\User\CreateOrUpdateUserAction;
use App\Data\Pinger\CreateTargetData;
use App\Data\User\CreateUserData;
use App\Http\Livewire\Concerns\HasTimePeriods;
use App\Http\Livewire\Concerns\HasTimezones;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithLiveWireTraitValidation;
use App\Http\Livewire\Concerns\WithPingCheck;
use App\Http\Livewire\Concerns\WithPortChecks;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Http\Livewire\Concerns\WithSpamChecks;
use App\Http\Livewire\Concerns\WithUTM;
use App\Http\Livewire\Concerns\WithWebChecks;
use App\Models\User;
use App\Rules\EmailRule;
use App\Rules\ResolvableConnectRule;
use App\Rules\UniqueConnectPerUserRule;
use App\Rules\ValidateGenericConnect;
use App\Rules\ValidTimePeriod;
use App\Rules\ValidTimeZoneRule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RegisterWithMultiCheck extends Component
{
    use AuthorizesRequests, WithSpamChecks, TrimAndNullEmptyStrings, WithRateLimiting,
        HasTimezones, HasTimePeriods, WithUTM, WithLiveWireTraitValidation,
        WithPingCheck, WithPortChecks, WithWebChecks;

    public $connect;

    public $email;

    public $time;

    public $timezone;

    public $terms;

    public $showResults = false;

    public $showHowItWorksVideo = false;

    protected $validationAttributes = [
        'connect' => 'IP/FQDN/URL',
    ];

    protected $messages = [
        'email.required' => 'The email address cannot be empty.',
    ];

    public function rules()
    {
        if (auth()->check()) {
            return [];
        }

        return [
            'email'    => [
                'required',
                new EmailRule,
            ],
            'time'     => [
                'required',
                'string',
                new ValidTimePeriod,
            ],
            'timezone' => [
                'required',
                'string',
                new ValidTimeZoneRule,
            ],
            'terms'    => [
                'required',
                'accepted',
            ],
        ];
    }

    public function mount()
    {
        $this->fill([
            'email'    => request('email', user()?->email),
            'timezone' => value($timezoneData = (resolve(GetUserTimezoneData::class)()))->timezone,
            'time'     => $timezoneData->currentTime->floorHour()->format('H:i'),
            'terms'    => true,
            'connect'  => null,
        ]);
    }

    public function render()
    {
        return view('public.livewire.register-with-multi-check');
    }

    public function discover($connect)
    {
        $this->connect = $connect;

        $this
            ->resetPingCheck()
            ->resetWebChecks()
            ->resetPortChecks();

        $multiCheckDiscovery = resolve(MultiCheckDiscoveryAction::class)($this->connect);

        $this->displayPingCheck($multiCheckDiscovery->hasPing);
        $this->displayPortCheck($multiCheckDiscovery->hasPorts);
        $this->displayWebCheck($multiCheckDiscovery->hasWebChecks);

        $this->setPingTarget($multiCheckDiscovery->pingTarget);
        $this->setPingResolvable($multiCheckDiscovery->pingResolvable);
        $this->makeWebChecksFromUrls($multiCheckDiscovery->webChecks);
        $this->setPreFetchedOpenPorts($multiCheckDiscovery->ports);

        $this->showResults = true;
    }

    public function save(
        CreateOrUpdateUserAction $createOrUpdateUserAction,
        CreateMultiChecksAction $createMultiChecksAction
    ) {
        $this->rateLimit(5);
        $this->authorize('user-country');
        $this->validate();
        $this->spamGuard();

        $createMultiChecksAction(
            user: user() ?? $createOrUpdateUserAction($this->buildCreateUserData()),
            targetData: $this->buildCreateTargetData(),
            webCheckDataCollection: $this->buildCreateWebCheckDataCollection(),
        );

        $this->reset('showResults', 'connect');
        $this->resetPingCheck();
        $this->resetPortChecks(true);
        $this->resetWebChecks();

        $this->emitSelf('notify-pinger-created');
        $this->dispatchBrowserEvent('reset');
    }

    private function buildCreateUserData(): User|CreateUserData
    {
        return new CreateUserData(
            email: $this->email,
            timezone: $this->timezone,
            time: $this->time,
        );
    }

    private function buildCreateTargetData(): CreateTargetData
    {
        return new CreateTargetData(
            pingTarget: $this->pingTarget,
            ports: $this->combinePorts()->all(),
        );
    }

    public function validateConnect()
    {
        try {
            $this->rateLimit(5);
            $this->authorize('user-country');
            $this->validate([
                'connect' => [
                    'required', 'string',
                    new ValidateGenericConnect,
                    new UniqueConnectPerUserRule(user()?->email ?? $this->email),
                    new ResolvableConnectRule,
                ],
            ]);

            $this->dispatchBrowserEvent('connect-valid', $this->connect);

        } catch (ValidationException $exception) {
            $this->dispatchBrowserEvent('connect-invalid', $this->connect);
            throw $exception;
        }
    }
}
