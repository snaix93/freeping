<div>
    <div>
        <div class="overflow-hidden bg-white">
            <ul class="border-b border-gray-100 divide-y divide-gray-100">
                @if ($webChecks->isNotEmpty())
                    <li wire:key="targetHeader" class="h-14">
                        <div class="grid grid-cols-6 sm:grid-cols-8 gap-4 h-full p-gutter-x">
                            <div class="flex col-span-3 col-start-4 items-center space-x-3 h-full sm:col-span-2 sm:pr-0 sm:col-start-5 sm:space-x-5">
                                @include('shared.partials.node-flags')
                            </div>
                        </div>
                    </li>
                @endif

                @foreach($webChecks as $webCheck)
                    @include('livewire.web-check.partials.web-check-list-item')
                @endforeach
            </ul>

            @if ($webChecks->hasPages())
                <div class="py-2 bg-white bg-gray-50 bg-opacity-25 border-b border-gray-100 p-gutter-x">
                    {{ $webChecks->links() }}
                </div>
            @endif
        </div>

        <div
            x-data="{ time: new Date().toTimeString() }"
            x-init="window.livewire.hook('message.processed', () => {
                 time = new Date().toTimeString();
            })"
            class="w-full text-xs text-gray-500 p-gutter"
        >
            {{ __('Last refreshed') }}: <span x-text="time"></span>
        </div>

        <x-jet-confirmation-modal wire:model="confirmingEntityDeletion">
            <x-slot name="title">
                {{ __('Delete Web Check') }}
            </x-slot>
            <x-slot name="content">
                {{ __('Are you sure you want to delete this web check?') }}
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button
                    wire:click="$toggle('confirmingEntityDeletion')"
                    wire:loading.attr="disabled"
                >
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>
                <x-jet-danger-button
                    class="ml-2"
                    wire:click="deleteEntity({{ $deleteEntityId }})"
                    wire:loading.attr="disabled"
                >
                    {{ __('Delete Web Check') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-confirmation-modal>
    </div>
</div>
