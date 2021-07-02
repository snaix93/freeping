@props(['withMessage' => true, 'key'])

<div
    {{ $attributes->class([
        'flex',
        'items-center' => $withMessage,
        'items-start h-full' => !$withMessage,
    ]) }}
>
    <button
        class="flex-shrink-0 text-gray-600 rounded-full focus:outline-none hover:text-gray-900 focus:text-gray-500 focus:ring focus:ring-opacity-70 hover:ring hover:ring-opacity-70"
        data-qa="add-header"
        wire:click.prevent.stop="addHeader('{{ $key }}')"
    >
        <x-heroicon-s-plus-circle class="w-6 h-6"/>
    </button>
    @if($withMessage)
        <span class="text-sm text-gray-800 ml-2">◀ {{ __('Add header') }}</span>
    @endif
</div>
