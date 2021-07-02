<li
    class="h-16"
    data-qa="problem"
>
    <div class="flex space-x-4 w-full h-full p-gutter-x">
        <div class="grid flex-1 grid-cols-12 space-x-4">
            <div class="flex flex-col flex-1 col-span-1 justify-center">
                <p class="text-xs font-bold text-gray-700 md:text-sm truncate">
                    Check Type
                </p>
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    {{ $problem->originator }}
                </p>
            </div>
            <div class="flex flex-col flex-1 col-span-4 justify-center">
                <p class="text-xs font-bold text-gray-700 md:text-sm truncate">
                    Host/Target
                </p>
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    {{ $problem->connect }}
                </p>
            </div>
            <div class="flex flex-col flex-1 col-span-4 justify-center">
                <p class="text-xs font-bold text-gray-700 md:text-sm truncate">
                    Description
                </p>
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    {{ $problem->description }}
                </p>
            </div>
            <div class="flex flex-col flex-1 col-span-3 justify-center items-end">
                <p class="text-xs font-bold text-gray-700 md:text-sm truncate">
                    {{ __('Received At') }}
                </p>
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    <x-local-datetime :datetime="$problem->created_at"/>
                </p>
            </div>
        </div>
    </div>
</li>
