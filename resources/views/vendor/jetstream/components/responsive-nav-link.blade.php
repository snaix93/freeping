@props(['active'])

@php
$classes = ($active ?? false)
            ? 'border-blue-400 text-gray-900 bg-blue-500 focus:outline-none focus:text-blue-800 focus:bg-blue-100 focus:border-blue-700'
            : 'border-transparent text-white hover:text-gray-800 hover:bg-blue-400 hover:border-blue-600 focus:outline-none focus:text-gray-900 focus:bg-blue-300 focus:border-blue-400';
@endphp

<a {{ $attributes->class(['text-base font-medium block pl-3 pr-4 py-2 border-l-4 transition duration-150 ease-in-out'])->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
