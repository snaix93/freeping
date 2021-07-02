<?php

namespace App\Data\Target;

class TargetReportStats
{
    public function __construct(public string $successRate, public string $nodeName) { }
}
