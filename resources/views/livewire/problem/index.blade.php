<div
    class="flex relative flex-col flex-1 w-full bg-white"
    wire:poll.5s
>
    <div class="w-full h-16 bg-gray-50 border-b border-gray-100">
        <div class="flex justify-between items-center mx-auto space-x-4 max-w-7xl h-full p-gutter-x">
            <h1 class="text-xl font-semibold tracking-tight text-gray-800">
                {{ __('My Problems') }}
            </h1>
        </div>
    </div>

    <div class="flex flex-1 w-full">

        @if($problems->isNotEmpty() || !is_null($this->type))

            <div class="flex flex-1 mx-auto max-w-7xl lg:p-gutter-x">

                <div class="flex flex-col flex-1 bg-white border-l-0 border-gray-100 lg:z-10 lg:border-l lg:border-r">
                    @include('livewire.problem.partials.problem-list')
                </div>
            </div>

        @else
            @include('livewire.problem.partials.no-problems')
        @endif
    </div>
</div>
