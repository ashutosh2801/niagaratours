<div x-data="{ current: 0, total: {{ count($slides) ?: 1 }} }" x-init="if (total > 1) { setInterval(() => { current = (current + 1) % total }, 5000) }" class="relative bg-gray-900 overflow-hidden" style="min-height: 70vh;">

    @if(!empty($slides))
        @foreach($slides as $i => $slide)
            @php
                $linkUrl = '#';
                if (($slide['link_type'] ?? '') === 'tour' && !empty($slide['link_value'])) {
                    $linkUrl = route('tour.detail', $slide['link_value']);
                } elseif (($slide['link_type'] ?? '') === 'tours') {
                    $linkUrl = route('tours');
                } elseif (($slide['link_type'] ?? '') === 'custom' && !empty($slide['link_value'])) {
                    $linkUrl = $slide['link_value'];
                }
            @endphp
            <div x-show="current === {{ $i }}" x-cloak class="absolute inset-0 transition-opacity duration-700" x-transition:enter.duration.700 x-transition:leave.duration.300>
                <div class="absolute inset-0">
                    <img src="{{ $slide['image'] ?: 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920' }}" alt="{{ $slide['title'] ?? '' }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/80 via-gray-900/60 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                </div>
                <div class="relative h-full flex items-center" style="min-height: 70vh;">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-2xl">
                            <h2 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight">{{ $slide['title'] ?? '' }}</h2>
                            @if(!empty($slide['description']))
                                <p class="mt-4 text-lg md:text-xl text-gray-200 leading-relaxed">{{ $slide['description'] }}</p>
                            @endif
                            <div class="mt-8">
                                <a href="{{ $linkUrl }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors shadow-lg text-lg">
                                    View Details
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @if(count($slides) > 1)
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex items-center gap-2 z-10">
                @foreach($slides as $i => $slide)
                    <button @click="current = {{ $i }}" class="w-2.5 h-2.5 rounded-full transition-all duration-300" :class="current === {{ $i }} ? 'bg-white w-8' : 'bg-white/40 hover:bg-white/60'"></button>
                @endforeach
            </div>
        @endif
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-700 to-purple-800"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36 lg:py-44" style="min-height: 70vh; display: flex; align-items: center;">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight">Discover Niagara Falls & Beyond</h1>
                <p class="mt-4 text-lg md:text-xl text-gray-200 max-w-2xl leading-relaxed">Experience the majesty of Niagara Falls with our expertly curated tours. Book your adventure today and create memories that last a lifetime.</p>
            </div>
        </div>
    @endif
</div>
