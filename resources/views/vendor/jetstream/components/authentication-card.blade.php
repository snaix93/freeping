<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-blue-700 bg-gradient-to-r from-blue-800 to-blue-500">
    <div>
        {{ $logo }}
    </div>

    @if($preContent ?? false)
        <div class="w-full sm:max-w-md">
            {{ $preContent }}
        </div>
    @endif

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
