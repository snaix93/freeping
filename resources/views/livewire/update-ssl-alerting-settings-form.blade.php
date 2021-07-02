<x-jet-form-section submit="updateSslAlertingSettings">
    <x-slot name="title">
        {{ __('SSL Alerting Threshold Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('An alert/warning notification is sent if the remaining days are falling below the threshold') }}
        {{ __('Use 0 to disable SSL certificate check.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sslAlertThreshold" value="{{ __('Your SSL Alert Threshold (days)') }}"/>
            <x-jet-input
                wire:model.defer="sslAlertThreshold"
                id="sslAlertThreshold"
                name="sslAlertThreshold"
                type="number"
                size="30"
                min="0"
                autofocus
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <x-jet-input-error for="alert_threshold" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sslWarningThreshold" value="{{ __('Your SSL Warning Threshold (days)') }}"/>
            <x-jet-input
                wire:model.defer="sslWarningThreshold"
                id="sslWarningThreshold"
                name="sslWarningThreshold"
                type="number"
                size="30"
                min="0"
                autofocus
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            />
            <x-jet-input-error for="sslWarningThreshold" class="mt-2"/>
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
