<header class="absolute inset-0 z-20 px-4 mx-auto w-full max-w-7xl h-24 bg-transparent sm:px-6 xl:px-8">
    <div class="flex flex-row w-full h-full justify-between mt-8">
        <div>
            @include('shared.partials.logo', ['includeBroughtToYou' => true])
        </div>
        <nav class="font-bold text-white" aria-label="Global">
            @auth
                <a
                    href="{{ route('pingers') }}"
                    class="flex text-base hover:underline"
                >
                    Dashboard
                </a>
            @else
                <div class="space-x-2 flex justify-between">
                    <a
                        href="{{ route('register') }}"
                        class="text-base hover:underline"
                    >
                        {{ __('Register') }}
                    </a>
                    <span class="font-light">|</span>
                    <a
                        href="{{ route('login') }}"
                        class="text-base hover:underline"
                    >
                        {{ __('Login') }}
                    </a>
                </div>
            @endauth
        </nav>
    </div>
</header>
