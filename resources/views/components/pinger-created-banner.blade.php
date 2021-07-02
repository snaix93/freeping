@props(['message'])

<div
    {!! $attributes->merge(['class' => 'overflow-hidden rounded-lg']) !!}
    x-data="{ open: false }"
    x-ref="pingerSuccessBanner"
    x-init="
        @this.on('notify-pinger-created', () => {
            if (open === false) {
                setTimeout(() => {
                    open = false;
                    $refs.pingerSuccessBanner.removeAttribute('data-qa');
                }, 5000);
            }
            $refs.pingerSuccessBanner.setAttribute('data-qa', 'pinger:success-banner');
            open = true;
        })
    "
    x-show.transition.out.duration.1000ms="open"
    style="display: none;"
>
    <x-banner :message="$message"/>
</div>
