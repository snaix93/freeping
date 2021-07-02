@props(['status'])

@switch($status)
    @case(\App\Enums\PortStatus::AwaitingResult)
        <x-tiny-pulse-status color="gray"/>
    @break
    @case(\App\Enums\PortStatus::Open)
        <x-tiny-pulse-status color="green"/>
    @break
    @case(\App\Enums\PortStatus::Closed)
        <x-tiny-pulse-status color="red"/>
    @break
    @case(\App\Enums\PortStatus::PartiallyClosed)
        <x-tiny-pulse-status color="orange"/>
    @break
    @case(\App\Enums\PortStatus::Unmonitored)
        <x-tiny-pulse-status color="light-gray"/>
    @break
@endswitch
