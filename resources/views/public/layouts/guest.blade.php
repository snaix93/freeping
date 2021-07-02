<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - free icmp ping, tcp check, web-check service</title>
    @include('shared.partials.favicons')
    @include('shared.partials.fonts')
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    @include('googletagmanager::head')
    @livewireStyles
</head>
<body class="font-sans antialiased {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
@include('googletagmanager::body')
<div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
</div>
@livewireScripts
</body>
</html>
