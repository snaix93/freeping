<div>
    <x-jet-button
        type="button"
        wire:click="$toggle('dialog')"
        data-qa="btn-create-pinger"
    >
        <x-heroicon-s-plus class="w-5 h-5 mr-2"/>
        <span>{{ __('Create new pinger') }}</span>
    </x-jet-button>

    <x-jet-modal wire:model="dialog">
        <form wire:submit.prevent="@if($this->pingTarget) create @else findPorts @endif">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="flex flex-shrink-0 justify-center items-center mx-auto w-12 h-12 bg-green-600 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                    >
                        <x-heroicon-s-plus class="w-6 h-6 text-white"/>
                    </div>

                    <div class="mt-3 w-full space-y-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-bold">
                            {{ __('Create Pinger') }}
                        </h3>

                        <div>
                            <x-jet-label for="pingTarget" value="{{ __('IP / FQDN') }}"/>
                            <div x-data class="relative mt-1">
                                <x-jet-input
                                    wire:model.lazy="pingTarget"
                                    id="pingTarget"
                                    name="pingTarget"
                                    type="text"
                                    class="block mt-1 w-full"
                                    placeholder="8.8.8.8"
                                    autofocus
                                    x-on:keydown.enter.stop.prevent="$dispatch('change', $event.target.value)"
                                />
                                <x-input-spinner/>
                            </div>
                            <x-jet-input-error for="pingTarget" class="mt-2"/>
                        </div>
                        <div>
                            @if ($this->pingTarget)
                                <x-jet-label for="ports" value="{{ __('TCP Checks') }}"/>
                                <div class="mt-1">
                                    <x-tcp-ports
                                        :ports="$this->ports"
                                        :open-ports="$this->openPorts"
                                        :custom-ports="$this->customPorts"
                                    />
                                </div>
                            @else
                                <div class="rounded-md bg-blue-100 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0 text-blue-500">
                                            <x-heroicon-s-information-circle class="w-5 h-5"/>
                                        </div>
                                        <div class="ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-sm text-blue-700">
                                                {{ __('Enter IP/FQDN first to enable TCP checks') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
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
                        wire:loading.attr="disabled"
                    >
                        @if($this->pingTarget)
                            {{ __('Create Pinger') }}
                        @else
                            {{ __('Verify') }}
                        @endif
                    </x-jet-button>
                </div>
            </div>
        </form>
    </x-jet-modal>
</div>
