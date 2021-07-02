<div
    x-data="{ time: new Date().toTimeString() }"
    x-init="window.livewire.hook('message.processed', () => {
         time = new Date().toTimeString();
    })"
    class="w-full text-xs text-gray-500 p-gutter"
>
    {{ __('Last refreshed') }}: <span x-text="time"></span>
</div>
