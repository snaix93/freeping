@props(['status'])

<x-tooltip>
    @switch($status)
        @case(\App\Enums\PulseStatus::Alive)
        <x-tiny-pulse-status color="green"/>
        @break
        @case(\App\Enums\PulseStatus::Lost)
        <x-tiny-pulse-status color="red"/>
        @break
    @endswitch

    <x-slot name="content">
        {{ \App\Enums\PulseStatus::getDescription($status) }}
    </x-slot>
</x-tooltip>
