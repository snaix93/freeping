<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Livewire\Concerns;

use App\Rules\ResolvableConnectRule;
use App\Rules\UniquePingTargetPerUserRule;
use App\Rules\ValidatePingTarget;

trait WithPingCheck
{
    public $includePing = true;
    public $pingTarget;
    public $pingResolvable;

    public function rulesWithPingCheck()
    {
        $email = user()?->email ?? $this->email;

        return [
            'pingTarget' => [
                'required', 'string', 'max:253',
                new ValidatePingTarget,
                new UniquePingTargetPerUserRule($email),
                new ResolvableConnectRule,
            ],
        ];
    }

    public function validationAttributesWithPingCheck()
    {
        return [
            'pingTarget' => 'IP/FQDN',
        ];
    }

    public function resetPingCheck()
    {
        $this->reset('pingTarget', 'includePing');
        $this->resetValidation('pingTarget');

        return $this;
    }

    protected function displayPingCheck($display = true)
    {
        $this->includePing = $display;
    }

    protected function setPingTarget($pingTarget)
    {
        $this->syncInput('pingTarget', $pingTarget);
    }

    protected function setPingResolvable($pingResolvable)
    {
        $this->syncInput('pingResolvable', $pingResolvable);
    }
}
