<x-jet-form-section submit="save">
    <x-slot name="title">
        {{ __('Pushover Notifications') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Update your settings to receive Pushover notifications.') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="key" value="{{ __('Your Pushover Key') }}"/>
            <x-jet-input
                wire:model.defer="pushover.meta.key"
                id="key"
                name="key"
                type="text"
                size="30"
                min="5"
                autofocus
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <x-jet-input-error for="pushover.meta.key" class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label value="{{ __('Events to send to this recipient') }}"/>
            <div class="max-w-lg space-y-2 mt-1">
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <x-jet-checkbox
                            wire:model.defer="pushover.alerts"
                            name="alerts"
                            id="alerts"
                            class="h-5 w-5"
                        />
                    </div>
                    <div class="ml-3 text-sm">
                        <x-jet-label for="alerts" value="{{ __('Alerts') }}"/>
                    </div>
                </div>
                <x-jet-input-error for="pushover.alerts" class="mt-2"/>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <x-jet-checkbox
                            wire:model.defer="pushover.warnings"
                            name="warnings"
                            id="warnings"
                            class="h-5 w-5"
                        />
                    </div>
                    <div class="ml-3 text-sm">
                        <x-jet-label for="warnings" value="{{ __('Warnings') }}"/>
                    </div>
                </div>
                <x-jet-input-error for="pushover.warnings" class="mt-2"/>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <x-jet-checkbox
                            wire:model.defer="pushover.recoveries"
                            name="recoveries"
                            id="recoveries"
                            class="h-5 w-5"
                        />
                    </div>
                    <div class="ml-3 text-sm">
                        <x-jet-label for="recoveries" value="{{ __('Recoveries') }}"/>
                    </div>
                </div>
                <x-jet-input-error for="pushover.recoveries" class="mt-2"/>
            </div>
        </div>

        <div class="col-span-6 sm:col-span- xl:col-span-4">
            <div class="text-sm font-medium text-gray-700">
                {{ __('Pushover priority of alerts') }}
                <div class="ml-2 inline text-xs text-gray-500">
                    {{ __('Does not apply to warnings and recoveries') }}
                </div>
            </div>
            <div class="space-y-2 mt-1">

                <div class="grid grid-cols-7 gap-4">
                    <div class="col-span-2 flex items-center space-x-2">
                        <input
                            wire:model.defer="pushover.meta.priority"
                            type="radio"
                            id="priorityNormal"
                            name="priority"
                            value="{{ \App\Enums\PushoverPriority::Normal }}"
                            class="h-5 w-5 mt-0.5 cursor-pointer text-green-600 border-gray-300 focus:ring-green-500"
                        >
                        <x-jet-label
                            for="priorityNormal"
                            class="text-gray-700"
                            value="{{ __('Normal') }}"
                        />
                    </div>
                    <div class="col-span-5 flex items-center text-gray-800 h-full text-xs">
                        {{ __('A sound is only played if the phone\'s settings allow it.') }}
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-4">
                    <div class="col-span-2 flex items-center space-x-2">
                        <input
                            wire:model.defer="pushover.meta.priority"
                            type="radio"
                            id="priorityHigh"
                            name="priority"
                            value="{{ \App\Enums\PushoverPriority::High }}"
                            class="h-5 w-5 mt-0.5 cursor-pointer text-orange-500 border-gray-300 focus:ring-orange-500"
                        >
                        <x-jet-label
                            for="priorityHigh"
                            class="text-gray-700"
                            value="{{ __('High') }}"
                        />
                    </div>
                    <div class="col-span-5 flex items-center text-gray-800 h-full text-xs">
                        {{ __('A sound is played, bypassing device quiet hours.') }}
                    </div>
                </div>

                <div class="grid grid-cols-7 gap-4">
                    <div class="col-span-2 flex items-center space-x-2">
                        <input
                            wire:model.defer="pushover.meta.priority"
                            type="radio"
                            id="priorityEmergency"
                            name="priority"
                            value="{{ \App\Enums\PushoverPriority::Emergency }}"
                            class="h-5 w-5 mt-0.5 cursor-pointer text-red-500 border-gray-300 focus:ring-red-400"
                        >
                        <x-jet-label
                            for="priorityEmergency"
                            class="text-gray-700"
                            value="{{ __('Emergency') }}"
                        />
                    </div>
                    <div class="col-span-5 flex items-center text-gray-800 h-full text-xs">
                        {{ __('A sound is played until you confirm and stop it.') }}
                    </div>
                </div>
            </div>
            <x-jet-input-error for="pushover.meta.priority" class="mt-2"/>
        </div>
    </x-slot>
    <x-slot name="actions">
        <div class="flex justify-between w-full">
            <div class="flex items-center">
                @if ($this->pushover->exists() ?? false)
                    <x-jet-danger-button
                        wire:loading.attr="disabled"
                        wire:click="delete"
                    >
                        {{ __('Delete') }}
                    </x-jet-danger-button>
                @endif
                <x-jet-action-message class="ml-3 text-red-500" on="deleted">
                    {{ __('Deleted') }}
                </x-jet-action-message>
            </div>
            <div class="flex items-center">
                <x-jet-action-message class="mr-3 text-green-600" on="saved">
                    {{ __('Saved') }}
                </x-jet-action-message>
                <x-jet-button wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>
            </div>
        </div>
    </x-slot>
</x-jet-form-section>
