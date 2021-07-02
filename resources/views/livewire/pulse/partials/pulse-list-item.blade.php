<li
    class="h-16"
    wire:key="pulseItem_{{ $pulse->encodeId() }}"
    data-qa="pulse"
>
    <div class="flex space-x-4 w-full h-full p-gutter-x">
        <div class="grid flex-1 grid-cols-12 space-x-4">
            <div class="flex flex-col flex-1 col-span-2 justify-center">
                <p class="text-xs font-medium text-gray-800 md:text-sm truncate">
                    {{ $pulse->hostname }}
                </p>
                <p class="flex items-center text-xs text-gray-800">
                    {{ $pulse->location }}
                </p>
            </div>
            <div class="flex col-span-4 items-center">
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    {{ $pulse->description }}
                </p>
            </div>
            <div class="flex flex-col flex-1 col-span-5 justify-center">
                <p class="flex flex-col text-sm text-gray-600 md:flex-row md:space-x-1">
                    <span>{{ __('Last pulse received at') }}:</span>
                    <x-local-datetime :datetime="$pulse->last_pulse_received_at"/>
                </p>
                <div>
                    <x-tooltip>
                        <p class="text-xs text-gray-800 md:text-xs truncate">
                            {{ $pulse->last_user_agent }}
                        </p>
                        <x-slot name="content">
                            {{ $pulse->last_user_agent }}
                        </x-slot>
                    </x-tooltip>
                </div>
            </div>
            <div class="flex col-span-1 justify-center items-center">
                <x-pulse-status-icon :status="$pulse->status->value"/>
            </div>
        </div>

        <div class="flex flex-shrink justify-end items-center">
            <div data-qa="delete-pulse">
                <x-heroicon-s-x
                    wire:click.stop="confirmEntityDeletion({{ $pulse->encodeId() }})"
                    class="w-5 h-5 text-gray-300 cursor-pointer hover:text-red-500"
                />
            </div>
        </div>
    </div>
</li>
