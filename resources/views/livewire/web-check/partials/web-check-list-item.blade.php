<li
    class="h-36"
    wire:key="webCheckItem_{{ $webCheck->encodeId() }}"
    data-qa="web-check"
>
    <a
        href="#"
        class="pt-4 block h-full @if ($webCheck->encodeId() === $selectedWebCheckId) hover:bg-gray-50 bg-gray-50 @else hover:bg-gray-50 hover:bg-opacity-50 @endif"
        wire:click.stop.prevent="showWebCheckDetails({{ $webCheck->encodeId() }})"
    >
        <div class="grid grid-cols-6 gap-4 h-full sm:grid-cols-8 p-gutter-x">
            <div class="col-span-3 space-y-2 h-full sm:col-span-4">
                <div class="flex">
                    <p class="text-sm font-medium text-gray-600 truncate">
                        {{ $webCheck->url }}
                    </p>
                </div>
                <div class="flex flex-col pl-4 text-xs font-medium text-gray-400 truncate">
                    <p>
                        {{ __('Method') }}:
                        <span class="text-gray-500">
                            {{ $webCheck->method }}
                        </span>
                    </p>
                    <p>
                        {{ __('Expected status') }}:
                        <span class="text-gray-500">
                            {{ $webCheck->expected_http_status ?? __('Not set') }}
                        </span>
                    </p>
                    <x-tooltip
                        :active="filled($webCheck->expected_pattern)"
                        :truncate="true"
                    >
                        <p>
                            {{ __('Expected pattern') }}:
                            <span class="text-gray-500 truncate">
                                @if(blank($webCheck->expected_pattern))
                                    {{ __('Not set') }}
                                @else
                                    {{ $webCheck->expected_pattern }}
                                @endif
                            </span>
                        </p>
                        <x-slot name="content">
                            {{ $webCheck->expected_pattern }}
                        </x-slot>
                    </x-tooltip>
                    <p>
                        {{ __('Search source') }}:
                        <span class="text-gray-500">
                            @if(is_null($webCheck->search_html_source))
                                {{ __('Not set') }}
                            @else
                                {{ $webCheck->search_html_source ? __('Yes') : __('No') }}
                            @endif
                        </span>
                    </p>
                    <p>
                        {{ __('Headers') }}:
                        <span class="text-gray-500">
                            @if(is_null($webCheck->headers))
                                {{ __('Not set') }}
                            @else
                                {{ filled($webCheck->headers) ? __('Yes') : __('No') }}
                            @endif
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex col-span-3 justify-between h-full sm:col-span-4">
                <div class="flex flex-1 pr-4 space-x-3 h-full sm:pr-0 sm:space-x-5">
                    @if($webCheck->status->is(\App\Enums\WebCheckStatus::AwaitingResult()) || $webCheck->webCheckResults->isEmpty())
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
                                $webCheckResult = $webCheck->webCheckResults->whereNodeId($node->id)->first()
                            @endphp
                            @if(is_null($webCheckResult))
                                <x-tooltip>
                                    <x-ping-result-status-icon size="sm"/>
                                    <x-slot name="content">
                                        {{ __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            @else
                                <x-tooltip>
                                    <div class="w-6 h-6 flex justify-center items-center space-x-0.5">
                                        <x-web-check-result-status-icon
                                            size="xs"
                                            status="{{ $webCheckResult?->status }}"
                                        />
                                    </div>
                                    <x-slot name="content">
                                        {{ __('Web Check') }}
                                        : {{ $webCheckResult?->status->key ?? __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="flex flex-shrink justify-end">
                    <livewire:web-check.web-check-edit
                        :web-check="$webCheck"
                        :key="$webCheck->encodeId()"
                    />
                    <div data-qa="delete-web-check">
                        <x-heroicon-s-x
                            wire:click.stop="confirmEntityDeletion({{ $webCheck->encodeId() }})"
                            class="w-5 h-5 text-gray-300 cursor-pointer hover:text-red-500"
                        />
                    </div>
                </div>
            </div>
        </div>
    </a>
</li>
