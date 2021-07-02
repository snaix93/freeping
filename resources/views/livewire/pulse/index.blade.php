<div
    class="flex relative flex-col flex-1 w-full bg-white"
    wire:poll.5s
>
    <div class="w-full h-16 bg-gray-50 border-b border-gray-100">
        <div class="flex justify-between items-center mx-auto space-x-4 max-w-7xl h-full p-gutter-x">
            <h1 class="text-xl font-semibold tracking-tight text-gray-800">
                {{ __('My Pulses') }}
            </h1>
            <livewire:pulse.pulse-create/>
        </div>
    </div>

    <div class="flex flex-1 w-full">

        @if($pulses->isNotEmpty())

            <div class="flex flex-1 mx-auto max-w-7xl lg:p-gutter-x">

                <div class="flex flex-col flex-1 bg-white border-l-0 border-gray-100 lg:z-10 lg:border-l lg:border-r">
                    @include('livewire.pulse.partials.pulse-list')
                </div>
            </div>

        @else
            @include('livewire.pulse.partials.no-pulses')
        @endif
    </div>
</div>
