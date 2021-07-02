@props(['message'])

<div
    x-data="{ open: true }"
    x-show.transition.out.duration.200ms="open"
    class="bg-green-600"
>
    <div class="py-3 mx-auto max-w-7xl p-gutter-x">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex flex-1 items-center w-0">
                <div class="flex p-2 bg-green-800 rounded-lg">
                    <x-heroicon-o-speakerphone class="w-6 h-6 text-white"/>
                </div>
                <p
                    class="ml-3 font-medium text-white truncate"
                    data-qa="banner:content"
                >
                    {{ $message }}
                </p>
            </div>
            <div class="flex-shrink-0 order-2 sm:order-3 sm:ml-3">
                <button
                    type="button"
                    class="flex p-2 -mr-1 rounded-md hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2"
                    @click="open = false"
                >
                    <span class="sr-only">Dismiss</span>
                    <x-heroicon-s-x class="w-6 h-6 text-white"/>
                </button>
            </div>
        </div>
    </div>
</div>
