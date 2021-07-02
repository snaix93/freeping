<?php

namespace App\Support\Nmap;

class CustomPort
{
    public function __construct(private ?int $number = null) { }

    public function number(): ?int
    {
        return $this->number;
    }

    public static function empty()
    {
        return new self();
    }
}
