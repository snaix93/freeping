<x-jet-form-section submit="updateUserSettings">
    <x-slot name="title">
        {{ __('Report Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your settings for your daily report.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="time" value="{{ __('Report time') }}"/>
            <select
                wire:model.defer="time"
                id="time"
                name="time"
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
                @foreach($this->periods as $period)
                    <option value="{{ $period['value'] }}">
                        {{ $period['text'] }}
                    </option>
                @endforeach
            </select>
            <x-jet-input-error for="name" class="mt-2"/>
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="timezone" value="{{ __('Timezone') }}"/>
            <select
                wire:model.defer="timezone"
                id="timezone"
                name="timezone"
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            >
                @foreach($this->timezones as $_timezone)
                    <option value="{{ $_timezone['value'] }}">
                        ({{ $_timezone['offset'] }}) {{ $_timezone['value'] }}
                    </option>
                @endforeach
            </select>
            <x-jet-input-error for="timezone" class="mt-2"/>
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
