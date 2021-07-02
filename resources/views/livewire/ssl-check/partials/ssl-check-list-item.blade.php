<li
    class="h-16"
    wire:key="sslCheckItem_{{ $sslCheck->encodeId() }}"
    data-qa="sslCheck"
>
    <div class="flex space-x-4 w-full h-full p-gutter-x">
        <div class="grid flex-1 grid-cols-12 space-x-4">
            <div class="flex flex-col flex-1 col-span-4 justify-center">
                <div>
                    <x-tooltip>
                        <p class="text-xs font-medium text-gray-800 md:text-sm truncate">
                            {{ $sslCheck->host }}:{{$sslCheck->port}}
                        </p>
                        <x-slot name="content">
                            {{ $sslCheck->host }}:{{$sslCheck->port}}
                        </x-slot>
                    </x-tooltip>
                </div>
            </div>
            <div class="flex col-span-4 items-center">
                <div class="pr-4">
                    @if($sslCheck->last_error_text)
                        <div>
                            <x-tooltip>
                                <p class="text-xs font-medium text-gray-800 md:text-sm truncate">
                                    <x-ssl-certificate-status-icon :status="$sslCheck->certificate_status->value"/>
                                </p>
                                <x-slot name="content">
                                    {{$sslCheck->last_error_text}}
                                </x-slot>
                            </x-tooltip>
                        </div>
                    @else
                        <x-ssl-certificate-status-icon :status="$sslCheck->certificate_status->value"/>
                    @endif
                </div>
                <p class="text-xs text-gray-700 md:text-sm truncate">
                    {{ $sslCheck->certificate_expires_at }}
                </p>
            </div>
            <div class="flex flex-col flex-1 col-span-4 justify-center">
                <p class="flex flex-col text-sm text-gray-600 md:flex-row md:space-x-1">
                    @if($sslCheck->last_check_received_at)
                        <x-local-datetime :datetime="$sslCheck->last_check_received_at"/>
                    @endif
                </p>
            </div>


        </div>
    </div>
</li>
