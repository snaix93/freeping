@props(['active' => true, 'truncate' => false])

@if ($active)
    <div
        x-data
        x-init="tippy(document.getElementById('{{ $tooltipId = Illuminate\Support\Str::random() }}'), { allowHTML: true, appendTo: document.body, interactive: true })"
        wire:ignore
        wire:key="tippy_{{ $tooltipId }}"
    >
        <div id="{{ $tooltipId }}" class="cursor-help {{ $truncate ? 'truncate' : '' }}" data-tippy-content="{{ $content }}">
            {{ $slot }}
        </div>
    </div>
@else
    {{ $slot }}
@endif
