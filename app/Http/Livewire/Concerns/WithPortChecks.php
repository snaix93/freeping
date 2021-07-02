<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Livewire\Concerns;

use App\Support\Nmap\Nmap;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

trait WithPortChecks
{
    /**
     * Holds the ports the user has selected to include from the list we
     * determined as open via NMAP.
     *
     * @var array
     */
    public array $ports = [];

    public Collection $customPorts;

    protected ?Collection $preFetchedOpenPorts = null;

    public $includePorts = true;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->customPorts = collect();
    }

    public function rulesWithPortChecks()
    {
        return [
            'ports'         => [
                'array',
            ],
            'ports.*'       => [
                'sometimes',
                'integer',
                'distinct',
                'max:65535',
            ],
            'customPorts'   => [
                'array',
            ],
            'customPorts.*' => [
                'sometimes',
                'integer',
                'distinct',
                'max:65535',
                Rule::notIn($this->selectedPorts),
            ],
        ];
    }

    public function togglePortInclusion($port)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        // Defined as macro in AppServiceProvider.
        $this->ports = Arr::toggle($this->ports, $port);
    }

    public function getOpenPortsProperty(): Collection
    {
        if (! $this->pingTarget || $this->getErrorBag()->has('pingTarget')) {
            return collect();
        }

        if (! is_null($this->preFetchedOpenPorts)) {
            return $this->preFetchedOpenPorts;
        }

        return Nmap::create()->scan($this->pingTarget)->openPorts();
    }

    public function addCustomPort()
    {
        $this->syncInput('customPorts', $this->customPorts->put(Str::random(), ''));
    }

    public function messagesWithPortChecks()
    {
        return [
            'customPorts.*.integer'  => 'Port numbers must be integers.',
            'customPorts.*.distinct' => "Looks like you've entered a duplicate port.",
            'customPorts.*.not_in'   => "Looks like you've entered a duplicate port.",
        ];
    }

    public function validationAttributesWithPortChecks()
    {
        return [
            'customPorts.*' => 'custom port',
        ];
    }

    protected function setPreFetchedOpenPorts(?Collection $ports)
    {
        $this->preFetchedOpenPorts = $ports;
        $this->initOpenPorts();
    }

    public function updatedWithPortChecks($name)
    {
        if ($name === 'pingTarget') {
            $this->resetPortChecks();
            $this->initOpenPorts();
        }
    }

    public function resetPortChecks($resetOpenPorts = false)
    {
        if ($resetOpenPorts) {
            $this->reset('openPorts');
        }
        $this->reset('ports', 'customPorts', 'preFetchedOpenPorts');

        return $this;
    }

    public function initOpenPorts()
    {
        tap($this->openPorts)
            ->whenEmpty(fn() => $this->reset('ports'))
            ->whenNotEmpty(function ($openPorts) {
                $this->syncInput('ports',
                    $this->ports += $openPorts->map->number()->flip()->map(fn() => true)->all()
                );
            });
    }

    public function updatedCustomPorts()
    {
        $this->validateOnly('customPorts.*');
    }

    public function removeCustomPort($key)
    {
        $this->syncInput('customPorts', $this->customPorts->forget($key));
    }

    public function combinePorts(): Collection
    {
        return $this->selectedPorts
            ->merge($this->customPorts)->filter()->values()
            ->map(fn($port) => (int) $port)
            ->unique();
    }

    public function prepareForValidation($attributes)
    {
        $attributes['ports'] = array_keys($attributes['ports']);

        return $attributes;
    }

    public function getSelectedPortsProperty(): Collection
    {
        return collect($this->ports)->filter()->keys();
    }

    protected function displayPortCheck($display = true)
    {
        // Hard code to true as we always show the input form to allow custom ports.
        $this->includePorts = true;
    }
}
