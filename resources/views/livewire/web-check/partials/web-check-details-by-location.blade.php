<ul class="border-b border-gray-200 border-opacity-50 divide-y divide-gray-200 divide-opacity-50 shadow-sm">
    <li class="flex items-center w-full h-14 p-gutter-x">
        <h2 class="text-xl font-semibold truncate">
            {{ $webCheck->url }}
        </h2>
    </li>

    @foreach($nodes as $node)
        @php
            $webCheckResult = $webCheck->webCheckResults?->whereNodeId($node->id)?->first()
        @endphp

        <li class="flex w-full min-h-14">
            <div class="flex justify-center items-start w-20 border-r border-gray-200 border-opacity-50 md:w-24 p-gutter">
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
            <div class="flex flex-col flex-1 divide-y divide-gray-200 divide-opacity-25">
                <div class="grid grid-cols-6 gap-3 py-2 h-10 bg-white bg-opacity-75 p-gutter-x">
                    <div class="flex col-span-6 justify-end items-center">
                        @if($webCheck->status->is(\App\Enums\WebCheckStatus::AwaitingResult()) || $webCheck->webCheckResults->isEmpty())
                            <x-tooltip>
                                <x-ping-result-status-icon size="xs"/>
                                <x-slot name="content">
                                    {{ __('Awaiting results') }}
                                </x-slot>
                            </x-tooltip>
                        @else
                            <div class="mr-2 text-xs text-gray-600">
                                <time datetime="{{ $webCheckResult?->updated_at }}">
                                    {{ $webCheckResult?->updated_at?->diffForHumans() ?? __('Awaiting results') }}
                                </time>
                            </div>
                            <div class="flex-shrink-0">
                                <x-tooltip>
                                    <x-web-check-result-status-icon
                                        size="xs"
                                        status="{{ $webCheckResult?->status }}"
                                    />
                                    <x-slot name="content">
                                        {{ $webCheckResult?->status?->key ?? __('Awaiting results') }}
                                    </x-slot>
                                </x-tooltip>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="py-2 text-sm text-gray-700 p-gutter-x">
                    <div class="rounded bg-gray-800 text-white text-opacity-80 p-3">
                        @if($webCheck->webCheckResults->isEmpty())
                            {{ __('Awaiting results') }}
                        @else
                            {{ $webCheckResult->reason ?? __('All ok') }}
                        @endif
                    </div>
                </div>
            </div>
        </li>

    @endforeach
</ul>
