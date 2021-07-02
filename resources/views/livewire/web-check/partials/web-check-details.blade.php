<div
    class="flex relative flex-col flex-1 w-full bg-gray-50 border-r border-gray-100"
>
    @if (is_null($webCheck))
        @if($webChecks->isNotEmpty())
            <div class="flex relative top-px mt-14 items-center w-full h-36 bg-gray-100 bg-opacity-75 p-gutter">
                <div class="flex items-center space-x-3 text-gray-700">
                    <x-heroicon-s-arrow-circle-left class="w-8 h-8"/>
                    <span class="text-lg">
                        {{ __('Select a web check for more details') }}
                    </span>
                </div>
            </div>
        @endif
    @else
        @include('livewire.web-check.partials.web-check-details-by-location')
    @endif
</div>
