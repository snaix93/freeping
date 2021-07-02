@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url'), 'level' => $level])
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

@if ($ad ?? false)
@slot('ad')
@component('mail::ad')
@endcomponent
@endslot
@endif

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
©2020-{{ date('Y') }} {{ config('app.name') }}.<br>
A product of cloudradar.io (cloudradar GmbH, Potsdam, Germany).<br>
@lang('All rights reserved.')<br>
All dates and times are UTC unless otherwise specified.<br>
@isset($unsubscribe)
<br />
{{ $unsubscribe }}
@endisset
@endcomponent
@endslot
@endcomponent
