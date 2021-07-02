<?php


namespace App\Data;


use Spatie\DataTransferObject\DataTransferObject;

class ItemComparison extends DataTransferObject
{
    public ?array $new;
    public ?array $gone;
    public bool $hasChanges = false;

    public static function fromComparison(?array $new = null, ?array $gone = null): self
    {
        $hasChanges = false;
        if (!is_null($new) or !is_null($gone)) {
            $hasChanges = true;
        }

        return new self([
            'new'        => $new,
            'gone'       => $gone,
            'hasChanges' => $hasChanges,
        ]);
    }
}
