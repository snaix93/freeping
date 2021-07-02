<?php

namespace App\Support\Nmap;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Port implements Arrayable
{
    const STATE_OPEN = 'open';

    const STATE_CLOSED = 'closed';

    public function __construct(
        private int $number,
        private string $protocol,
        private string $state,
        private string $reason,
        private string $service
    ) { }

    public function protocol(): string
    {
        return $this->protocol;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function reason(): string
    {
        return $this->reason;
    }

    public function isOpen(): bool
    {
        return self::STATE_OPEN === $this->state;
    }

    public function isClosed(): bool
    {
        return self::STATE_CLOSED === $this->state;
    }

    public function service(): string
    {
        return $this->service;
    }

    public function whereNotIn(array $ports): bool
    {
        return ! $this->whereIn($ports);
    }

    public function whereIn(array $ports): bool
    {
        return (bool) optional($ports)[$this->number] ?? false;
    }

    public function number(): int
    {
        return $this->number;
    }

    public function toArray()
    {
        return [
            'number'   => $this->number,
            'protocol' => $this->protocol,
            'state'    => $this->state,
            'reason'   => $this->reason,
            'service'  => $this->service,
        ];
    }
}
