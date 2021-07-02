@props(['ports', 'openPorts', 'customPorts'])

<div class="flex justify-between items-start mt-1 h-full sm:col-span-2 sm:mt-0">

    @if($openPorts->isEmpty() && $customPorts->isEmpty())
        <x-add-custom-port/>
    @else
        <div class="flex items-center flex-wrap -mb-0.5">
            @foreach($openPorts as $key => $port)
                <div wire:key="x-scanned-port-{{ $key }}">
                    <x-ports.scanned-port
                        :port="$port"
                        :ports="$ports"
                    />
                </div>
            @endforeach
            @foreach($customPorts as $key => $customPort)
                <div wire:key="{{ $key }}">
                    <x-ports.custom-port
                        wire:model.defer="customPorts.{{$key}}"
                        :key="$key"
                    />
                </div>
            @endforeach
        </div>

        <x-add-custom-port :withMessage="false"/>
    @endif
</div>

@error('customPorts.*')
<div class="text-sm text-red-500 sm:col-start-2 sm:col-span-2">
    {{ $message }}
</div>
@enderror
