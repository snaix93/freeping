<div>
    <div class="overflow-hidden bg-white">
        <ul class="border-b border-gray-100 divide-y divide-gray-100">
            @each('livewire.pulse.partials.pulse-list-item', $pulses, 'pulse')
        </ul>

        @if ($pulses->hasPages())
            <div class="py-2 bg-white bg-gray-50 bg-opacity-25 border-b border-gray-100 p-gutter-x">
                {{ $pulses->links() }}
            </div>
        @endif
    </div>

    <x-last-refreshed/>

    <x-delete-entity-button-and-modal
        :entityId="$deleteEntityId"
        :title="__('Delete Pulse')"
        :content="__('Are you sure you want to delete this pulse?')"
        :deleteButtonText="__('Delete Pulse')"
    />
</div>
