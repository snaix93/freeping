<x-jet-form-section submit="updatePulseSettings">
    <x-slot name="title">
        {{ __('Pulse Threshold Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('An alert notification is sent if any of the hosts stops sending a pulse for more than the specified thresholds.') }}
        {{ __('Use 0 to disable Pulse monitoring.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="key" value="{{ __('Your Pulse Threshold  (seconds)') }}"/>
            <x-jet-input
                wire:model.defer="pulse_threshold"
                id="pulse_threshold"
                name="pulse_threshold"
                type="number"
                size="30"
                min="5"
                autofocus
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <x-jet-input-error for="pulse_threshold" class="mt-2"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3 text-green-600" on="saved">
            {{ __('Saved') }}
        </x-jet-action-message>
        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
