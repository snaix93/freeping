<ul class="border-b border-gray-200 border-opacity-50 divide-y divide-gray-200 divide-opacity-50 shadow-sm">
    <li class="grid grid-cols-4 gap-4 h-14 p-gutter-x">
        <div class="flex col-span-2 items-center w-full h-full">
            <h2 class="text-xl font-semibold truncate">
                {{ $target->connect }}
            </h2>
        </div>
        <div class="flex col-span-2 col-start-3 justify-between items-center space-x-2 h-full">
            @include('shared.partials.node-flags')
        </div>
    </li>

    <li class="grid grid-cols-4 gap-4 h-10 bg-white bg-opacity-75 p-gutter-x">
        <div class="flex col-span-2 items-center h-full">
            <div class="pl-6 text-sm text-gray-800 truncate">
                {{ $target->connect }}
            </div>
        </div>
        <div class="flex col-span-2 justify-between items-center h-full">
            @if($target->status->is(\App\Enums\TargetStatus::AwaitingResult()) || $target->pingResults->isEmpty())
                @foreach($nodes as $node)
                    <div class="flex justify-center items-center w-6 h-6">
                        <x-tooltip>
                            <x-ping-result-status-icon size="xs"/>
                            <x-slot name="content">
                                {{ __('Awaiting results') }}
                            </x-slot>
                        </x-tooltip>
                    </div>
                @endforeach
            @else
                @foreach($nodes as $node)
                    @php
                        $pingResult = $target->pingResults->whereNodeId($node->id)->first()
                    @endphp
                    <div class="flex justify-center items-center w-6 h-6">
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
                @endforeach
            @endif
        </div>
    </li>

    @foreach($target->ports ?? [] as $port)
        <li class="grid grid-cols-4 gap-4 h-10 p-gutter-x @if($loop->even) bg-white bg-opacity-75 @endif">
            <div class="flex col-span-2 items-center h-full">
                <div class="pl-8 text-xs text-gray-700">
                    {{ $port->portWithService() }}
                </div>
            </div>

            <div class="flex col-span-2 justify-between items-center h-full">
                @if($port?->status?->is(\App\Enums\PortStatus::AwaitingResult()) || $port->scanResults->isEmpty())
                    @foreach($nodes as $node)
                        <div class="flex justify-center items-center w-6 h-6">
                            <x-tooltip>
                                <x-scan-result-status-icon/>
                                <x-slot name="content">
                                    {{ __('Awaiting results') }}
                                </x-slot>
                            </x-tooltip>
                        </div>
                    @endforeach
                @else
                    @foreach($nodes as $node)
                        @php
                            $pingResult = $target->pingResults?->whereNodeId($node->id)?->first();
                            $scanResult = $port->scanResults?->whereNodeId($node->id)?->first()
                        @endphp
                        <div class="flex justify-center items-center w-6 h-6">

                            @if($pingResult?->status?->is(\App\Enums\PingResultStatus::Unreachable()))
                                <div class="flex justify-center items-center w-6 h-6">
                                    <x-tooltip>
                                        <x-port-status-icon status="{{ \App\Enums\PortStatus::Unmonitored }}"/>
                                        <x-slot name="content">
                                            {{ __('Unmonitored') }}
                                        </x-slot>
                                    </x-tooltip>
                                </div>
                            @else
                                <x-tooltip>
                                    <x-scan-result-status-icon
                                        status="{{ $scanResult?->status }}"
                                    />
                                    <x-slot name="content">
                                        {{ $scanResult?->status?->key ?? __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </li>
    @endforeach
</ul>
