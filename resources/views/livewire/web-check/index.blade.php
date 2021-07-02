<div
    x-data="{ showSlideOver: @entangle('showSlideOver') }"
    class="flex relative flex-col flex-1 w-full bg-white"
    wire:poll.5s
>
    <div class="w-full h-16 bg-gray-50 border-b border-gray-100">
        <div class="flex justify-between items-center mx-auto space-x-4 max-w-7xl h-full p-gutter-x">
            <h1 class="text-xl font-semibold tracking-tight text-gray-800">
                {{ __('My Web Checks') }}
            </h1>
            <livewire:web-check.web-check-create/>
        </div>
    </div>

    <x-web-check-created-banner
        message="{{ __('Your web checks were successfully created!') }}"
        class="rounded-none"
    />
    <x-web-check-updated-banner
        message="{{ __('Your web checks were successfully updated!') }}"
        class="rounded-none"
    />

    <div class="flex flex-1 w-full">

        @if($webChecks->isNotEmpty())

            <div class="flex flex-1 mx-auto max-w-7xl lg:p-gutter-x lg:divide-x lg:divide-gray-100 lg:divide-solid">

                <div class="flex flex-col flex-1 bg-white border-l-0 border-gray-100 lg:z-10 lg:border-l shadow-right">
                    @include('livewire.web-check.partials.web-check-list')
                </div>

                <div
                    x-show="showSlideOver && !$screen('lg')"
                    class="block fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity lg:hidden"
                    aria-hidden="true"
                    x-transition:enter="ease-out duration-500 sm:duration-700"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                ></div>

                <div class="
                    \all\ flex divide-y divide-gray-100 divide-solid overscroll-contain
                    \xs\  fixed inset-0 bg-transparent
                    \sm\
                    \md\
                    \lg\  lg:w-[600px] lg:h-full lg:top-0 lg:transform-none lg:relative lg:bg-gray-50
                    \xl\  xl:w-[650px]
                    \2xl\ 2xl:w-[700px]
                "
                     x-show="showSlideOver || $screen('lg')"
                     x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                >
                    <div class="
                        \all\ flex-1 flex flex-col absolute inset-0 relative
                        \xs\ pl-16 overflow-y-scroll overflow-x-hidden overscroll-contain
                        \sm\
                        \md\
                        \lg\ lg:pl-0
                    "
                         @click.self="showSlideOver = !showSlideOver"
                    >
                        <a
                            href="#"
                            class="flex fixed top-4 left-4 justify-center items-center w-8 h-8 bg-white rounded hover:bg-gray-200 lg:hidden focus:bg-gray-50"
                            @click.stop.prevent="showSlideOver = !showSlideOver"
                        >
                            <x-heroicon-s-x class="w-5 h-5 text-gray-800"/>
                        </a>

                        @include('livewire.web-check.partials.web-check-details', [
                            'webCheck' => $this->webCheck
                        ])
                    </div>
                </div>
            </div>
        @else
            @include('livewire.web-check.partials.no-web-checks')
        @endif
    </div>
</div>
