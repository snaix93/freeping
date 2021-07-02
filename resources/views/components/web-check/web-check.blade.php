@props(['webChecks', 'webCheck', 'key'])

<div x-data="{ expand: false }" class="text-sm text-gray-800" data-qa="web-check">
    <div class="flex space-x-3">
        <div>
            <input
                wire:model="webChecks.{{$key}}.active"
                id="webcheck{{$key}}"
                name="webcheck{{$key}}"
                type="checkbox"
                checked="{{ $webCheck['active'] }}"
                class="mt-0 w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
            >
        </div>
        <div class="overflow-hidden flex-1 @if(!$webChecks[$key]['active']) line-through @endif">
            <div class="truncate">
                <x-tooltip :truncate="true">
                    {{ $webCheck['url'] }}
                    <x-slot name="content">
                        {{ $webCheck['url'] }}
                    </x-slot>
                </x-tooltip>
            </div>
            <div class="text-gray-600">
                {{ $webCheck['method'] }} HTTP {{ $webCheck['expectedStatus'] }} Expected
            </div>
        </div>
        <div class="min-w-[125px] flex justify-end items-start">
            <x-jet-button
                type="button"
                size="xxs"
                :disabled="!$webChecks[$key]['active']"
                color="white"
                @click.stop.prevent="expand = !expand"
                data-qa="show-advanced-web-check-settings"
            >
                <x-heroicon-s-chevron-down
                    x-show="!expand"
                    class="w-4 h-4"
                />
                <x-heroicon-s-chevron-up
                    x-show="expand"
                    class="w-4 h-4"
                />
                {{ __('Show advanced') }}
            </x-jet-button>
        </div>
    </div>
    <div
        x-show="expand"
        x-cloak
        class="mt-1 mb-5 text-left bg-gray-50 rounded-md shadow p-gutter"
    >
        @include('components.web-check.web-check-advanced')
    </div>
</div>
