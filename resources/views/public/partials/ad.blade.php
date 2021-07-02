<div class="bg-white">
    <div class="py-16 px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-blue-700 rounded-lg shadow-xl lg:grid lg:grid-cols-2 lg:gap-4">
            <div class="px-6 pt-10 pb-12 sm:pt-16 sm:px-16 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
                <div class="lg:self-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block">In need of more robust server monitoring?</span>
                    </h2>
                    <p class="mt-4 text-lg leading-6 text-blue-200">
                        Start your free trial today with CloudRadar.io.
                    </p>
                    <p class="mt-4 text-base leading-6 text-white">
                        Set up your entire server and network monitoring in less than 20 minutes.
                    </p>
                    <p class="mt-4 text-base leading-6 text-white">
                        "Server Monitoring Has Never Been Easier"...
                    </p>
                    <a
                        href="{{ $cloudradarLink }}"
                        target="_blank"
                        class="inline-flex py-1 px-3 mt-10 text-base font-medium text-white uppercase bg-gray-400 rounded-md border-2 border-transparent shadow-sm hover:bg-transparent hover:border-gray-400"
                    >
                        Sign up for your free 15-day trial
                    </a>
                    <p class="mt-3 text-sm text-white">
                        No credit card required.
                    </p>
                </div>
            </div>
            <div class="-mt-6 aspect-w-5 aspect-h-3 md:aspect-w-2 md:aspect-h-1">
                <picture>
                    <source
                        type="image/avif"
                        srcset="
                            {{ asset('/images/cloudradar-screenshot-w1000.avif') }} 1000w,
                            {{ asset('/images/cloudradar-screenshot-w804.avif') }} 804w,
                            {{ asset('/images/cloudradar-screenshot-w724.avif') }} 724w,
                            {{ asset('/images/cloudradar-screenshot-w604.avif') }} 604w,
                            {{ asset('/images/cloudradar-screenshot-w471.avif') }} 471w,
                            {{ asset('/images/cloudradar-screenshot-w320.avif') }} 320w
                        "
                        sizes="(max-width: 1000px) 100vw, 1000px"
                    >
                    <source
                        type="image/webp"
                        srcset="
                            {{ asset('/images/cloudradar-screenshot-w1000.webp') }} 1000w,
                            {{ asset('/images/cloudradar-screenshot-w804.webp') }} 804w,
                            {{ asset('/images/cloudradar-screenshot-w724.webp') }} 724w,
                            {{ asset('/images/cloudradar-screenshot-w604.webp') }} 604w,
                            {{ asset('/images/cloudradar-screenshot-w471.webp') }} 471w,
                            {{ asset('/images/cloudradar-screenshot-w320.webp') }} 320w
                        "
                        sizes="(max-width: 1000px) 100vw, 1000px"
                    >
                    <source
                        type="image/jpeg"
                        srcset="
                            {{ asset('/images/cloudradar-screenshot-w1000.jpg') }} 1000w,
                            {{ asset('/images/cloudradar-screenshot-w804.jpg') }} 804w,
                            {{ asset('/images/cloudradar-screenshot-w724.jpg') }} 724w,
                            {{ asset('/images/cloudradar-screenshot-w604.jpg') }} 604w,
                            {{ asset('/images/cloudradar-screenshot-w471.jpg') }} 471w,
                            {{ asset('/images/cloudradar-screenshot-w320.jpg') }} 320w
                        "
                        sizes="(max-width: 1000px) 100vw, 1000px"
                    >
                    <img
                        class="transform translate-x-6 translate-y-6 sm:translate-x-16 lg:translate-y-20 object-cover object-left-top rounded-md"
                        loading="lazy"
                        decoding="async"
                        width="1000"
                        src="{{ asset('/images/cloudradar-screenshot.jpg') }}"
                        height="612"
                        alt="CloudRadar.io screenshot"
                    >
                </picture>
            </div>
        </div>
    </div>
</div>
