<div>
    {{-- Hero Image Section --}}
    @php
        $allImages = $tour->images ?? [];
        if ($tour->featured_image && !in_array($tour->featured_image, $allImages)) {
            array_unshift($allImages, $tour->featured_image);
        }
    @endphp
    <div class="relative bg-gray-900 max-w-7xl mx-auto" x-data="{ selected: '{{ ($allImages[0] ?? '') }}' }">
        <div class="aspect-[21/9] max-h-[33rem] overflow-hidden">
            @if(!empty($allImages[0]))
                <img :src="selected" src="{{ $allImages[0] }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary-800 to-purple-900"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-transparent pointer-events-none"></div>
        </div>

        @if(count($allImages) > 1)
            <div class="absolute bottom-4 left-4 right-4 flex gap-2 overflow-x-auto pb-1 z-10">
                @foreach($allImages as $img)
                    <div @click="selected = '{{ $img }}'" :class="{ 'border-primary-400 ring-2 ring-primary-500': selected === '{{ $img }}', 'border-white/30': selected !== '{{ $img }}' }" class="w-20 h-14 rounded-lg overflow-hidden border-2 shrink-0 cursor-pointer hover:opacity-90 transition-all">
                        <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Tour Info Header --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Left Column --}}
            <div class="lg:w-2/3">
                <div class="flex flex-wrap items-center gap-3 mb-3">
                    @if(isset($tour->category))
                        <span class="px-3 py-1 text-xs font-semibold text-white bg-primary-600 rounded-full">{{ $tour->category->name ?? '' }}</span>
                    @endif
                    @if(isset($tour->duration))
                        <span class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $tour->duration }}
                        </span>
                    @endif
                    @if(isset($tour->location))
                        <span class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $tour->location }}
                        </span>
                    @endif
                    @if(isset($tour->rating))
                        <span class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="ml-1 text-gray-700 font-medium">{{ $tour->rating }}</span>
                            <span class="ml-1 text-gray-400">({{ $tour->review_count ?? 0 }} reviews)</span>
                        </span>
                    @endif
                </div>

                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $tour->title }}</h1>

                {{-- Content Sections --}}
                <div class="mt-8 space-y-10">
                    {{-- Overview --}}
                    @if(isset($tour->description) && $tour->description)
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Overview</h2>
                            <div class="prose prose-gray max-w-none">
                                {!! $tour->description !!}
                            </div>
                        </div>
                    @endif

                    {{-- Highlights --}}
                    @if(isset($tour->highlights) && count($tour->highlights))
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Highlights</h2>
                            <ul class="space-y-3">
                                @foreach($tour->highlights as $highlight)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-primary-600 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span class="text-gray-700">{{ $highlight }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Itinerary --}}
                    @if(isset($tour->itinerary) && count($tour->itinerary))
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Itinerary</h2>
                            <div class="space-y-6">
                                @foreach($tour->itinerary as $day)
                                    <div class="flex gap-4">
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-sm">{{ $loop->iteration }}</div>
                                            @if(!$loop->last)
                                                <div class="w-0.5 flex-1 bg-gray-200 mt-2"></div>
                                            @endif
                                        </div>
                                        <div class="pb-6">
                                            <h4 class="font-semibold text-gray-900">{{ $day['title'] ?? 'Day ' . $loop->iteration }}</h4>
                                            <p class="mt-1 text-gray-600">{!! $day['description'] ?? '' !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Inclusions & Exclusions --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @if(isset($tour->inclusions) && count($tour->inclusions))
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Inclusions</h2>
                                <ul class="space-y-3">
                                    @foreach($tour->inclusions as $item)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="text-gray-700">{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($tour->exclusions) && count($tour->exclusions))
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 mb-4">Exclusions</h2>
                                <ul class="space-y-3">
                                    @foreach($tour->exclusions as $item)
                                        <li class="flex items-start">
                                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="text-gray-700">{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- FAQs --}}
                    @if(isset($tour->faqs) && count($tour->faqs))
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 mb-4">FAQs</h2>
                            <div class="space-y-3">
                                @foreach($tour->faqs as $faq)
                                    <div x-data="{ open: false }" class="border border-gray-200 rounded-xl overflow-hidden">
                                        <button @click="open = !open" class="w-full flex justify-between items-center px-5 py-4 text-left bg-white hover:bg-gray-50 transition-colors">
                                            <span class="font-medium text-gray-900">{{ $faq['question'] ?? '' }}</span>
                                            <svg x-show="!open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            <svg x-show="open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                        </button>
                                        <div x-show="open" x-cloak class="px-5 pb-4 text-gray-600">
                                            {!! $faq['answer'] ?? '' !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column -- Sticky Booking Card --}}
            <div class="lg:w-1/3">
                <div class="lg:sticky lg:top-6">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Book This Tour</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                            <input type="date" wire:model="travelDate" min="{{ date('Y-m-d') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div class="space-y-3 mb-4">
                            @php
                                $hasPricing = false;
                            @endphp
                            @foreach($pricing as $item)
                                @if(!is_null($item['price']))
                                    @php $hasPricing = true; @endphp
                                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $item['label'] }}</span>
                                            <div class="text-xs text-gray-500">
                                                @if(!is_null($item['sale_price']))
                                                    <span class="text-primary-600 font-medium">${{ number_format($item['sale_price'], 2) }}</span>
                                                    <span class="line-through ml-1">${{ number_format($item['price'], 2) }}</span>
                                                @else
                                                    <span class="text-gray-700">${{ number_format($item['price'], 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                            <button type="button" wire:click="decrementQuantity('{{ $item['category'] }}')" class="px-2 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            </button>
                                            <span class="px-3 py-1 text-sm font-medium text-gray-900 min-w-[2rem] text-center">{{ $quantities[$item['category']] ?? 0 }}</span>
                                            <button type="button" wire:click="incrementQuantity('{{ $item['category'] }}')" class="px-2 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if($hasPricing)
                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Tax (13% HST)</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($tax, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex items-center justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-primary-600">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        @endif

                        @if(($tour->booking_type ?? 'internal') === 'external' && $tour->booking_url)
                            <a href="{{ $tour->booking_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center mt-4 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200 text-lg">
                                Book Now
                            </a>
                        @else
                            <button type="button" wire:click="bookNow" class="block w-full text-center mt-4 px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200 text-lg">
                                Book Now
                            </button>
                        @endif

                        <div class="mt-4 space-y-2 text-sm text-gray-500">
                            @if(isset($tour->duration))
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ $tour->duration }}</span>
                                </div>
                            @endif
                            @if(isset($tour->location))
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $tour->location }}</span>
                                </div>
                            @endif
                            @if(($tour->booking_type ?? 'internal') === 'internal')
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Free cancellation up to 48 hours
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Reserve now, pay later
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Secure booking
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Tours --}}
    @if(isset($relatedTours) && $relatedTours->isNotEmpty())
        <section class="bg-gray-50 py-12 mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">You Might Also Like</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedTours as $related)
                        <a href="{{ route('tour.detail', $related->slug) }}" wire:navigate class="group bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-100 overflow-hidden transition-all duration-300">
                            <div class="aspect-video overflow-hidden bg-gray-200">
                                @if(isset($related->images[0]))
                                    <img src="{{ $related->images[0] }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-purple-100"></div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $related->title }}</h3>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-lg font-bold text-primary-600">${{ number_format($related->price, 2) }}</span>
                                    @if(isset($related->rating))
                                        <span class="flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            {{ $related->rating }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
