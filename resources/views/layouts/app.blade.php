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
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    @include('googletagmanager::head')
    @livewireStyles
</head>
<body class="font-sans antialiased {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
@include('googletagmanager::body')

<x-jet-banner/>

<div class="flex relative flex-col min-h-screen">
    <livewire:navigation-menu/>

    <main class="flex flex-col flex-1 bg-gray-100">
        {{ $slot }}
    </main>

    <div class="flex-shrink bg-gray-50 border-t border-gray-100">
        @include('shared.partials.footer')
    </div>
</div>

@stack('modals')

@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/alpine-collective/alpine-magic-helpers@1.1.x/dist/screen.min.js"></script>
@stack('scripts')
</body>
</html>
