@props(['message'])

<div
    {!! $attributes->merge(['class' => 'overflow-hidden rounded-lg']) !!}
    x-data="{ open: false }"
    x-ref="webCheckUpdatedBanner"
    x-init="
        @this.on('notify-web-check-updated', () => {
            if (open === false) {
                setTimeout(() => {
                    open = false;
                    $refs.webCheckUpdatedBanner.removeAttribute('data-qa');
                }, 5000);
            }
            $refs.webCheckUpdatedBanner.setAttribute('data-qa', 'web-check:update-banner');
            open = true;
        })
    "
    x-show.transition.out.duration.1000ms="open"
    style="display: none;"
>
    <x-banner :message="$message"/>
</div>
