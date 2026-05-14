@props(['items' => []])

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    <nav class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
        <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600 transition-colors whitespace-nowrap">Home</a>
        @foreach($items as $item)
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            @if(isset($item['url']) && $item['url'])
                <a href="{{ $item['url'] }}" wire:navigate class="hover:text-primary-600 transition-colors whitespace-nowrap">{{ $item['label'] }}</a>
            @else
                <span class="text-gray-900 font-medium">{{ $item['label'] }}</span>
            @endif
        @endforeach
    </nav>
</div>
