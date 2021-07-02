<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-10 sm:space-y-0">
            <livewire:pushover-recipient/>
            <x-jet-section-border/>
            <livewire:update-pulse-settings-form/>
            <x-jet-section-border/>
            <livewire:update-report-settings-form/>
            <x-jet-section-border/>
            <livewire:update-ssl-alerting-settings-form/>
        </div>
    </div>
</x-app-layout>
