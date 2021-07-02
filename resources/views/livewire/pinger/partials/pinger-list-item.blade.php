<li
    class="h-14"
    wire:key="targetItem_{{ $target->encodeId() }}"
    data-qa="pinger"
>
    <a
        href="#"
        class="block h-full @if ($target->encodeId() === $selectedTargetId) hover:bg-gray-50 bg-gray-50 @else hover:bg-gray-50 hover:bg-opacity-50 @endif"
        wire:click.stop.prevent="showTargetDetails({{ $target->encodeId() }})"
    >
        <div class="grid grid-cols-6 sm:grid-cols-8 gap-4 h-full p-gutter-x">
            <div class="col-span-3 h-full sm:col-span-4">
                <div class="flex items-center h-full">
                    <p class="text-sm font-medium text-gray-600 truncate">
                        {{ $target->connect }}
                    </p>
                </div>
            </div>
            <div class="flex col-span-3 justify-between items-center h-full sm:col-span-4">
                <div class="flex flex-1 items-center pr-4 space-x-3 h-full sm:pr-0 sm:space-x-5">
                    @if($target->status->is(\App\Enums\TargetStatus::AwaitingResult()) || $target->pingResults->isEmpty())
                        @foreach($nodes as $node)
                            <x-tooltip>
                                <x-ping-result-status-icon size="sm"/>
                                <x-slot name="content">
                                    {{ __('Awaiting results') }}
                                </x-slot>
                            </x-tooltip>
                        @endforeach
                    @else
                        @foreach($nodes as $node)
                            @php
                                $pingResult = $target->pingResults->whereNodeId($node->id)->first()
                            @endphp
                            @if(is_null($pingResult))
                                <x-tooltip>
                                    <x-ping-result-status-icon size="sm"/>
                                    <x-slot name="content">
                                        {{ __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            @else
                                @php
                                    $portStatus = $target->combinedPortStatusForNodeId($pingResult->node_id)
                                @endphp
                                <x-tooltip>
                                    <div class="w-6 h-6 flex justify-center items-center space-x-0.5">
                                        <x-ping-result-status-icon
                                            size="xs"
                                            status="{{ $pingResult?->status }}"
                                        />
                                        @if($pingResult && !is_null($portStatus))
                                            <x-port-status-icon status="{{ $portStatus }}"/>
                                        @endif
                                    </div>
                                    <x-slot name="content">
                                        {{ __('Pinger') }}
                                        : {{ $pingResult?->status->key ?? __('Awaiting results') }}
                                        @if($pingResult && $portStatus)
                                            <br>
                                            {{ __('TCP Ports') }}:
                                            {{ $portStatus->description }}
                                        @endif
                                    </x-slot>
                                </x-tooltip>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="flex flex-shrink justify-end items-center">
                    <livewire:pinger.pinger-edit
                        :target="$target"
                        :key="$target->encodeId()"
                    />
                    <div data-qa="delete-pinger">
                        <x-heroicon-s-x
                            wire:click.stop="confirmEntityDeletion({{ $target->encodeId() }})"
                            class="w-5 h-5 text-gray-300 cursor-pointer hover:text-red-500"
                        />
                    </div>
                </div>
            </div>
        </div>
    </a>
</li>
