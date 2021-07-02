@props(['message'])

<div
    {!! $attributes->merge(['class' => 'overflow-hidden rounded-lg']) !!}
    x-data="{ open: false }"
    x-ref="pingerUpdatedBanner"
    x-init="
        @this.on('notify-pinger-updated', () => {
            if (open === false) {
                setTimeout(() => {
                    open = false;
                    $refs.pingerUpdatedBanner.removeAttribute('data-qa');
                }, 5000);
            }
            $refs.pingerUpdatedBanner.setAttribute('data-qa', 'pinger:update-banner');
            open = true;
        })
    "
    x-show.transition.out.duration.1000ms="open"
    style="display: none;"
>
    <x-banner :message="$message"/>
</div>
