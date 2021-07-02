<x-jet-action-section>
    <x-slot name="title">
        {{ __('OMC Token') }}
    </x-slot>

    <x-slot name="description">
        {{__('Use this token for sending data to the Open Monitoring Connector e.g. pulses and capture data. ')}}<a href="#">Learn more</a><br>
        {{ __('Once your OMC token is reset, all pulses and other scripts stop working until you update them with the new token.') }}
    </x-slot>

    <x-slot name="content">
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="key" value="{{ __('Your OMC Token') }}"/>
            <x-jet-input
                wire:model.defer="omc_token"
                id="omc_token"
                name="omc_token"
                type="text"
                size="21"
                min="5"
                readonly
                spellcheck="false"
                autofocus
                class="block py-2 pr-10 pl-3 mt-1 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                style="font-family:monospace"
            />
        </div>


        <div class="mt-5">
            <x-jet-button wire:click="confirmResetOmcToken" wire:loading.attr="disabled">
                {{ __('Reset Token') }}
            </x-jet-button>
            <x-jet-action-message class="text-green-600" on="saved">
                {{ __('New Token generated') }}
            </x-jet-action-message>
        </div>

        <!-- Reset OMC Token Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingResetOmcToken">
            <x-slot name="title">
                {{ __('Reset OMC Token') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to proceed? All your pulses and scripts will stop until you update them with the new token.') }}
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingResetOmcToken')"
                                        wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button
                    class="ml-2"
                    wire:click="resetOmcToken"
                    wire:loading.attr="disabled"
                    data-qa="btn-reset-token"
                >
                    {{ __('Reset Token') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
