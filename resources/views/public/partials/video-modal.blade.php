<div
    class="hidden sm:flex overflow-hidden flex-col mt-8 rounded-2xl shadow-lg"
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
    <div class="relative flex-shrink-0">
        <video
            class="mx-auto rounded-2xl"
            x-ref="video"
            @click="play = !play"
        >
            <source
                src="{{ asset('/videos/ping_video_0001-0432.webmhd.webm') }}"
            >
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
