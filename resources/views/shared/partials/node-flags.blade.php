@foreach($nodes as $node)
    <x-tooltip>
        <x-flag-icon :size="$size ?? null" :country="$node->country"/>
        <x-slot name="content">
            {{ $node->short_name }}
        </x-slot>
    </x-tooltip>
@endforeach
