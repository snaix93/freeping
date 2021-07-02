@props(['port', 'ports'])

<div
    x-data="{ hover: false }"
    {{ $attributes->class([
        'inline-flex flex-shrink-0 rounded-full items-center py-0.5 pr-3 pl-1 text-sm font-medium cursor-pointer tracking-tighter group mr-1 mb-0.5',
        'bg-gray-700 text-gray-50 shadow' => $port->whereIn($ports),
        'bg-gray-200 text-gray-600 shadow-inner' => $port->whereNotIn($ports),
    ]) }}
    wire:click="togglePortInclusion({{ $port->number() }})"
    x-on:mouseenter="hover = true"
    x-on:mouseleave="hover = false"
    data-qa="tcp-check"
>
    <button
        x-on:focus="hover = true"
        x-on:blur="hover = false"
        type="button"
        {{ $attributes->class([
            'inline-flex flex-shrink-0 justify-center items-center mr-2 w-4 h-4 text-gray-700 bg-gray-50 rounded-full focus:outline-none group-hover:bg-gray-50 group-hover:text-gray-700 focus:bg-gray-50 focus:text-gray-700 focus:ring-4 focus:ring-opacity-70 group-hover:bg-gray-50 group-hover:text-gray-700 group-hover:ring-4 group-hover:ring-opacity-70',
            'focus:ring-gray-100 group-hover:ring-gray-100' => $port->whereIn($ports),
            'focus:ring-gray-700 group-hover:ring-gray-700' => $port->whereNotIn($ports),
        ]) }}
    >
        <span class="sr-only">{{ __('Toggle port for TCP checks') }}</span>

        <span class="w-3 h-3">
            <span
                @if ($port->whereIn($ports))
                    x-show="! hover"
                @else
                    x-show="hover"
                @endif
            >
                <x-heroicon-s-check/>
            </span>

            @if ($port->whereIn($ports))
                <x-heroicon-s-x
                    x-show="hover"
                />
            @endif
        </span>
    </button>
    <span>{{ $port->number() }}/{{ $port->service() }}</span>
</div>
