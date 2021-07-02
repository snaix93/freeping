<div class="relative z-10 bg-blue-700 shadow-xl">
    <div class="mx-auto max-w-7xl">
        <div class="relative lg:w-2/5 xl:w-1/2 z-10 pt-24 pb-8 bg-blue-700 sm:pb-12 md:pb-14 lg:max-w-2xl">

            <svg class="hidden absolute inset-y-0 right-0 w-32 h-full text-blue-700 transform translate-x-1/2 lg:block" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100" />
            </svg>

            <div class="px-4 pt-10 lg:pb-6 mx-auto max-w-7xl sm:pt-12 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-xl text-center lg:text-left">
                    <h1 class="text-4xl tracking-tight text-gray-900 sm:text-5xl lg:text-5xl xl:text-6xl">
                      <span class="font-bold text-lime-400 md:text-transparent md:bg-clip-text md:bg-gradient-to-b md:from-lime-400 md:to-lime-500">
                        Reliable Alerts When Your Server Is Down
                      </span>
                    </h1>
                    <p class="mx-auto mt-3 max-w-md text-base text-white sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        100% free forever. No hidden catches
                    </p>
                </div>
            </div>
        </div>

        <div class="hidden bg-white sm:block h-88 lg:h-full lg:absolute lg:inset-y-0 lg:right-0 lg:w-3/5 xl:w-1/2">
            <div class="flex justify-end items-end w-full h-full">
                <div
                    class="hidden overflow-hidden h-full lg:h-auto flex-col sm:flex"
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
