<?php

namespace App\Data\Target;

class TargetReportData
{
    /**
     * @var array|TargetReportStats[]
     */
    public array $stats;

    public function __construct(public string $connect, TargetReportStats ...$stats)
    {
        $this->stats = $stats;
    }
}
