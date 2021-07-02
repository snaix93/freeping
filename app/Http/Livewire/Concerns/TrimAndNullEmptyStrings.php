<?php

namespace App\Http\Livewire\Concerns;

trait TrimAndNullEmptyStrings
{
    public function updatedTrimAndNullEmptyStrings($name, $value)
    {
        if (! is_string($value)) {
            return;
        }

        $value = trim($value);
        $value = $value === '' ? null : $value;

        data_set($this, $name, $value);
    }
}
