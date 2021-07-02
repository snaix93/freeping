<div class="relative bg-white py-10 mx-auto">
    <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl">

        <p class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">
            “Pingers”
        </p>
        <p class="mt-5 max-w-prose mx-auto text-xl text-gray-500">
            We'll constantly "ping" your server and let you know if it goes offline.
        </p>

        <div class="mt-5">
            <x-jet-button
                color="secondary"
                type="button"
                wire:click="$emit('showCreate')"
                data-qa="btn-pinger-create"
            >
                <x-heroicon-s-plus class="mr-2 w-5 h-5"/>
                <span>{{ __('Get started') }}</span>
            </x-jet-button>
        </div>
    </div>
</div>
