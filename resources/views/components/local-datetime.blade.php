@props(['datetime'])

<span
    x-data="{
        datetime: '{{ $datetime->format('c') }}',
        language: document.querySelector('html').getAttribute('lang'),
    }"
    x-text="(new Date(datetime)).toLocaleString(language, {
        weekday:'long',
        year:'numeric',
        month:'long',
        day:'numeric',
        hour:'numeric',
        minute:'numeric',
        second:'numeric'
     })"
></span>
