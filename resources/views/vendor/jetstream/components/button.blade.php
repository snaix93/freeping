{{--
SIZES: xs, sm, md, lg, xl
COLORS: primary/blue (default), secondary/lime
--}}
@props(['color' => 'blue', 'size' => 'md'])

<button {{ $attributes->class([
    'px-1.5 py-0.5 text-[11px] font-medium rounded' => $size === 'xxs',
    'px-2.5 py-1.5 text-xs font-medium rounded' => $size === 'xs',
    'px-3 py-2 text-sm leading-4 font-medium rounded-md' => $size === 'sm',
    'px-4 py-2 text-sm leading-4 font-medium rounded-md' => $size === 'md',
    'px-4 py-2 text-base font-medium rounded-md' => $size === 'lg',
    'px-6 py-3 text-base font-medium rounded-md' => $size === 'xl',
    'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' => in_array($color, ['primary', 'blue']),
    'text-gray-900 font-bold bg-lime-400 hover:bg-lime-600 hover:text-white focus:ring-lime-400' => in_array($color, ['secondary', 'lime']),
    'text-gray-900 font-bold border border-gray-200 bg-white hover:bg-gray-200 hover:text-gray-700 focus:ring-gray-400' => in_array($color, ['white']),
])->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:bg-gray-200 disabled:text-gray-400'
]) }}
>
    {{ $slot }}
</button>
