@props(['value' => '', 'id' => null, 'label' => '', 'error' => null, 'ref' => null])

@php
    $summernoteId = $id ?? 'summernote-' . \Illuminate\Support\Str::random(8);
@endphp

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <div wire:ignore>
        <div id="{{ $summernoteId }}" class="summernote-editor">{!! $value !!}</div>
        <input type="hidden" id="{{ $summernoteId }}-input" value="{{ $value }}" @if($ref)data-summernote-{{ $ref }}="true"@endif>
    </div>
    @if($error)
        <p class="mt-1 text-xs text-red-600">{{ $error }}</p>
    @endif
</div>
