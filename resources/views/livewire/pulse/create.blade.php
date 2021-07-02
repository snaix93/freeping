<div>
    <x-jet-button
        type="button"
        wire:click="$toggle('dialog')"
        data-qa="btn-create-pulse"
    >
        <x-heroicon-s-plus class="w-5 h-5 mr-2"/>
        <span>{{ __('Create new pulse') }}</span>
    </x-jet-button>

    <x-jet-modal wire:model="dialog" max-width="4xl">
        <form wire:submit.prevent="create">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="flex flex-shrink-0 justify-center items-center mx-auto w-12 h-12 bg-green-600 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                    >
                        <x-heroicon-s-plus class="w-6 h-6 text-white"/>
                    </div>

                    <div class="mt-3 md:mr-10 w-full space-y-5 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-bold">
                            {{ __('Create Pulse') }}
                        </h3>

                        <x-copy-command-box
                            command="{!! $this->getWindowsCommand() !!}"
                            title="{{ __('On Windows') }}"
                        />
                        <x-copy-command-box
                            command="{!! $this->getLinuxCommand() !!}"
                            title="{{ __('On Linux') }}"
                        />

                        <div>
                            <a
                                href="https://docs.cloudradar.io/freeping.io/open-monitoring-connector/pulse"
                                class="group text-sm inline-flex items-center flex-shrink space-x-1"
                                target="_blank"
                            >
                                <x-heroicon-s-question-mark-circle
                                    class="w-5 h-5 text-gray-300 cursor-pointer group-hover:text-blue-500"
                                />
                                <span class="group-hover:underline ">{{ __('Learn more') }}</span>
                            </a>
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
                        {{ __('Close') }}
                    </x-jet-secondary-button>
                </div>
            </div>
        </form>
    </x-jet-modal>


</div>
