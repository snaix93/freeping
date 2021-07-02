@props(['active'])

@php
$classes = ($active ?? false)
            ? 'border-lime-400 text-white'
            : 'border-transparent text-gray-100 hover:text-white hover:border-lime-400 focus:text-white';
@endphp

<a {{ $attributes->class(['inline-flex items-center px-1 pt-1 border-b-2 font-medium leading-5 text-sm focus:outline-none focus:border-blue-300 transition duration-150 ease-in-out'])->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
