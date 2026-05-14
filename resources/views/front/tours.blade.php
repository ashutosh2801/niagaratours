<div>
    <section class="bg-gray-50 border-b border-gray-200">
        <x-breadcrumbs :items="[
            ['label' => 'All Tours'],
        ]" />
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
            <h1 class="text-3xl font-bold text-gray-900">All Tours</h1>
            <p class="mt-2 text-gray-600">Explore our complete collection of Niagara Falls tours and experiences.</p>
        </div>
    </section>

    <section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <aside class="lg:col-span-1 mb-8 lg:mb-0">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Search</h3>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search tours..." class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Category</h3>
                        <div class="space-y-2">
                            @foreach($categories ?? [] as $category)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" wire:model.live="selectedCategories" value="{{ $category->id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ $category->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Price Range</h3>
                        <div class="flex items-center justify-between text-sm text-gray-700 mb-2" x-data="{ min: $wire.entangle('min_price'), max: $wire.entangle('max_price') }">
                            <span x-text="'$' + Number(min).toLocaleString()">${{ number_format($min_price) }}</span>
                            <span x-text="'$' + Number(max).toLocaleString()">${{ number_format($max_price) }}</span>
                        </div>
                        <div class="relative h-6" x-data="{
                            min: $wire.entangle('min_price'),
                            max: $wire.entangle('max_price'),
                            minRange: 0,
                            maxRange: 1000,
                            init() {
                                this.$watch('min', v => { if (v > this.max) this.min = this.max; });
                                this.$watch('max', v => { if (v < this.min) this.max = this.min; });
                            }
                        }">
                            <div class="absolute top-1/2 -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full"></div>
                            <div class="absolute top-1/2 -translate-y-1/2 h-1 bg-primary-500 rounded-full" :style="'left: ' + (min / maxRange * 100) + '%; width: ' + ((max - min) / maxRange * 100) + '%'"></div>
                            <input type="range" x-model="min" :min="minRange" :max="max" step="10" class="absolute top-0 w-full h-full appearance-none bg-transparent pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-primary-500 [&::-webkit-slider-thumb]:shadow [&::-webkit-slider-thumb]:cursor-pointer [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:border-2 [&::-moz-range-thumb]:border-primary-500 [&::-moz-range-thumb]:shadow [&::-moz-range-thumb]:cursor-pointer">
                            <input type="range" x-model="max" :min="min" :max="maxRange" step="10" class="absolute top-0 w-full h-full appearance-none bg-transparent pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto [&::-webkit-slider-thumb]:w-4 [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-primary-500 [&::-webkit-slider-thumb]:shadow [&::-webkit-slider-thumb]:cursor-pointer [&::-moz-range-thumb]:pointer-events-auto [&::-moz-range-thumb]:w-4 [&::-moz-range-thumb]:h-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:border-2 [&::-moz-range-thumb]:border-primary-500 [&::-moz-range-thumb]:shadow [&::-moz-range-thumb]:cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Duration</h3>
                        <div class="space-y-2">
                            @php
                                $durations = [
                                    ['label' => 'Under 2 hours', 'min' => 0, 'max' => 2],
                                    ['label' => '2 - 4 hours', 'min' => 2, 'max' => 4],
                                    ['label' => '4 - 8 hours', 'min' => 4, 'max' => 8],
                                    ['label' => 'Full Day (8+ hrs)', 'min' => 8, 'max' => 24],
                                    ['label' => 'Multi-Day', 'min' => 24, 'max' => null],
                                ];
                            @endphp
                            @foreach($durations as $duration)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" wire:model.live="selectedDurations" value="{{ $duration['min'] }}-{{ $duration['max'] }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-900">{{ $duration['label'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button wire:click="resetFilters" class="w-full px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Clear All Filters
                    </button>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <p class="text-sm text-gray-600">
                        Showing <span class="font-medium text-gray-900">{{ $tours->firstItem() ?? 0 }}</span>
                        - <span class="font-medium text-gray-900">{{ $tours->lastItem() ?? 0 }}</span>
                        of <span class="font-medium text-gray-900">{{ $tours->total() ?? 0 }}</span> tours
                    </p>
                    <div class="flex items-center gap-3">
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select wire:model.live="sortBy" class="text-sm border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                            <option value="latest">Latest</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="popular">Most Popular</option>
                            <option value="rating">Highest Rated</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($tours ?? [] as $tour)
                        <div class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $tour->featured_image ?? $tour->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @if($tour->category)
                                    <span class="absolute top-3 left-3 px-3 py-1 bg-primary-600 text-white text-xs font-medium rounded-full">{{ $tour->category->name }}</span>
                                @endif
                                @if($tour->sale_price)
                                    <span class="absolute top-3 right-3 px-3 py-1 bg-red-500 text-white text-xs font-medium rounded-full">Sale</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>{{ $tour->title }}</a>
                                </h3>
                                @if($tour->short_description)
                                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $tour->short_description }}</p>
                                @endif
                                <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $tour->location ?? 'Niagara Falls' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $tour->duration ?? '2 hours' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($tour->rating ?? 5))
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endif
                                    @endfor
                                    <span class="text-sm text-gray-500 ml-1">({{ $tour->review_count ?? 0 }})</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($tour->sale_price)
                                            <span class="text-lg font-bold text-gray-900">From ${{ number_format($tour->sale_price, 2) }}</span>
                                            <span class="text-sm text-gray-400 line-through ml-2">${{ number_format($tour->price, 2) }}</span>
                                        @elseif($tour->price)
                                            <span class="text-lg font-bold text-gray-900">From ${{ number_format($tour->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="inline-flex items-center gap-1 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                                        Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">No tours found</h3>
                            <p class="text-gray-500">Try adjusting your filters or search criteria.</p>
                        </div>
                    @endforelse
                </div>

                @if(method_exists($tours ?? [], 'links'))
                    <div class="mt-8">
                        {{ $tours->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
</div>
