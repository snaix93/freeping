<div
    x-data="{
        group: '{{ $defaultGroup }}',
    }"
    class="flex relative flex-col flex-1 w-full bg-gray-50 border-r border-gray-100"
>
    @if (is_null($target))

        @if($targets->isNotEmpty())
            <div class="flex relative top-px mt-14 items-center w-full h-14 bg-gray-100 bg-opacity-75 p-gutter">
                <div class="flex items-center space-x-3 text-gray-700">
                    <x-heroicon-s-arrow-circle-left class="w-8 h-8"/>
                    <span class="text-lg">
                        {{ __('Select a pinger for more details') }}
                    </span>
                </div>
            </div>
        @endif

    @else

        <div class="relative h-14 top-px border-b border-gray-100">
            <div class="flex items-center space-x-3 h-full p-gutter-x">
                <div class="text-xs text-gray-800 uppercase">
                    group by:
                </div>
                <nav class="flex space-x-4" aria-label="Tabs">
                    @foreach($groups as $value => $text)
                        <a
                            @click.stop.prevent="group = '{{ $value }}'"
                            href="#"
                            :class="{
                               'bg-gray-100 text-gray-700': group === '{{$value}}',
                               'text-gray-500 hover:text-gray-700': group !== '{{$value}}',
                            }"
                            class="py-2 px-3 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700"
                        >
                            {{ $text }}
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <div x-cloak x-show="group === 'location'">
            @include('livewire.pinger.partials.ping-details-by-location')
        </div>

        <div x-cloak x-show="group === 'target'">
            @include('livewire.pinger.partials.ping-details-by-target')
        </div>

    @endif
</div>
