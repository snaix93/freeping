@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'), 'level' => $level])
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. A product of cloudradar.io (cloudradar GmbH, Potsdam, Germany). @lang('All rights reserved.')
            @isset($unsubscribe)
                <br />
                {{ $unsubscribe }}
            @endisset
        @endcomponent
    @endslot
@endcomponent
