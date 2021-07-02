<x-jet-modal max-width="2xl" {{ $attributes }}>
    <div class="bg-white p-gutter">
        <div class="sm:flex sm:items-start">
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <h3 class="text-lg font-bold">
                    {{ __('How does it work?') }}
                </h3>
                <div class="flex justify-end items-end w-full h-full">
                    <div
                        class="flex overflow-hidden flex-col h-full lg:h-auto"
                        x-data="{ play: false }"
                        x-init="$watch('play', (value) => {
                    if (value) {
                        $refs.video.playbackRate = 1.7;
                        $refs.video.play()
                    } else {
                        $refs.video.pause()
                    }
                })"
                    >
                        <div class="relative h-full">
                            <video
                                class="mx-auto w-full h-full"
                                x-ref="video"
                                @click="play = !play"
                            >
                                <source src="{{ mix('/videos/ping_video_0001-0432.webmhd.webm') }}">
                            </video>
                            <div
                                @click="play = true"
                                x-show="!play"
                                x-transition:leave="transition ease-in duration-250"
                                x-transition:leave-start="opacity-100 transform scale-100"
                                x-transition:leave-end="opacity-0 transform scale-90"
                                class="flex absolute inset-0 justify-center items-center w-full h-full cursor-pointer"
                            >
                                <svg class="w-28 h-28 text-blue-700 bg-lime-400 rounded-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-4 px-6 text-right bg-gray-100">
        <x-jet-secondary-button wire:click="$toggle('showHowItWorksVideo')">
            {{ __('Close') }}
        </x-jet-secondary-button>
    </div>
</x-jet-modal>
