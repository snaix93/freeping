<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-10 sm:space-y-0">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')
                <x-jet-section-border/>
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                @livewire('profile.update-password-form')
                <x-jet-section-border/>
            @endif

            @livewire('profile.reset-omc-token-form')
            <x-jet-section-border/>

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                @livewire('profile.two-factor-authentication-form')
                <x-jet-section-border/>
            @endif

            @livewire('profile.logout-other-browser-sessions-form')

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-jet-section-border/>
                @livewire('profile.delete-user-form')
            @endif
        </div>
    </div>
</x-app-layout>
