<div class="flex relative flex-grow flex-shrink-0 items-center lg:flex-grow-0">
    <div class="flex justify-start items-center">
        <a href="/">
            <img
                class="w-auto h-10"
                src="{{ asset('/images/freeping-logo.svg') }}"
                alt="FreePing"
            >
        </a>
        <a href="/">
            <h2 class="ml-3 font-mono text-3xl font-extrabold text-white uppercase">
                <span class="text-gray-200">Free</span>Ping
            </h2>
        </a>
    </div>

    @if ($includeBroughtToYou ?? false)
        <div class="absolute top-9 left-10 ml-3 w-72 max-w-[250px]">
            <a
                href="{{ $cloudradarLink }}"
                target="_blank"
                class="inline-flex rounded bg-blue-600 px-2 py-1 text-xs text-opacity-90 font-semibold text-white tracking-tighter uppercase"
            >
                Brought to you by CloudRadar
            </a>
        </div>
    @endif
</div>
