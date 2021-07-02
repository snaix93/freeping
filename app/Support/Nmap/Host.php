<?php

namespace App\Support\Nmap;

use Illuminate\Support\Collection;

class Host
{
    const STATE_UP = 'up';

    const STATE_DOWN = 'down';

    private Collection $ports;

    public function __construct(private string $state, ?Port ...$ports)
    {
        $this->ports = collect($ports);
    }

    public function state(): string
    {
        return $this->state;
    }

    public function ports(): Collection
    {
        return $this->ports;
    }

    public function openPorts(): Collection
    {
        return $this->ports->filter(fn($port) => $port->isOpen())->values();
    }

    public function closedPorts(): Collection
    {
        return $this->ports->filter(fn($port) => $port->isClosed())->values();
    }
}
