<div data-qa="edit-pinger">
    <x-heroicon-s-pencil
        wire:click="$toggle('dialog')"
        class="w-5 h-5 text-gray-300 cursor-pointer hover:text-blue-700"
    />

    <x-jet-modal wire:model="dialog">
        <form wire:submit.prevent.stop="update">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="flex flex-shrink-0 justify-center items-center mx-auto w-12 h-12 bg-green-600 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                    >
                        <x-heroicon-s-pencil class="w-6 h-6 text-white"/>
                    </div>

                    <div class="mt-3 w-full space-y-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-bold">
                            {{ __('Edit Pinger') }}
                        </h3>

                        <div>
                            <x-jet-label for="connect" value="{{ __('IP / FQDN') }}"/>
                            <div x-data class="relative mt-1">
                                <x-jet-input
                                    id="connect"
                                    name="connect"
                                    type="text"
                                    class="block mt-1 w-full bg-gray-50 text-gray-600"
                                    disabled="true"
                                    :value="$this->target->connect"
                                />
                            </div>
                        </div>
                        <div>
                            <x-jet-label for="ports" value="{{ __('TCP Checks') }}"/>
                            <div class="mt-1">
                                <div class="flex justify-between items-center mt-1 h-full sm:col-span-2 sm:mt-0">
                                    @if($this->target->ports->isEmpty() && $this->customPorts->isEmpty())
                                        <x-add-custom-port/>
                                    @else
                                        <div class="flex items-center flex-wrap -mb-0.5">
                                            @if ($this->target->ports->isNotEmpty())
                                                @foreach($this->target->ports as $port)
                                                    <div wire:key="immutable-port-wrapper-{{ $port->id }}">
                                                        <x-ports.immutable-port
                                                            :port="$port"
                                                            :key="'immutable-port-'.$port->id"
                                                        />
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if($this->customPorts->isNotEmpty())
                                                @foreach($this->customPorts as $key => $customPort)
                                                    <div wire:key="{{ $key }}">
                                                        <x-ports.custom-port
                                                            wire:model.defer="customPorts.{{$key}}"
                                                            :key="$key"
                                                        />
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="flex items-start h-full">
                                            <button
                                                class="flex-shrink-0 text-gray-600 rounded-full focus:outline-none hover:text-gray-900 focus:text-gray-500 focus:ring focus:ring-opacity-70 hover:ring hover:ring-opacity-70"
                                                data-qa="add-port"
                                                wire:click.prevent.stop="addCustomPort"
                                            >
                                                <x-heroicon-s-plus-circle class="w-6 h-6"/>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @error('customPorts.*')
                                <div class="text-sm text-red-500 sm:col-start-2 sm:col-span-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

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

