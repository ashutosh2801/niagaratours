@extends('layouts.app')

@section('title', 'Home')

@php
    use App\Models\HomepageSection;
    use App\Models\Tour;
    use App\Models\Category;
    use App\Models\Destination;
    $enabledSections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();
    $showCategories = Category::where('is_active', true)->orderBy('sort_order')->get();
    $showDestinations = Destination::withCount(['tours' => fn($q) => $q->where('is_active', true)])->where('is_active', true)->where('is_popular', true)->orderBy('sort_order')->get();
    $popularTours = Tour::where('is_active', true)->where('is_featured', true)->orderBy('id', 'desc')->take(6)->get();
    $allTours = Tour::where('is_active', true)->orderBy('id', 'desc')->paginate(12);
    $faqs = Tour::where('is_active', true)->whereNotNull('faqs')->where('faqs', '!=', '[]')->inRandomOrder()->take(5)->get()->flatMap(fn($t) => collect($t->faqs)->take(2))->take(6);
@endphp

@section('hero')
    @php $hero = $enabledSections->firstWhere('key', 'hero'); @endphp
    @if($hero)
        <livewire:front.hero-slider />
    @endif
@endsection

@section('content')
    @foreach($enabledSections as $section)
        @php $settings = $section->settings; @endphp

        {{-- Why Choose Us --}}
        @if($section->key === 'why_choose_us' && $settings)
            <section class="py-20 bg-white">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'Why Choose Us' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if(!empty($settings['features']))
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            @foreach($settings['features'] as $feature)
                                <div class="text-center p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-lg hover:border-primary-100 transition-all duration-300">
                                    <div class="w-16 h-16 bg-primary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($loop->first)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            @elseif($loop->iteration === 2)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            @endif
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $feature['title'] ?? '' }}</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ $feature['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

        {{-- Popular Tours --}}
        @elseif($section->key === 'popular_tours' && $settings)
            @php
                $ptIds = $settings['tour_ids'] ?? [];
                $ptTours = $ptIds ? Tour::whereIn('id', $ptIds)->where('is_active', true)->get() : $popularTours;
            @endphp
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'Popular Tours' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if($ptTours->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($ptTours as $tour)
                                @php $startingPrice = $tour->starting_price ?: $tour->price; @endphp
                                <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                                    <div class="relative h-52 overflow-hidden">
                                        <img src="{{ $tour->featured_image ?? ($tour->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                        @if($loop->first)
                                            <span class="absolute top-3 left-3 px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full">Likely to Sell Out</span>
                                        @endif
                                        <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold rounded-full">{{ $tour->duration_type ?? 'full-day' }}</span>
                                        @if($tour->sale_price)
                                            <span class="absolute bottom-3 left-3 px-3 py-1.5 bg-red-500 text-white text-sm font-bold rounded-lg">From ${{ number_format($startingPrice, 2) }}</span>
                                        @elseif($startingPrice)
                                            <span class="absolute bottom-3 left-3 px-3 py-1.5 bg-primary-600 text-white text-sm font-bold rounded-lg">From ${{ number_format($startingPrice, 2) }}</span>
                                        @endif
                                    </div>
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                            <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>{{ $tour->title }}</a>
                                        </h3>
                                        @if($tour->short_description)
                                            <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed">{{ $tour->short_description }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                {{ $tour->duration ?? '6 Hours' }}
                                            </span>
                                            @if($tour->max_people)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                1-{{ $tour->max_people }}
                                            </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1.5 mb-4">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($tour->rating ?? 5))
                                                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @else
                                                        <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm font-bold text-gray-900">{{ number_format($tour->rating ?? 5, 1) }}</span>
                                            <span class="text-sm text-gray-400">({{ $tour->review_count }})</span>
                                        </div>
                                        <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="block w-full text-center px-4 py-2.5 bg-primary-600 text-white text-sm font-semibold rounded-lg hover:bg-primary-500 transition-colors">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-12">
                            <a href="{{ route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-primary-600 text-primary-600 font-bold rounded-xl hover:bg-primary-600 hover:text-white transition-all duration-200">
                                View All Tours
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

        {{-- FAQ Section --}}
        @elseif($section->key === 'faq' && $settings)
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-4xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'Frequently Asked Questions' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if($faqs->isNotEmpty())
                        <div x-data="{ openFaq: null }" class="space-y-4">
                            @foreach($faqs as $faq)
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                                    <button @click="openFaq = openFaq === {{ $loop->index }} ? null : {{ $loop->index }}" class="w-full flex items-center justify-between px-6 py-5 text-left">
                                        <span class="font-semibold text-gray-900 pr-4">{{ $faq['question'] ?? '' }}</span>
                                        <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="openFaq === {{ $loop->index }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                    <div x-show="openFaq === {{ $loop->index }}" x-cloak class="px-6 pb-5">
                                        <p class="text-gray-600 leading-relaxed">{{ $faq['answer'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-10">
                            <a href="#" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-500 transition-colors">
                                View All FAQs
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @else
                        <div x-data="{ openFaq: null }" class="space-y-4">
                            @foreach([
                                ['q' => 'Is transportation included for all Niagara tours?', 'a' => 'Yes, all tours include complimentary pick-up and drop-off from your accommodation within the Niagara region.'],
                                ['q' => 'Can we request specific attractions on our tour?', 'a' => 'Yes, we always attempt to ensure your preferences are met. You can communicate your wish list when making a reservation.'],
                                ['q' => 'Which Niagara tour is best for scenic views?', 'a' => 'Our Niagara Falls Grand Tour is widely recognized as the most scenic experience, offering breathtaking views of the falls, gorge, and surrounding wine country.'],
                                ['q' => 'Do tours run year-round?', 'a' => 'Yes, we operate year-round. Spring and fall offer incredible views with fewer crowds, while summer is perfect for boat cruises.'],
                                ['q' => 'What is the difference between a public and private tour?', 'a' => 'Both include the same amenities. Public tours have groups of 8-14 people. Private tours are exclusive to your group with a more curated experience.'],
                                ['q' => 'Are tasting fees included in wine tours?', 'a' => 'Yes, all tasting fees are included in the price of our wine tours.'],
                            ] as $i => $item)
                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                                    <button @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between px-6 py-5 text-left">
                                        <span class="font-semibold text-gray-900 pr-4">{{ $item['q'] }}</span>
                                        <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="openFaq === {{ $i }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                    <div x-show="openFaq === {{ $i }}" x-cloak class="px-6 pb-5">
                                        <p class="text-gray-600 leading-relaxed">{{ $item['a'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

        {{-- Reviews Section --}}
        @elseif($section->key === 'reviews')
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'What People Are Saying' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $settings['subtitle'] }}</p>
                        @else
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">5 Star Niagara Tours Based on Over 2,000 Reviews</p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach([
                            ['name' => 'Sarah M.', 'location' => 'Toronto, ON', 'text' => 'Absolutely incredible experience! The tour guide was knowledgeable and friendly. The views of Niagara Falls were breathtaking. Highly recommend this tour to anyone visiting the area!', 'rating' => 5],
                            ['name' => 'James K.', 'location' => 'New York, NY', 'text' => 'Booked the Niagara Wine Tour and it exceeded all expectations. The wineries were amazing, and the guide made the experience truly special. Will definitely book again!', 'rating' => 5],
                            ['name' => 'Emily R.', 'location' => 'Chicago, IL', 'text' => 'The sunset tour was magical! Seeing the falls lit up at night was unforgettable. Professional service from start to finish. worth every penny!', 'rating' => 5],
                        ] as $review)
                            <div class="bg-white rounded-2xl p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow">
                                <div class="flex items-center gap-1 mb-4">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6">&ldquo;{{ $review['text'] }}&rdquo;</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-sm">{{ substr($review['name'], 0, 1) }}</div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $review['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $review['location'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Now Featuring / Elevate Your Senses --}}
        @elseif($section->key === 'featured_promo')
            <section class="relative py-24 bg-cover bg-center" style="background-image: url('{{ $settings['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}');">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/75 to-gray-900/60"></div>
                <div class="relative max-w-7xl mx-auto px-4">
                    <div class="max-w-2xl">
                        <p class="inline-block px-4 py-1.5 mb-4 text-sm font-semibold text-primary-200 bg-primary-900/60 rounded-full border border-primary-700/50">
                            {{ $settings['badge'] ?? 'Now Featuring' }}
                        </p>
                        <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">{{ $settings['title'] ?? 'Elevate Your Senses' }}</h2>
                        @if(!empty($settings['description']))
                            <p class="mt-4 text-lg text-gray-200 leading-relaxed">{{ $settings['description'] }}</p>
                        @endif
                        @if(!empty($settings['button_text']))
                            <a href="{{ $settings['button_link'] ?? '#' }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-500 transition-all mt-8 shadow-lg shadow-primary-600/30">
                                {{ $settings['button_text'] }}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            </section>

        {{-- Browse Categories --}}
        @elseif($section->key === 'browse_categories' && $settings && $showCategories->isNotEmpty())
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'Browse by Category' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
                        @foreach($showCategories as $cat)
                            <a href="{{ route('tours', ['selectedCategories' => [$cat->id]]) }}" wire:navigate class="group flex flex-col items-center p-8 bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-xl hover:border-primary-200 hover:-translate-y-1 transition-all duration-300">
                                @if($cat->image)
                                    <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-20 h-20 object-cover rounded-2xl mb-4">
                                @else
                                    <div class="w-20 h-20 bg-primary-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-primary-200 transition-colors">
                                        <svg class="w-10 h-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    </div>
                                @endif
                                <span class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">{{ $cat->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

        {{-- Newsletter --}}
        @elseif($section->key === 'newsletter')
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-2xl mx-auto px-4 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $settings['title'] ?? 'Get Updates' }}</h2>
                    @if(!empty($settings['description']))
                        <p class="text-lg text-gray-600 mb-8">{{ $settings['description'] }}</p>
                    @else
                        <p class="text-lg text-gray-600 mb-8">Subscribe to our newsletter for exclusive offers, new tours, and Niagara travel tips.</p>
                    @endif
                    <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                        <input type="email" placeholder="Email*" required class="flex-1 px-5 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-500 transition-colors text-sm whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                </div>
            </section>

        {{-- CTA --}}
        @elseif($section->key === 'cta' && $settings)
            <section class="relative py-24 bg-cover bg-center" style="background-image: url('{{ $settings['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}');">
                <div class="absolute inset-0 bg-primary-900/75"></div>
                <div class="relative max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4">{{ $settings['title'] ?? 'Ready for an Unforgettable Adventure?' }}</h2>
                    @if(!empty($settings['description']))
                        <p class="text-lg text-primary-200 mb-8 max-w-2xl mx-auto leading-relaxed">{{ $settings['description'] }}</p>
                    @endif
                    <a href="{{ $settings['button_link'] ?? route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-10 py-4 bg-white text-primary-600 font-bold rounded-xl hover:bg-primary-50 transition-all text-lg shadow-xl">
                        {{ $settings['button_text'] ?? 'Start Your Adventure' }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </section>

        {{-- Popular Destinations --}}
        @elseif($section->key === 'popular_destinations' && $settings && $showDestinations->isNotEmpty())
            <section class="py-20 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $settings['title'] ?? 'Popular Destinations' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($showDestinations as $dest)
                            <a href="{{ route('tours', ['selectedDestinations' => [$dest->id]]) }}" wire:navigate class="group relative h-72 rounded-2xl overflow-hidden">
                                @if($dest->image)
                                    <img src="{{ $dest->image }}" alt="{{ $dest->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-white font-bold text-xl">{{ $dest->name }}</h3>
                                    <p class="text-primary-200 text-sm font-medium mt-1">{{ $dest->tours_count }} tours</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endforeach
@endsection
