@props(['message'])

<div
    {!! $attributes->merge(['class' => 'overflow-hidden rounded-lg']) !!}
    x-data="{ open: false }"
    x-ref="webCheckSuccessBanner"
    x-init="
        @this.on('notify-web-check-created', () => {
            if (open === false) {
                setTimeout(() => {
                    open = false;
                    $refs.webCheckSuccessBanner.removeAttribute('data-qa');
                }, 5000);
            }
            $refs.webCheckSuccessBanner.setAttribute('data-qa', 'web-check:success-banner');
            open = true;
        })
    "
    x-show.transition.out.duration.1000ms="open"
    style="display: none;"
>
    <x-banner :message="$message"/>
</div>
