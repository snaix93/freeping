@props(['status' => -1])

@switch($status)
    @case(\App\Enums\ScanResultStatus::Open)
    <x-tiny-pulse-status color="green"/>
    @break
    @case(\App\Enums\ScanResultStatus::Closed)
    <x-tiny-pulse-status color="red"/>
    @break
    @default
    <x-tiny-pulse-status color="gray"/>
    @break
@endswitch




