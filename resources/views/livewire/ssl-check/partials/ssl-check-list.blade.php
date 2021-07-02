<div>
    <div class="overflow-hidden bg-white">
        <ul class="border-b border-gray-100 divide-y divide-gray-100">
            <li
                class="h-16"
                data-qa="sslCheck"
            >
                <div class="flex space-x-4 w-full h-full p-gutter-x">
                    <div class="grid flex-1 grid-cols-12 space-x-4">
                        <div class="flex flex-col flex-1 col-span-4 justify-center">
                            <p class="text-xs font-medium text-gray-800 md:text-sm truncate">
                                {{ __('Host') }}
                            </p>
                        </div>
                        <div class="flex col-span-4 items-center">
                            <p class="text-xs text-gray-700 md:text-sm truncate">
                                {{ __('Certificate expires') }}
                            </p>
                        </div>
                        <div class="flex flex-col flex-1 col-span-4 justify-center">
                            <p class="flex flex-col text-sm text-gray-600 md:flex-row md:space-x-1">
                                <span>{{ __('Last check received at') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
            @each('livewire.ssl-check.partials.ssl-check-list-item', $sslChecks, 'sslCheck')
        </ul>

        @if ($sslChecks->hasPages())
            <div class="py-2 bg-white bg-gray-50 bg-opacity-25 border-b border-gray-100 p-gutter-x">
                {{ $sslChecks->links() }}
            </div>
        @endif
    </div>

    <x-last-refreshed/>

</div>
