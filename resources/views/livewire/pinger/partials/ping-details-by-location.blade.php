<ul class="border-b border-gray-200 border-opacity-50 divide-y divide-gray-200 divide-opacity-50 shadow-sm">
    <li class="flex items-center w-full h-14 p-gutter-x">
        <h2 class="text-xl font-semibold truncate">
            {{ $target->connect }}
        </h2>
    </li>

    @foreach($nodes as $node)

        @php
            $pingResult = $target->pingResults?->whereNodeId($node->id)?->first()
        @endphp

        <li class="flex w-full min-h-14">
            <div class="flex justify-center items-start w-20 md:w-24 border-r border-gray-200 border-opacity-50 p-gutter">
                <div class="flex flex-col items-center">
                    <x-flag-icon
                        size="10"
                        :country="$node->country"
                        rounded="rounded-lg"
                    />
                    <div class="mt-2 text-sm tracking-tighter text-gray-700 truncate">
                        {{ $node->short_name }}
                    </div>
                </div>
            </div>
            <ul class="flex-1 divide-y divide-gray-200 divide-opacity-25">
                <li class="grid grid-cols-6 gap-3 h-10 bg-white bg-opacity-75 p-gutter-x py-2">
                    <div class="flex col-span-3 items-center">
                        <div class="text-sm text-gray-800 truncate">
                            {{ $target->connect }}
                        </div>
                    </div>

                    <div class="flex col-span-3 justify-end items-center">

                        @if($target->status->is(\App\Enums\TargetStatus::AwaitingResult()) || $target->pingResults->isEmpty())
                            <x-tooltip>
                                <x-ping-result-status-icon size="xs"/>
                                <x-slot name="content">
                                    {{ __('Awaiting results') }}
                                </x-slot>
                            </x-tooltip>
                        @else

                            <div class="mr-2 text-xs text-gray-600">
                                <time datetime="{{ $pingResult?->updated_at }}">
                                    {{ $pingResult?->updated_at?->diffForHumans() ?? __('Awaiting results') }}
                                </time>
                            </div>
                            <div class="flex-shrink-0">
                                <x-tooltip>
                                    <x-ping-result-status-icon
                                        size="xs"
                                        status="{{ $pingResult?->status }}"
                                    />
                                    <x-slot name="content">
                                        {{ $pingResult?->status?->key ?? __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            </div>

                        @endif
                    </div>
                </li>

                @foreach($target?->ports ?? [] as $port)
                    @php
                        $scanResult = $port->scanResults->whereNodeId($node->id)->first()
                    @endphp

                    <li class="grid grid-cols-5 gap-3 h-10 @if($loop->even) bg-white bg-opacity-75 @endif p-gutter-x">
                        <div class="flex col-span-2 items-center h-full">
                            <div class="pl-3 text-xs text-gray-700">
                                {{ $port->portWithService() }}
                            </div>
                        </div>

                        <div class="flex col-span-3 justify-end items-center">

                            @if($port?->status?->is(\App\Enums\PortStatus::AwaitingResult()) || $port?->scanResults?->isEmpty())
                                <x-tooltip>
                                    <x-scan-result-status-icon/>
                                    <x-slot name="content">
                                        {{ __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>

                            @elseif($pingResult?->status?->is(\App\Enums\PingResultStatus::Unreachable()))

                                <x-tooltip>
                                    <x-port-status-icon status="{{ \App\Enums\PortStatus::Unmonitored }}"/>
                                    <x-slot name="content">
                                        {{ __('Unmonitored') }}
                                    </x-slot>
                                </x-tooltip>

                            @else

                                <div class="mr-2 text-xs text-gray-600">
                                    <time datetime="{{ $scanResult?->updated_at }}">
                                        {{ $scanResult?->updated_at?->diffForHumans() ?? __('Awaiting results') }}
                                    </time>
                                </div>
                                <div class="flex-shrink-0">
                                    <x-tooltip>
                                        <x-scan-result-status-icon
                                            status="{{ $scanResult?->status }}"
                                        />
                                        <x-slot name="content">
                                            {{ $scanResult?->status?->key ?? __('Awaiting results') }}
                                        </x-slot>
                                    </x-tooltip>
                                </div>

                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </li>

    @endforeach
</ul>
