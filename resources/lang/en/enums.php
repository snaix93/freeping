<?php

use App\Enums\PingResultStatus;
use App\Enums\PortStatus;
use App\Enums\PulseStatus;
use App\Enums\ScanResultStatus;
use App\Enums\TargetStatus;
use App\Enums\WebCheckResultStatus;
use App\Enums\WebCheckStatus;

return [

    TargetStatus::class => [
        TargetStatus::AwaitingResult       => 'Awaiting result',
        TargetStatus::Online               => 'Online',
        TargetStatus::Unreachable          => 'Unreachable',
        TargetStatus::PartiallyUnreachable => 'Partially unreachable',
    ],

    PingResultStatus::class => [
        PingResultStatus::Unreachable  => 'Unreachable',
        PingResultStatus::Alive        => 'Alive',
        PingResultStatus::Unresolvable => 'Unresolvable',
    ],

    PortStatus::class => [
        PortStatus::AwaitingResult  => 'Awaiting result',
        PortStatus::Open            => 'Open',
        PortStatus::Closed          => 'Closed',
        PortStatus::PartiallyClosed => 'Partially closed',
        PortStatus::Unmonitored     => 'Unmonitored',
    ],

    ScanResultStatus::class => [
        ScanResultStatus::Open   => 'Open',
        ScanResultStatus::Closed => 'Closed',
    ],

    WebCheckStatus::class => [
        WebCheckStatus::AwaitingResult  => 'Awaiting result',
        WebCheckStatus::Successful      => 'Ok',
        WebCheckStatus::Failed          => 'Failed',
        WebCheckStatus::PartiallyFailed => 'Partially failed',
    ],

    WebCheckResultStatus::class => [
        WebCheckResultStatus::Fail    => 'Fail',
        WebCheckResultStatus::Success => 'Success',
    ],

    PulseStatus::class => [
        PulseStatus::Alive => 'Alive',
        PulseStatus::Lost  => 'Lost',
    ],

];
