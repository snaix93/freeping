@props(['wireLoadingTarget' => 'connect'])

<div
    class="flex absolute top-0 right-4 items-center h-full pointer-events-none"
>
    <div
        wire:loading
        wire:target="{{ $wireLoadingTarget }}"
    >
        <x-loading-spinner/>
    </div>
</div>
