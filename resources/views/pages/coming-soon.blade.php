<x-app-layout>
    <div class="mx-auto mt-10 max-w-7xl">
        <div class="overflow-hidden px-4 pt-5 pb-4 mx-auto text-left bg-white rounded-lg shadow-xl transition-all transform sm:my-8 sm:max-w-sm sm:w-full sm:p-6">
            <div>
                <div class="flex justify-center items-center mx-auto w-12 h-12 rounded-full">
                    <img
                        class="w-auto h-12 animate-spin"
                        src="{{ asset('/images/freeping-logo.svg') }}"
                        alt="FreePing"
                    >
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        {{ __('Coming soon') }}
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            {{ __('This feature on FreePing is currently under development. Check back soon!') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6">
                <a href="{{ route('pingers') }}"
                   class="inline-flex justify-center py-2 px-4 w-full text-base font-medium text-white bg-blue-600 rounded-md border border-transparent shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                    {{ __('Back To Pingers') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
