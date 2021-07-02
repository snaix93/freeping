@props(['country', 'size' => 'sm', 'rounded' => 'rounded-full'])

@switch($size)
    @case('lg')
    @php
        $size = '8';
    @endphp
    @break
    @case('sm')
    @php
        $size = '6';
    @endphp
    @break
@endswitch

@switch($country)
    @case('eu')
        <div class="w-{{ $size }} h-{{ $size }} shadow-sm hover:shadow {{ $rounded }} bg-eu-flag bg-cover bg-center"></div>
        @break
    @case('us')
        <div class="w-{{ $size }} h-{{ $size }} shadow-sm hover:shadow {{ $rounded }} bg-us-flag bg-cover bg-center"></div>
        @break
    @default
        <div class="w-{{ $size }} h-{{ $size }} shadow-sm hover:shadow {{ $rounded }} bg-cover bg-center"></div>
        @break
@endswitch
