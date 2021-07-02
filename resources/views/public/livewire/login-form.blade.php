<div>
    @if(session('magic-link-sent'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="w-5 h-5 text-green-600"/>
                </div>
                <div class="ml-3">
                    <p class="text-base font-bold text-green-700">
                        {{ session('magic-link-sent') }}
                    </p>
                </div>
            </div>

            <div class="mt-3 flex items-center">
                <a
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                    href="{{ route('login') }}"
                >
                    Back to login
                </a>
            </div>
        </div>

    @else

        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-heroicon-s-information-circle class="w-5 h-5 text-green-600"/>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-green-700">
                        You can use your password to login if you have one. Or if you prefer, or don't yet have a
                        password, you can receive a magic link to login.
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-jet-label for="email" value="{{ __('Email') }}"/>
                <x-jet-input
                    wire:model.defer="email"
                    id="email"
                    class="block mt-1 w-full"
                    type="email"
                    name="email"
                    autofocus
                    autocomplete="email"
                    tabindex="1"
                />
                @error('email')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="my-5 text-center">
                <x-jet-button
                    type="button"
                    color="lime"
                    size="lg"
                    wire:click="sendMagicLink"
                >
                    {{ __('Get magic link to login') }}
                </x-jet-button>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                <span class="px-2 bg-white text-sm text-gray-500">
                    {{ __('Or use password') }}
                </span>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}"/>
                <x-jet-input
                    id="password"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    tabindex="2"
                />
                @error('password')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember"/>
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                @if(Honey::isEnabled())
                    <x-honey recaptcha/>
                @endif
                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
            </div>
        </form>
    @endif
</div>
