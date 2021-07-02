<div data-qa="edit-web-check">
    <x-heroicon-s-pencil
        wire:click="$toggle('dialog')"
        class="w-5 h-5 text-gray-300 cursor-pointer hover:text-blue-700"
    />

    <x-jet-modal wire:model="dialog" max-width="4xl">
        <form wire:submit.prevent.stop="update">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="flex items-center space-x-3">
                    <div
                        class="flex flex-shrink-0 justify-center items-center w-12 h-12 bg-green-600 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                    >
                        <x-heroicon-s-pencil class="w-6 h-6 text-white"/>
                    </div>
                    <h3 class="text-lg font-bold">
                        {{ __('Edit Web Check') }}
                    </h3>
                </div>

                @foreach($this->webChecks as $key => $webCheck)
                    <div class="py-2 mt-1 mb-5 text-left bg-gray-50 rounded-md shadow p-gutter">
                        @include('components.web-check.web-check-advanced', [
                            'hostEditable' => true,
                        ])
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center py-4 px-6 bg-gray-100">
                <div>
                    <svg
                        wire:loading.delay.class.remove="hidden"
                        class="hidden w-6 h-6 text-blue-700 animate-spin"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <div class="text-right">
                    <x-jet-secondary-button
                        wire:click="closeDialog"
                        wire:loading.attr="disabled"
                    >
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                    <x-jet-button
                        class="ml-2"
                        type="button"
                        wire:loading.attr="disabled"
                        wire:click.prevent.stop="update"
                    >
                        {{ __('Save') }}
                    </x-jet-button>
                </div>
            </div>
        </form>
    </x-jet-modal>
</div>

