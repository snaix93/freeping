<div class="mt-2 space-y-2.5 w-full">
    <div class="p-3 text-base text-center text-gray-700 bg-white rounded-lg shadow truncate">
        {{ $webChecks[$key]['url'] }}
    </div>

    <div class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4 sm:items-center">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-host"
                value="{{ __('Host') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                @if($hostEditable ?? false)
                    <x-jet-input
                        wire:model="webChecks.{{$key}}.host"
                        id="webcheck{{$key}}-host"
                        name="webcheck{{$key}}-host"
                        type="text"
                    />
                @else
                    <x-jet-input
                        id="webcheck{{$key}}-host"
                        name="webcheck{{$key}}-host"
                        type="text"
                        disabled
                        value="{{ $webChecks[$key]['host'] }}"
                        class="text-gray-700 bg-gray-100"
                    />
                @endif
                <x-jet-input-error for="webChecks.{{$key}}.host" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-protocol" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-protocol"
                value="{{ __('Protocol') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <select
                    wire:model="webChecks.{{$key}}.protocol"
                    id="webcheck{{$key}}-protocol"
                    name="webcheck{{$key}}-protocol"
                    class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                    <option value="http">{{ __('HTTP') }}</option>
                    <option value="https">{{ __('HTTPS') }}</option>
                </select>
                <x-jet-input-error for="webChecks.{{$key}}.protocol" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-port" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-port"
                value="{{ __('Port') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.port"
                    id="webcheck{{$key}}-port"
                    name="webcheck{{$key}}-port"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.port" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-path" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-path"
                value="{{ __('Path') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.path"
                    id="webcheck{{$key}}-path"
                    name="webcheck{{$key}}-path"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.path" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-query" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-query"
                value="{{ __('Query') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.query"
                    id="webcheck{{$key}}-query"
                    name="webcheck{{$key}}-query"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.query" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-fragment" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-fragment"
                value="{{ __('Fragment') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.fragment"
                    id="webcheck{{$key}}-fragment"
                    name="webcheck{{$key}}-fragment"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.fragment" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-method" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-method"
                value="{{ __('Method') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <select
                    wire:model="webChecks.{{$key}}.method"
                    id="webcheck{{$key}}-method"
                    name="webcheck{{$key}}-method"
                    class="block py-2 pr-10 pl-3 w-full text-base rounded-md border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                >
                    <option value="GET">{{ __('GET') }} ({{ __('more methods coming soon') }})</option>
                </select>
                <x-jet-input-error for="webChecks.{{$key}}.method" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-expected-status" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-expectedStatus"
                value="{{ __('Expected HTTP Status') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.expectedStatus"
                    id="webcheck{{$key}}-expectedStatus"
                    name="webcheck{{$key}}-expectedStatus"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.expectedStatus" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-expected-pattern" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4">
            <x-jet-label
                class="col-span-2 mt-2"
                for="webcheck{{$key}}-expectedPattern"
                value="{{ __('Expected Pattern') }}"
            />
            <div class="col-span-6 w-full lg:col-span-5">
                <x-jet-input
                    wire:model="webChecks.{{$key}}.expectedPattern"
                    id="webcheck{{$key}}-expectedPattern"
                    name="webcheck{{$key}}-expectedPattern"
                    type="text"
                />
                <x-jet-input-error for="webChecks.{{$key}}.expectedPattern" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-search-source" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4 min-h-[38px]">
            <x-jet-label
                class="col-span-2 mt-2"
                for="searchSource"
                value="{{ __('Search Source') }}"
            />
            <div class="col-span-6 lg:col-span-5">
                <x-jet-checkbox
                    wire:model="webChecks.{{$key}}.searchSource"
                    id="webcheck{{$key}}-searchSource"
                    name="webcheck{{$key}}-searchSource"
                    id="searchSource"
                    name="searchSource"
                    type="text"
                    wire:click.stop=""
                />
                <x-jet-input-error for="webChecks.{{$key}}.searchSource" class="mt-1 w-full"/>
            </div>
        </div>
    </div>

    <div data-qa="web-headers" class="flex flex-col">
        <div class="flex flex-col space-y-1 sm:space-y-0 sm:flex-row sm:grid sm:grid-cols-8 sm:gap-4 min-h-[38px] @if(filled(optional($webCheck)['headers'])) sm:items-start sm:mt-[9px] @else sm:items-center @endif">
            <x-jet-label
                class="col-span-2"
                for="headers"
                value="{{ __('HTTP Headers') }}"
            />
            <div class="col-span-6 space-y-3 w-full lg:col-span-5">
                @foreach ($webCheck['headers'] ?? [] as $headerIndex => $header)
                    <div
                        wire:key="{{ $headerIndex }}"
                        class="flex justify-between items-center space-x-2"
                    >
                        <div class="flex-1 items-center space-y-1">
                            <div class="flex grid grid-cols-8" data-qa="web-header-value">
                                <x-jet-label
                                    for="webcheck{{$key}}-headers{{$headerIndex}}-key"
                                    value="{{ __('Header key') }}"
                                    class="col-span-2 mt-2"
                                />
                                <div class="col-span-6 w-full">
                                    <x-jet-input
                                        wire:model="webChecks.{{$key}}.headers.{{$headerIndex}}.key"
                                        id="webcheck{{$key}}-headers{{$headerIndex}}-key"
                                        name="webcheck{{$key}}-headers{{$headerIndex}}-key"
                                        type="text"
                                    />
                                    <x-jet-input-error
                                        for="webChecks.{{$key}}.headers.{{$headerIndex}}.key"
                                        class="mt-1 w-full"
                                    />
                                </div>
                            </div>
                            <div class="flex grid grid-cols-8" data-qa="web-header-key">
                                <x-jet-label
                                    for="webcheck{{$key}}-headers{{$headerIndex}}-value"
                                    value="{{ __('Header value') }}"
                                    class="col-span-2 mt-2"
                                />
                                <div class="col-span-6 w-full">
                                    <x-jet-input
                                        wire:model="webChecks.{{$key}}.headers.{{$headerIndex}}.value"
                                        id="webcheck{{$key}}-headers{{$headerIndex}}-value"
                                        name="webcheck{{$key}}-headers{{$headerIndex}}-value"
                                        type="text"
                                    />
                                    <x-jet-input-error
                                        for="webChecks.{{$key}}.headers.{{$headerIndex}}.value"
                                        class="mt-1 w-full"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            class="h-full cursor-pointer"
                            data-qa="web-delete-header"
                            wire:click="removeHeader('{{ $key }}', '{{ $headerIndex }}')"
                        >
                            <x-heroicon-s-x
                                class="w-5 h-5 text-gray-600 hover:text-red-500"
                            />
                        </div>
                    </div>
                @endforeach

                <x-add-web-check-header
                    :key="$key"
                    class="col-span-5 w-full"
                />
            </div>
        </div>
        <x-jet-input-error for="headers" class="mt-2 w-full"/>
    </div>
</div>
