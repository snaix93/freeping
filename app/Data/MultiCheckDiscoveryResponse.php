<?php

namespace App\Data;

use Illuminate\Support\Collection;

class MultiCheckDiscoveryResponse
{
    public bool $hasPing = false;

    public string $pingTarget;

    public bool $pingResolvable;

    public bool $hasPorts = false;

    public ?Collection $ports = null;

    public bool $hasWebChecks = false;

    public ?Collection $webChecks = null;

    public function __construct(public string $connect) { }

    public function setHasPing($hasPing): self
    {
        $this->hasPing = $hasPing;

        return $this;
    }

    public function setPingTarget(string $pingTarget): self
    {
        $this->pingTarget = $pingTarget;

        return $this;
    }

    public function pingResolvable(bool $isResolvable): self
    {
        $this->pingResolvable = $isResolvable;

        return $this;
    }

    public function setHasPorts(bool $hasPorts): self
    {
        $this->hasPorts = $hasPorts;

        return $this;
    }

    public function setPorts(Collection $ports): self
    {
        $this->ports = $ports;

        return $this;
    }

    public function setHasWebChecks(bool $hasWebChecks): self
    {
        $this->hasWebChecks = $hasWebChecks;

        return $this;
    }

    public function setWebChecks(Collection $webChecks): self
    {
        $this->webChecks = $webChecks;

        return $this;
    }
}
