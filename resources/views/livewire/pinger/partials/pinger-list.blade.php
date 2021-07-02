<div>
    <div class="overflow-hidden bg-white">
        <ul class="border-b border-gray-100 divide-y divide-gray-100">
            @if ($targets->isNotEmpty())
                <li wire:key="targetHeader" class="h-14">
                    <div class="grid grid-cols-6 sm:grid-cols-8 gap-4 h-full p-gutter-x">
                        <div class="flex col-span-3 col-start-4 items-center space-x-3 h-full sm:col-span-2 sm:pr-0 sm:col-start-5 sm:space-x-5">
                            @include('shared.partials.node-flags')
                        </div>
                    </div>
                </li>
            @endif

            @foreach($targets as $target)
                @include('livewire.pinger.partials.pinger-list-item')
            @endforeach
        </ul>

        @if ($targets->hasPages())
            <div class="py-2 bg-white bg-gray-50 bg-opacity-25 border-b border-gray-100 p-gutter-x">
                {{ $targets->links() }}
            </div>
        @endif
    </div>

    <x-last-refreshed/>

    <x-delete-entity-button-and-modal
        :entityId="$deleteEntityId"
        :title="__('Delete Pinger')"
        :content="__('Are you sure you want to delete this pinger?')"
        :deleteButtonText="__('Delete Pinger')"
    />
</div>
