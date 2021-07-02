@props(['size' => 'sm', 'status'])

<x-tooltip>

    @if ($size === 'xs')

        @switch($status)
            @case(\App\Enums\TargetStatus::AwaitingResult)
            <x-tiny-pulse-status color="gray"/>
            @break
            @case(\App\Enums\TargetStatus::Online)
            <x-tiny-pulse-status color="green"/>
            @break
            @case(\App\Enums\TargetStatus::Unreachable)
            <x-tiny-pulse-status color="red"/>
            @break
            @case(\App\Enums\TargetStatus::PartiallyUnreachable)
            <x-tiny-pulse-status color="orange"/>
            @break
        @endswitch

    @else

        @switch($size)
            @case('lg')
            @php
                $circleSize = '8';
                $iconSize = '5'
            @endphp
            @break
            @case('sm')
            @php
                $circleSize = '6';
                $iconSize = '4'
            @endphp
            @break
        @endswitch

        @switch($status)
            @case(\App\Enums\TargetStatus::AwaitingResult)
            <div
                class="w-{{ $circleSize }} h-{{ $circleSize }} flex items-center justify-center shadow rounded-full bg-gray-500"
            >
                <svg class="text-white text-opacity-85 w-{{ $iconSize }} h-{{ $iconSize }}"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            @break
            @case(\App\Enums\TargetStatus::Online)
            <div
                class="w-{{ $circleSize }} h-{{ $circleSize }} flex items-center justify-center shadow rounded-full bg-green-600"
            >
                <svg class="text-white text-opacity-85 w-{{ $iconSize }} h-{{ $iconSize }}"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            @break
            @case(\App\Enums\TargetStatus::Unreachable)
            <div
                class="w-{{ $circleSize }} h-{{ $circleSize }} flex items-center justify-center shadow rounded-full bg-red-500"
            >
                <svg class="text-white text-opacity-85 w-{{ $iconSize }} h-{{ $iconSize }}"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            @break
            @case(\App\Enums\TargetStatus::PartiallyUnreachable)
            <div
                class="w-{{ $circleSize }} h-{{ $circleSize }} flex items-center justify-center shadow rounded-full bg-orange-400"
            >
                <svg class="text-white text-opacity-85 w-{{ $iconSize }} h-{{ $iconSize }}"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
            </div>
            @break
        @endswitch

    @endif

    <x-slot name="content">
        {{ \App\Enums\TargetStatus::getDescription($status) ?: __('Awaiting results') }}
    </x-slot>
</x-tooltip>
