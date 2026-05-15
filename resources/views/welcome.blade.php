@extends('layouts.app')

@section('title', 'Home')

@php
    use App\Models\HomepageSection;
    use App\Models\Tour;
    use App\Models\Category;
    use App\Models\Destination;
    use App\Models\Review;
    use App\Models\Post;
    $enabledSections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();
    $showCategories = Category::where('is_active', true)->orderBy('sort_order')->get();
    $popularTours = Tour::where('is_active', true)->where('is_featured', true)->orderBy('id', 'desc')->take(6)->get();
    $featuredReviews = Review::active()->take(3)->get();
    $latestPosts = Post::active()->published()->orderBy('published_at', 'desc')->take(3)->get();
    $faqSection = $enabledSections->firstWhere('key', 'faq');
    $reviewsSection = $enabledSections->firstWhere('key', 'reviews');
    $promoSection = $enabledSections->firstWhere('key', 'featured_promo');
    $blogSection = $enabledSections->firstWhere('key', 'blog');
@endphp

@section('hero')
    @php $hero = $enabledSections->firstWhere('key', 'hero'); @endphp
    @if($hero)
        <livewire:front.hero-slider />
    @endif
@endsection

@section('content')
    @php
        $popularSettings = optional($enabledSections->firstWhere('key', 'popular_tours'))->settings;
        $ptIds = $popularSettings['tour_ids'] ?? [];
        $ptTours = $ptIds ? Tour::whereIn('id', $ptIds)->where('is_active', true)->get() : $popularTours;
    @endphp

    {{-- ==================== TOUR CARDS GRID (Popular Tours) ==================== --}}
    @if($ptTours->isNotEmpty())
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-3">Popular Tours</p>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $popularSettings['title'] ?? 'Discover Niagara Falls' }}</h2>
                @if(!empty($popularSettings['subtitle']))
                    <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">{{ $popularSettings['subtitle'] }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @foreach($ptTours as $tour)
                    @php $startingPrice = $tour->starting_price ?: $tour->price; @endphp
                    <div class="group bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $tour->featured_image ?? ($tour->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80') }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                            @if($loop->first)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-amber-500 text-white text-xs font-bold rounded-full shadow-lg">Likely to Sell Out</span>
                            @endif

                            <span class="absolute top-4 right-4 px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-bold rounded-full shadow-lg">
                                {{ $tour->duration_type ? str_replace('-', ' ', $tour->duration_type) : 'Full Day' }}
                            </span>

                            <div class="absolute bottom-4 left-4">
                                @if($startingPrice)
                                    <span class="px-3 py-1.5 bg-white text-primary-600 text-sm font-bold rounded-full shadow-lg">
                                        From ${{ number_format($startingPrice, 0) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors leading-tight">
                                <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>{{ $tour->title }}</a>
                            </h3>
                            @if($tour->short_description)
                                <p class="text-sm text-gray-500 mb-4 line-clamp-2 leading-relaxed">{{ $tour->short_description }}</p>
                            @endif
                            <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $tour->duration ? $tour->duration . ' Hours' : '6 Hours' }}
                                </span>
                                @if($tour->max_people)
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    1-{{ $tour->max_people }}
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 mb-5">
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
                            <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="block w-full text-center px-4 py-3 bg-primary-600 text-white text-sm font-bold rounded-xl hover:bg-primary-500 transition-colors shadow-lg shadow-primary-600/20">
                                Book Now
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 border-2 border-primary-600 text-primary-600 font-bold rounded-xl hover:bg-primary-600 hover:text-white transition-all duration-200 text-sm">
                    View All Tours
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== FAQ SECTION ==================== --}}
    @if($faqSection)
    @php $faqSettings = $faqSection->settings; $faqs = $faqSettings['faqs'] ?? []; @endphp
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <p class="inline-block px-5 py-2 bg-primary-600 text-white text-sm font-bold rounded-full mb-5">{{ $faqSettings['badge_text'] ?? 'All Tasting Fees Are Included!' }}</p>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $faqSettings['title'] ?? 'FREQUENTLY ASKED QUESTIONS?' }}</h2>
            </div>

            @if(!empty($faqs))
                <div x-data="{ openFaq: null }" class="space-y-4">
                    @foreach($faqs as $i => $faq)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <button @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between px-6 md:px-8 py-5 text-left">
                                <span class="font-semibold text-gray-900 pr-4 text-sm md:text-base">{{ $faq['question'] ?? '' }}</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="openFaq === {{ $i }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                            <div x-show="openFaq === {{ $i }}" x-cloak class="px-6 md:px-8 pb-6">
                                <p class="text-gray-600 leading-relaxed text-sm">{{ $faq['answer'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div x-data="{ openFaq: null }" class="space-y-4">
                    @foreach([
                        ['q' => 'Is transportation included for all tours?', 'a' => 'Yes, all tours include complimentary pick-up and drop-off from your accommodation within the Niagara region.'],
                        ['q' => 'Can we request specific attractions on our tour?', 'a' => 'Yes, we always attempt to ensure your preferences are met. Guests can communicate their wish list when making a reservation.'],
                        ['q' => 'Which tour is best for scenic views?', 'a' => 'Our Niagara Grand Tour is widely recognized as the most scenic experience. Located minutes from the falls, this tour offers incredible views of the surrounding gorge and vineyards.'],
                        ['q' => 'Do tours run year-round?', 'a' => 'Yes, we operate year-round. Spring and fall offer incredible views with fewer crowds. Summer is perfect for boat cruises.'],
                        ['q' => 'What is the difference between a public and private tour?', 'a' => 'Both options include pickup, drop-off, a guide and all fees. Public tour groups are between 8-14 people. Private tours are exclusive to your group.'],
                        ['q' => 'Are tasting fees included in wine tours?', 'a' => 'Yes, all tasting fees are included in the price of our wine tours. Everything is included so you can focus on enjoying your experience.'],
                    ] as $i => $item)
                        <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <button @click="openFaq = openFaq === {{ $i }} ? null : {{ $i }}" class="w-full flex items-center justify-between px-6 md:px-8 py-5 text-left">
                                <span class="font-semibold text-gray-900 pr-4 text-sm md:text-base">{{ $item['q'] }}</span>
                                <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="openFaq === {{ $i }} ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </button>
                            <div x-show="openFaq === {{ $i }}" x-cloak class="px-6 md:px-8 pb-6">
                                <p class="text-gray-600 leading-relaxed text-sm">{{ $item['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="text-center mt-10">
                <a href="#" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-500 transition-colors text-sm">
                    View All FAQs
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== WHY CHOOSE US ==================== --}}
    @php $whySection = $enabledSections->firstWhere('key', 'why_choose_us'); @endphp
    @if($whySection)
    @php $whySettings = $whySection->settings; @endphp
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-3">WHY</p>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $whySettings['title'] ?? 'Why Niagara Tours?' }}</h2>
                @if(!empty($whySettings['subtitle']))
                    <p class="mt-4 text-lg text-gray-600 max-w-4xl mx-auto">{{ $whySettings['subtitle'] }}</p>
                @else
                    <p class="mt-4 text-lg text-gray-600 max-w-4xl mx-auto">Why choose Niagara Tours for your next experience? Quite simply, our value proposition is the best in the industry! We're present, accountable, honest, fun and put the focus of every tour we operate on YOU!</p>
                @endif
            </div>

            @php
                $features = $whySettings['features'] ?? [
                    ['title' => 'All-Inclusive', 'description' => 'All of our tours include tasting fees, and complimentary pick-up and drop off. When everything is included with your tour you can let us worry about the details and focus on enjoying your experience.'],
                    ['title' => 'Amazing Guides', 'description' => 'Our guiding team offers a youthful, energetic and fun approach to all our tours. All our guides are highly skilled and trained to ensure you have the best tour experience of your life!'],
                    ['title' => 'Flexible Booking', 'description' => 'Need to re-schedule or cancel your booking? We got you! Book with us and avoid the stress of rigid bookings. All reservations include a flexible cancellation, transfer and refund policy.'],
                    ['title' => 'Best Value', 'description' => 'We offer competitive pricing without compromising on quality. Our tours provide exceptional value with premium experiences, making your Niagara adventure both memorable and affordable.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                @foreach($features as $i => $feature)
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 {{ $i === 1 ? 'bg-primary-100' : 'bg-gray-100' }}">
                            <svg class="w-10 h-10 {{ $i === 1 ? 'text-primary-600' : 'text-gray-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($i === 0)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                @elseif($i === 1)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                @elseif($i === 2)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $feature['title'] ?? '' }}</h3>
                        <p class="text-gray-600 leading-relaxed text-sm">{{ $feature['description'] ?? '' }}</p>
                        @if(!$loop->last)
                            <a href="#" class="inline-flex items-center gap-1 mt-4 text-primary-600 font-semibold hover:text-primary-500 transition-colors text-sm">
                                Learn More
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== REVIEWS SECTION ==================== --}}
    @if($reviewsSection)
    @php $reviewSettings = $reviewsSection->settings; @endphp
    <section class="py-16 md:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-3">{{ $reviewSettings['badge'] ?? 'WHAT PEOPLE ARE SAYING' }}</p>
                <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $reviewSettings['title'] ?? '5 Star Niagara Tours' }}</h2>
                @if(!empty($reviewSettings['subtitle']))
                    <p class="mt-4 text-lg text-gray-600">{{ $reviewSettings['subtitle'] }}</p>
                @else
                    <p class="mt-4 text-lg text-gray-600">Based on Over {{ \App\Models\Review::count() > 0 ? \App\Models\Review::count() . ' Reviews' : '2,000+ Reviews' }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($featuredReviews as $review)
                    <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-6 text-sm">&ldquo;{{ $review->content }}&rdquo;</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-sm">{{ substr($review->name, 0, 1) }}</div>
                            <div>
                                <p class="font-semibold text-gray-900 text-sm">{{ $review->name }}</p>
                                @if($review->location)
                                    <p class="text-xs text-gray-500">{{ $review->location }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    @foreach([
                        ['name' => 'Sarah M.', 'location' => 'Toronto, ON', 'text' => 'Absolutely incredible experience! The tour guide was knowledgeable and friendly. The views of Niagara Falls were breathtaking. Highly recommend!'],
                        ['name' => 'James K.', 'location' => 'New York, NY', 'text' => 'Booked the Niagara Wine Tour and it exceeded all expectations. The wineries were amazing, and the guide made the experience truly special.'],
                        ['name' => 'Emily R.', 'location' => 'Chicago, IL', 'text' => 'The sunset tour was magical! Seeing the falls lit up at night was unforgettable. Professional service from start to finish. Worth every penny!'],
                    ] as $review)
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-200 shadow-sm hover:shadow-lg transition-shadow">
                            <div class="flex items-center gap-1 mb-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-gray-600 leading-relaxed mb-6 text-sm">&ldquo;{{ $review['text'] }}&rdquo;</p>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-600 font-bold text-sm">{{ substr($review['name'], 0, 1) }}</div>
                                <div>
                                    <p class="font-semibold text-gray-900 text-sm">{{ $review['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $review['location'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== NOW FEATURING (Promo) ==================== --}}
    @if($promoSection)
    @php $promoSettings = $promoSection->settings; @endphp
    <section class="relative py-24 md:py-32 bg-cover bg-center" style="background-image: url('{{ $promoSettings['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}');">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/75 to-gray-900/60"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <p class="inline-block px-4 py-1.5 mb-4 text-sm font-semibold text-primary-200 bg-primary-900/60 rounded-full border border-primary-700/50">
                    {{ $promoSettings['badge'] ?? 'Now Featuring' }}
                </p>
                <h2 class="text-4xl md:text-6xl font-extrabold text-white leading-tight">{{ $promoSettings['title'] ?? 'Elevate Your Senses' }}</h2>
                @if(!empty($promoSettings['description']))
                    <p class="mt-4 text-lg text-gray-200 leading-relaxed max-w-xl">{{ $promoSettings['description'] }}</p>
                @else
                    <p class="mt-4 text-lg text-gray-200 leading-relaxed max-w-xl">Wine, food, adventure... it's all about making your senses pop. We've partnered with the top Niagara producers to offer unparalleled experiences that will have you craving more!</p>
                @endif
                <a href="{{ $promoSettings['button_link'] ?? route('tours') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-500 transition-all mt-8 shadow-lg shadow-primary-600/30">
                    {{ $promoSettings['button_text'] ?? 'Learn More' }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ==================== LATEST NEWS / BLOG ==================== --}}
    @if($blogSection && $latestPosts->isNotEmpty())
    @php $blogSettings = $blogSection->settings; @endphp
    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12 md:mb-16">
                <div>
                    <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-3">{{ $blogSettings['badge'] ?? 'LATEST NEWS & TRENDS' }}</p>
                    <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $blogSettings['title'] ?? 'From Our Blog' }}</h2>
                </div>
                <a href="{{ $blogSettings['view_all_link'] ?? '#' }}" class="hidden sm:inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-500 transition-colors text-sm">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($latestPosts as $post)
                    <div class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300">
                        @if($post->featured_image)
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                        @endif
                        <div class="p-6">
                            <p class="text-xs font-semibold text-primary-600 mb-2">{{ $post->author ?? 'Tour Guide Team' }} / {{ $post->date_formatted }}</p>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors leading-tight">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">{{ $post->excerpt_html }}</p>
                            <a href="#" class="inline-flex items-center gap-1 mt-4 text-primary-600 font-semibold hover:text-primary-500 transition-colors text-sm">
                                Read More
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10 sm:hidden">
                <a href="{{ $blogSettings['view_all_link'] ?? '#' }}" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-500 transition-colors text-sm">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif
@endsection
