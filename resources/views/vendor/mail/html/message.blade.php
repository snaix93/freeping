@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url'), 'level' => $level ?? ''])
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
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@isset($unsubscribe)
<br />
{{ $unsubscribe }}
@endisset
@endcomponent
@endslot
@endcomponent
