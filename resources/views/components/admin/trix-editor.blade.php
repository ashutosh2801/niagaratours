@props(['wire' => '', 'value' => '', 'id' => null, 'label' => '', 'error' => null])

@php
    $trixId = $id ?? 'trix-' . \Illuminate\Support\Str::random(8);
    $escapedValue = htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
@endphp

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <div wire:ignore>
        <input type="hidden" id="{{ $trixId }}" value='{!! $escapedValue !!}'>
        <trix-editor id="{{ $trixId }}-editor" input="{{ $trixId }}" class="trix-content" style="min-height: 12rem;"></trix-editor>
    </div>
    @if($error)
        <p class="mt-1 text-xs text-red-600">{{ $error }}</p>
    @endif
</div>