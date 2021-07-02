<x-home-layout>
    <div id="MultiCheckForm" class="relative -top-28 -mb-28">
        <livewire:register-with-multi-check/>
    </div>

    <div class="overflow-hidden py-16 bg-white lg:py-24">
        <div class="relative px-4 mx-auto max-w-xl sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="relative lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div class="relative">
                    <div>
                        <span class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        </span>
                    </div>
                    <h3 class="mt-4 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        Global checks every minute
                    </h3>
                    <p class="mt-4 text-lg text-gray-500">
                        {{ config('app.name') }} checks your server from up to four locations around the globe every 60 seconds.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Your servers are checked by:
                    </p>
                    <ul class="mt-2 text-base text-gray-500 list-disc pl-5">
                        <li>ICMP Ping Echo <span class="italic text-sm text-blue-500">...is the server alive?</span>
                        </li>
                        <li>TCP Port Scan
                            <span class="italic text-sm text-blue-500">...are services up and listening?</span></li>
                        <li>Website Checks <span class="italic text-sm text-blue-500">...is the content / HTTP status correct?</span>
                        </li>
                        <li>Pulses <span class="italic text-sm text-blue-500">...are servers on private networks up?</span>
                        </li>
                        <li>Transmitter <span class="italic text-sm text-blue-500">...our tiny agent monitors CPU, memory and disks.</span><span
                                class="bg-lime-400 ml-2 inline-flex items-center text-xs text-gray-900 text-opacity-60 rounded px-1.5 h-5">coming soon</span>
                        </li>
                        <li>Captures <span class="italic text-sm text-blue-500">...send any measurements and metrics to our Open Monitoring Connector.</span><span
                                class="bg-lime-400 ml-2 inline-flex items-center text-xs text-gray-900 text-opacity-60 rounded px-1.5 h-5">coming soon</span>
                        </li>
                        <li>SSL Certificate Supervising <span class="italic text-sm text-blue-500">...all certificates of your HTTPS web checks are supervised by default coming soon.</span><span
                                class="bg-lime-400 ml-2 inline-flex items-center text-xs text-gray-900 text-opacity-60 rounded px-1.5 h-5">coming soon</span>
                        </li>
                    </ul>
                    <p class="mt-4 text-lg text-gray-500">
                        In the event of a failure we will send you a notification by email and (optionally) Pushover.
                        When your server recovers we will let you know about that too.
                    </p>
                    <div class="mt-6">
                        <a
                            href="#MultiCheckForm"
                            class="uppercase inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        >
                            Get started
                        </a>
                    </div>
                </div>

                <div class="relative -mx-4 mt-10 lg:mt-0" aria-hidden="true">
                    <picture>
                        <source
                            type="image/avif"
                            srcset="
                                {{ mix('/images/pinger-w1200.avif') }} 1200w,
                                {{ mix('/images/pinger-w1038.avif') }} 1038w,
                                {{ mix('/images/pinger-w647.avif') }} 647w,
                                {{ mix('/images/pinger-w320.avif') }} 320w
                            "
                            sizes="(max-width: 1200px) 100vw, 1200px"
                        >
                        <source
                            type="image/webp"
                            srcset="
                                {{ mix('/images/pinger-w1200.webp') }} 1200w,
                                {{ mix('/images/pinger-w1038.webp') }} 1038w,
                                {{ mix('/images/pinger-w647.webp') }} 647w,
                                {{ mix('/images/pinger-w320.webp') }} 320w
                            "
                            sizes="(max-width: 1200px) 100vw, 1200px"
                        >
                        <img
                            class="relative mx-auto"
                            loading="lazy"
                            decoding="async"
                            style="background-size: cover; background-image: none;"
                            width="600"
                            src="{{ mix('/images/pinger.svg') }}"
                            height="468"
                            alt="Global checks on your host every 60 seconds"
                        >
                    </picture>
                </div>
            </div>

            <div class="relative mt-12 sm:mt-16 lg:mt-32">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
                    <div class="lg:col-start-2">
                        <div>
                        <span class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"/>
</svg>
                        </span>
                        </div>
                        <h3 class="mt-4 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                            Daily Reports
                        </h3>
                        <p class="mt-4 text-lg text-gray-500">
                            You will receive a report every 24 hours at your preferred time. Reports of different
                            targets are summarised - so it's always 1 email per day, regardless of how many hosts your
                            monitor.
                        </p>
                        <p class="mt-4 text-lg text-gray-500">
                            Pings are sent from all locations - if all fail you'll be alerted. If less than all of the
                            pings fail, you will receive a warning notification.
                        </p>
                        <div class="mt-6">
                            <a
                                href="#MultiCheckForm"
                                class="uppercase inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            >
                                Get started
                            </a>
                        </div>
                    </div>

                    <div class="relative -mx-4 mt-10 lg:mt-0 lg:col-start-1">
                        <picture>
                            <source
                                type="image/avif"
                                srcset="
                                    {{ mix('/images/alerts-down-console-w1200.avif') }} 1280w,
                                    {{ mix('/images/alerts-down-console-w671.avif') }} 671w,
                                    {{ mix('/images/alerts-down-console-w320.avif') }} 320w
                                "
                                sizes="(max-width: 1200px) 100vw, 1200px"
                            >
                            <source
                                type="image/webp"
                                srcset="
                                    {{ mix('/images/alerts-down-console-w1200.webp') }} 1280w,
                                    {{ mix('/images/alerts-down-console-w671.webp') }} 671w,
                                    {{ mix('/images/alerts-down-console-w320.webp') }} 320w
                                "
                                sizes="(max-width: 1200px) 100vw, 1200px"
                            >
                            <source
                                type="image/jpeg"
                                srcset="
                                    {{ mix('/images/alerts-down-console-w1200.jpg') }} 1280w,
                                    {{ mix('/images/alerts-down-console-w671.jpg') }} 671w,
                                    {{ mix('/images/alerts-down-console-w320.jpg') }} 320w
                                "
                                sizes="(max-width: 1200px) 100vw, 1200px"
                            >
                            <img
                                class="relative mx-auto"
                                loading="lazy"
                                decoding="async"
                                style="background-size: cover; background-image: none;"
                                width="600"
                                src="{{ mix('/images/alerts-down-console.jpg') }}"
                                height="468"
                                alt="Global checks on your host every 60 seconds"
                            >
                        </picture>
                    </div>
                </div>
            </div>

            <div class="relative mt-12 sm:mt-16 lg:mt-32 lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
                <div class="relative">
                    <div>
                        <span class="flex justify-center items-center w-10 h-10 text-white bg-blue-700 rounded-md">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
                        </span>
                    </div>
                    <h3 class="mt-4 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                        Simple Controls
                    </h3>
                    <p class="mt-4 text-lg text-gray-500">
                        You can stop the service at any time with a single click inside any of our emails.
                    </p>
                    <p class="mt-4 text-lg text-gray-500">
                        Using the service for the first time requires the confirmation of your email address. If your
                        email is already confirmed you can create up to 20 pingers per email address by just entering
                        the IP address or FQDN of your host.
                    </p>
                    <div class="mt-6">
                        <a
                            href="#MultiCheckForm"
                            class="uppercase inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        >
                            Get started
                        </a>
                    </div>
                </div>

                <div class="relative -mx-4 mt-10 lg:mt-0" aria-hidden="true">
                    <picture>
                        <source
                            type="image/avif"
                            srcset="
                                {{ mix('/images/uptime-report-w1200.avif') }} 1280w,
                                {{ mix('/images/uptime-report-w681.avif') }} 681w,
                                {{ mix('/images/uptime-report-w320.avif') }} 320w
                            "
                            sizes="(max-width: 1200px) 100vw, 1200px"
                        >
                        <source
                            type="image/webp"
                            srcset="
                                {{ mix('/images/uptime-report-w1200.webp') }} 1280w,
                                {{ mix('/images/uptime-report-w681.webp') }} 681w,
                                {{ mix('/images/uptime-report-w320.webp') }} 320w
                            "
                            sizes="(max-width: 1200px) 100vw, 1200px"
                        >
                        <source
                            type="image/jpeg"
                            srcset="
                                {{ mix('/images/uptime-report-w1200.jpg') }} 1280w,
                                {{ mix('/images/uptime-report-w681.jpg') }} 681w,
                                {{ mix('/images/uptime-report-w320.jpg') }} 320w
                            "
                            sizes="(max-width: 1200px) 100vw, 1200px"
                        >
                        <img
                            class="relative mx-auto"
                            loading="lazy"
                            decoding="async"
                            style="background-size: cover; background-image: none;"
                            width="600"
                            src="{{ mix('/images/uptime-report.jpg') }}"
                            height="468"
                            alt="Uptime report"
                        >
                    </picture>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white border-t border-gray-50">
        <div class="py-12 px-4 mx-auto max-w-7xl sm:py-16 sm:px-6 lg:px-8 lg:py-20">
            <dl class="text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
                <div class="flex flex-col items-center">
                    <div class="mt-2 text-lg font-medium leading-6 text-gray-800">
                        Crafted in Germany
                    </div>
                    <img
                        class="mt-4 w-28 rounded-2xl"
                        src="{{ mix('/images/germany-flag.png') }}"
                        alt="Germany"
                    >
                </div>
                <div class="flex flex-col items-center mt-10 sm:mt-0">
                    <div class="mt-2 text-lg font-medium leading-6 text-gray-800">
                        Powered By
                    </div>
                    <img
                        class="mt-4 w-28 rounded-2xl"
                        src="{{ mix('/images/scaleway.png') }}"
                        alt="Scaleway"
                    >
                </div>
                <div class="flex flex-col items-center mt-10 sm:mt-0">
                    <div class="mt-2 text-lg font-medium leading-6 text-gray-800">
                        Hosted In The EU
                    </div>
                    <img
                        class="mt-4 w-28 rounded-2xl"
                        src="{{ mix('/images/eu-flag.png') }}"
                        alt="EU"
                    >
                </div>
            </dl>
        </div>
    </div>

    <section class="overflow-hidden bg-gray-50">
        <div class="relative px-4 pt-20 pb-12 mx-auto max-w-7xl sm:px-6 lg:px-8 lg:py-20">
            <div class="relative lg:flex lg:items-center">
                <div class="hidden lg:block lg:flex-shrink-0">
                    <img
                        class="w-64 h-64 rounded-full xl:h-80 xl:w-80"
                        src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=500&h=500&q=80"
                        alt="Sebastian Graef"
                    >
                </div>
                <div class="relative lg:ml-10">
                    <svg
                        class="absolute top-0 left-0 w-36 h-36 text-blue-500 opacity-50 transform -translate-x-8 -translate-y-24"
                        stroke="currentColor" fill="none" viewBox="0 0 144 144" aria-hidden="true">
                        <path stroke-width="2"
                              d="M41.485 15C17.753 31.753 1 59.208 1 89.455c0 24.664 14.891 39.09 32.109 39.09 16.287 0 28.386-13.03 28.386-28.387 0-15.356-10.703-26.524-24.663-26.524-2.792 0-6.515.465-7.446.93 2.327-15.821 17.218-34.435 32.11-43.742L41.485 15zm80.04 0c-23.268 16.753-40.02 44.208-40.02 74.455 0 24.664 14.891 39.09 32.109 39.09 15.822 0 28.386-13.03 28.386-28.387 0-15.356-11.168-26.524-25.129-26.524-2.792 0-6.049.465-6.98.93 2.327-15.821 16.753-34.435 31.644-43.742L121.525 15z"/>
                    </svg>
                    <blockquote class="relative">
                        <div class="text-2xl font-semibold leading-9 text-gray-900">
                            <p>
                                &ldquo;Regardless which monitoring you use, freeping.io is a must-have for any sysadmin.&rdquo;
                            </p>
                        </div>
                        <footer class="mt-8">
                            <div class="flex">
                                <div class="flex-shrink-0 lg:hidden">
                                    <img
                                        class="w-12 h-12 rounded-full"
                                        src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=200&h=200&q=80"
                                        alt="Sebastian Graef"
                                    >
                                </div>
                                <div class="ml-4 text-base text-gray-900 lg:ml-0">
                                    <div class="font-bold">Sebastian Graef</div>
                                    <div>Owner, <span class="text-blue-700">Monitoring Consultant</span></div>
                                </div>
                            </div>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
