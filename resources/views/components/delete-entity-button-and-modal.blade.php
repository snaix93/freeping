@props(['entityId', 'title', 'content', 'deleteButtonText'])

<x-jet-confirmation-modal wire:model="confirmingEntityDeletion">
    <x-slot name="title">
        {{ $title }}
    </x-slot>
    <x-slot name="content">
        {{ $content }}
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
            wire:click="deleteEntity({{ $entityId }})"
            wire:loading.attr="disabled"
        >
            {{ $deleteButtonText }}
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
