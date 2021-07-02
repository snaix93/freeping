@props(['color' => 'gray'])

@switch($color)
    @case('gray')
    @php
        $colorInner = 'bg-gray-500';
        $colorOuter = 'bg-gray-400';
        $animate = '';
        $qaTag = 'gray-dot';
    @endphp
    @break
    @case('red')
    @php
        $colorInner = 'bg-red-500';
        $colorOuter = 'bg-red-400';
        $animate = 'animate-ping';
        $qaTag = 'red-dot';
    @endphp
    @break
    @case('orange')
    @php
        $colorInner = 'bg-orange-400';
        $colorOuter = 'bg-orange-300';
        $animate = 'animate-ping';
        $qaTag = 'orange-dot';
    @endphp
    @break
    @case('green')
    @php
        $colorInner = 'bg-green-600';
        $colorOuter = 'bg-green-500';
        $animate = '';
        $qaTag = 'green-dot';
    @endphp
    @break
    @case('light-gray')
    @php
        $colorInner = 'bg-gray-300';
        $colorOuter = 'bg-gray-300';
        $animate = 'animate-ping';
        $qaTag = 'light-gray-dot';
    @endphp
    @break
@endswitch

<span class="flex h-3 w-3 relative" data-qa="status {{ $qaTag }}">
    <span class="{{ $animate }} absolute inline-flex h-full w-full rounded-full {{ $colorOuter }} opacity-75"></span>
    <span class="relative inline-flex rounded-full h-3 w-3 {{ $colorInner }}"></span>
</span>
