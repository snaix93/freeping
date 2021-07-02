@props(['connect', 'webChecks' => []])

<div class="flex flex-col mt-1 h-full sm:mt-0">
    <div class="flex flex-col justify-center mb-0.5">

        @if(filled($webChecks))

            <div class="divide-y divide-gray-200 -mt-2">
                @foreach($webChecks as $key => $webCheck)
                    <div class="py-2">
                        <x-web-check.web-check
                            :key="$key"
                            :web-checks="$webChecks"
                            :web-check="$webCheck"
                        />
                    </div>
                @endforeach
            </div>

            <div class="flex justify-start items-center pt-3 w-full text-sm text-gray-700">
                <x-jet-button
                    wire:click.prevent.stop="addCheck('{{ $connect }}')"
                    type="button"
                    size="xxs"
                    color="white"
                    data-qa="add-web-check"
                >
                    <x-heroicon-s-plus class="w-4 h-4"/>
                    {{ __('Add web check for host') }}
                </x-jet-button>
            </div>

        @else
            <div class="flex items-center my-2 space-x-2 text-sm text-gray-700">
                <div>
                    <x-heroicon-s-information-circle
                        class="w-5 h-5 text-blue-500"
                    />
                </div>
                <div class="flex-1">
                    {{ __("We couldn't auto-discover any suitable web checks for you.") }}
                </div>
                <div class="self-start">
                    <x-jet-button
                        wire:click.prevent.stop="addCheck('{{ $connect }}')"
                        type="button"
                        size="xs"
                        color="white"
                    >
                        {{ __('Create web check') }}
                    </x-jet-button>
                </div>
            </div>
        @endif

    </div>

    @error('webChecks.*')
    <div class="text-sm text-red-500">
        {{ $message }}
    </div>
    @enderror
</div>
