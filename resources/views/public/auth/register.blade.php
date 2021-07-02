<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-slot name="preContent">
            <div class="text-white text-opacity-90 text-sm mt-3 text-center">
                Your <span class="font-bold">forever-free</span> account comes with the following features:
                <ul class="mt-2">
                    <li class="flex justify-center items-center w-full space-x-2">
                        <x-heroicon-s-check class="w-4 h-4 text-green-500"/>
                        <span>Intranet monitoring</span>
                    </li>
                    <li class="flex justify-center items-center w-full space-x-2">
                        <x-heroicon-s-check class="w-4 h-4 text-green-500"/>
                        <span>Web checks</span>
                    </li>
                    <li class="flex justify-center items-center w-full space-x-2">
                        <x-heroicon-s-check class="w-4 h-4 text-green-500"/>
                        <span>Ping checks</span>
                    </li>
                    <li class="flex justify-center items-center w-full space-x-2">
                        <x-heroicon-s-check class="w-4 h-4 text-green-500"/>
                        <span>Port checks</span>
                    </li>
                </ul>
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <x-jet-input id="email"
                             class="block mt-1 w-full"
                             type="email"
                             name="email"
                             :value="old('email')"
                             required/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"/>
                <x-jet-input id="password"
                             class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required
                             autocomplete="new-password"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}"/>
                <x-jet-input id="password_confirmation"
                             class="block mt-1 w-full"
                             type="password"
                             name="password_confirmation"
                             required
                             autocomplete="new-password"/>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {{ __('I accept the') }} <a class="underline"
                                                            href="https://www.cloudradar.io/service-terms"
                                                            target="_blank">{{ __('terms and conditions') }}</a>
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
