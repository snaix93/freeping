<?php

namespace App\Models\Contracts;

interface Checkable
{
    public function getCheckDefinition(): array;
}
