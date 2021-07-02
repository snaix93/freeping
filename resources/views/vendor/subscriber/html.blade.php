@component('subscriber::mail.html.message', ['level' => $level, 'ad' => $ad ?? false])

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

@isset($table)
@component('mail::table')
{{ $table }}
@endcomponent
@endisset

{{-- Action Button --}}
@isset($actionText)
<?php
switch ($level) {
case 'success':
case 'error':
$color = $level;
break;
default:
$color = 'primary';
}
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
"If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
'into your web browser:',
[
'actionText' => $actionText,
]
) <div class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</div>
@endslot
@endisset
@slot('unsubscribe')
@if($unsubscribeLink ?? false)
@lang(
'To stop this check use this [link](:link).',
['link' => $unsubscribeLink]
)
@endif
@if($unsubscribeLinkForAll ?? false)
<br />
@lang(
'To stop & unsubscribe from all checks for this email address use this [link](:link).',
['link' => $unsubscribeLinkForAll]
)
@endif
@endslot

@endcomponent
