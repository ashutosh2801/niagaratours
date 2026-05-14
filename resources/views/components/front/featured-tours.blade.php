<section class="py-16 md:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Popular Tours</h2>
            <p class="mt-3 text-lg text-gray-600">Handpicked experiences that showcase the best of Niagara Falls and the surrounding region.</p>
        </div>

        @if($tours && $tours->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($tours as $tour)
                    <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 flex flex-col">
                        <div class="relative aspect-video overflow-hidden bg-gray-200">
                            @php $tourImg = $tour->featured_image ?? $tour->images[0] ?? null; @endphp
                            @if($tourImg)
                                <img src="{{ $tourImg }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-primary-100 to-purple-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/></svg>
                                </div>
                            @endif
                            @if(isset($tour->category))
                                <span class="absolute top-3 left-3 px-3 py-1 text-xs font-semibold text-white bg-primary-600 rounded-full">{{ $tour->category->name ?? '' }}</span>
                            @endif
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $tour->title }}</h3>

                            <div class="mt-3 space-y-1.5 flex-1">
                                @if(isset($tour->location))
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $tour->location }}
                                    </div>
                                @endif
                                @if(isset($tour->duration))
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        {{ $tour->duration }}
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    @if(isset($tour->original_price) && $tour->original_price > $tour->price)
                                        <span class="text-sm text-gray-400 line-through mr-1">${{ number_format($tour->original_price, 2) }}</span>
                                    @endif
                                    <span class="text-xl font-bold text-primary-600">From ${{ number_format($tour->price, 2) }}</span>
                                </div>
                                @if(isset($tour->rating))
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="ml-1 text-sm text-gray-600">{{ $tour->rating }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-4">
                                <span class="block w-full text-center px-4 py-2.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold text-sm rounded-lg transition-colors duration-200">
                                    Book Now
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <svg class="mx-auto w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/></svg>
                <p class="mt-4 text-lg text-gray-500">No tours available at the moment.</p>
            </div>
        @endif
    </div>
</section>
