@extends('layouts.app')

@section('title', 'Home')

@php
    use App\Models\Destination;
    use App\Models\HomepageSection;
    use App\Models\Tour;
    use App\Models\Category;
    $enabledSections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();
    $showCategories = Category::where('is_active', true)->orderBy('sort_order')->get();
@endphp

@section('hero')
    @php $hero = $enabledSections->firstWhere('key', 'hero'); @endphp
    @if($hero)
        <livewire:front.hero-slider />
    @endif
@endsection

@section('content')
    @foreach($enabledSections as $section)
        @php $s = $section->settings ?? []; @endphp

        {{-- ==================== POPULAR TOURS ==================== --}}
        @if($section->key === 'popular_tours')
            @php
                $ptIds = $s['tour_ids'] ?? [];
                $ptTours = $ptIds ? Tour::whereIn('id', $ptIds)->where('is_active', true)->get() : Tour::where('is_active', true)->where('is_featured', true)->orderBy('id', 'desc')->take(6)->get();
            @endphp
            @if($ptTours->isNotEmpty())
            <section class="relative py-10">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Popular Tours' }}</h2>
                        <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] ?? 'Curated premium journeys crafted for unforgettable adventures.' }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                        @foreach($ptTours as $tour)
                            @php
                                $startingPrice = $tour->starting_price ?: $tour->price;
                                $oldPrice = $startingPrice ? $startingPrice + 70 : 280;
                                $image = $tour->featured_image ?? ($tour->images[0] ?? 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=1200&auto=format&fit=crop');
                                $rating = $tour->rating ?? 5;
                            @endphp
                            <div class="group relative">
                                <div class="relative h-full rounded-[24px] bg-white/70 backdrop-blur-xl border border-white/50 shadow-[0_20px_20px_rgba(15,23,42,0.08)] overflow-hidden transition-all duration-700 hover:-translate-y-3 hover:shadow-[0_20px_20px_rgba(15,23,42,0.18)]">
                                    <div class="relative overflow-hidden">
                                        <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>
                                            <img src="{{ $image }}" alt="{{ $tour->title }}" class="w-full h-[280px] object-cover transition duration-[1200ms] group-hover:scale-110">
                                        </a>
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                        @if($loop->first)
                                            <div class="absolute top-5 left-5">
                                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-semibold tracking-wide shadow-lg">Likely to Sell Out</div>
                                            </div>
                                        @endif
                                        <div class="absolute top-5 right-5">
                                            <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 shadow-lg">
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                <span class="text-white text-sm font-bold">{{ number_format($rating,1) }}</span>
                                            </div>
                                        </div>
                                        <div class="absolute bottom-0 left-0 right-0 p-6">
                                            <div class="flex items-end justify-between">
                                                <div>
                                                    <div class="text-white/60 line-through text-sm mb-1">${{ number_format($oldPrice, 2) }}</div>
                                                    <div class="flex items-end gap-1">
                                                        <span class="text-white/70 text-sm mb-1">From</span>
                                                        <span class="text-3xl font-bold text-white leading-none">${{ number_format($startingPrice ?? 210, 0) }}</span>
                                                    </div>
                                                </div>
                                                <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="w-10 h-10 rounded-2xl bg-white text-gray-900 flex items-center justify-center shadow-2xl transition-all duration-300 hover:bg-primary-600 hover:text-white hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-[18px] font-bold leading-snug text-gray-900 mb-2 tracking-tight group-hover:text-primary-600 transition duration-300">
                                            <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>{{ $tour->title }}</a>
                                        </h3>
                                        <p class="text-[15px] leading-tight text-gray-500 mb-5 line-clamp-1">{{ $tour->short_description ?? 'Experience breathtaking destinations with luxury comfort.' }}</p>
                                        <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-6"></div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                                <div class="w-11 h-11 rounded-xl bg-white shadow-sm flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </div>
                                                <div>
                                                    <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Duration</div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $tour->duration ? $tour->duration . 'h' : '6h' }}</div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                                                <div class="w-11 h-11 rounded-xl bg-white shadow-sm flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                </div>
                                                <div>
                                                    <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Guests</div>
                                                    <div class="text-sm font-bold text-gray-900">{{ $tour->max_people ? $tour->max_people : '12' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center mt-10">
                        <a href="{{ route('tours') }}" wire:navigate class="group inline-flex items-center gap-4 px-6 py-3 rounded-full bg-gray-900 hover:bg-primary-600 text-white text-sm font-bold uppercase shadow-[0_20px_40px_rgba(0,0,0,0.15)] transition-all duration-500 hover:scale-105">
                            View All Tours
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center transition-all duration-300 group-hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            @endif

        {{-- ==================== FEATURES (ICON GRID) ==================== --}}
        @elseif($section->key === 'features')
            @php $features = $s['features'] ?? []; @endphp
            @if(!empty($features))
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    @if(!empty($s['title']))
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    @endif
                    <div class="bg-[#f7f7f7] rounded-[28px] px-8 md:px-14 py-12">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-12 gap-x-10">
                            @foreach($features as $feature)
                                <div class="text-center">
                                    @if(!empty($feature['icon']))
                                    <div class="flex justify-center mb-6">
                                        <img src="{{ $feature['icon'] }}" alt="{{ $feature['title'] ?? '' }}" class="w-[80px] h-[80px] object-contain">
                                    </div>
                                    @endif
                                    <h3 class="text-[18px] leading-none font-bold text-gray-900">{{ $feature['title'] ?? '' }}</h3>
                                    <p class="mt-4 text-[14px] text-[#666] font-medium max-w-[260px] mx-auto">{{ $feature['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            @endif

        {{-- ==================== DESTINATIONS SLIDER ==================== --}}
        @elseif($section->key === 'destinations')
            @php
                $destIds = $s['destination_ids'] ?? [];
                $destinations = $destIds ? Destination::whereIn('id', $destIds)->where('is_active', true)->orderBy('sort_order')->get() : collect();
            @endphp
            @if($destinations->isNotEmpty())
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Destinations Around the World' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="relative destinations">
                        <div class="swiper destinationSwiper">
                            <div class="swiper-wrapper">
                                @foreach($destinations as $destination)
                                    <div class="swiper-slide">
                                        <div class="relative h-[450px] rounded-[22px] overflow-hidden group">
                                            <a href="{{ route('tour.detail', $destination->slug) }}">
                                                <img src="{{ $destination->image ?? '' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                                <div class="absolute bottom-8 text-center w-full">
                                                    <p class="text-white text-lg">Things to do in</p>
                                                    <h3 class="text-white text-xl md:text-xl font-bold mt-1">{{ $destination->name }}</h3>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="swiper-button-prev !text-black !w-12 !h-12 bg-white rounded-full"></button>
                        <button class="swiper-button-next !text-black !w-12 !h-12 bg-white rounded-full"></button>
                    </div>
                    <div class="flex justify-center mt-10">
                        <a href="{{ route('destinations') }}" wire:navigate class="group inline-flex items-center gap-4 px-6 py-3 rounded-full bg-gray-900 hover:bg-primary-600 text-white text-sm font-bold uppercase shadow-[0_20px_40px_rgba(0,0,0,0.15)] transition-all duration-500 hover:scale-105">
                            View All Destinations
                            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center transition-all duration-300 group-hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            @endif

        {{-- ==================== POLICIES / GUARANTEES ==================== --}}
        @elseif($section->key === 'policies')
            @php $items = $s['items'] ?? []; @endphp
            @if(!empty($items))
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    @if(!empty($s['title']))
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] }}</h2>
                    </div>
                    @endif
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">
                        @foreach($items as $item)
                            @php
                                $from = $item['overlay_from'] ?? '#0ad6c7';
                                $to = $item['overlay_to'] ?? '#0c8d89';
                            @endphp
                            <div class="group relative overflow-hidden rounded-[34px] h-[340px]">
                                <img src="{{ $item['image'] ?? '' }}" alt="" class="absolute inset-0 w-full h-full object-cover scale-100 group-hover:scale-110 transition duration-[3000ms] ease-out" />
                                <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $from }} 0%, {{ $to }} 45%, rgba(0,0,0,0.7) 100%);"></div>
                                <div class="absolute inset-0 opacity-40 bg-[linear-gradient(120deg,transparent,rgba(255,255,255,0.18),transparent)] -translate-x-full group-hover:translate-x-full transition duration-[1800ms]"></div>
                                <div class="absolute inset-0 rounded-[34px] border border-white/10"></div>
                                <div class="relative z-10 h-full flex items-center justify-center text-center p-9">
                                    <div>
                                        @if(!empty($item['badge']))
                                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-[13px] tracking-[2px] uppercase font-medium">{{ $item['badge'] }}</div>
                                        @endif
                                        <h2 class="mt-7 text-white md:text-[46px] leading-[50px] font-semibold tracking-[-1.5px]">{{ $item['title'] ?? '' }}</h2>
                                        @if(!empty($item['description']))
                                        <p class="mt-5 text-white/80 text-[19px] leading-[33px] font-normal max-w-[500px] mx-auto">{{ $item['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

        {{-- ==================== WHY CHOOSE US (Text Features) ==================== --}}
        @elseif($section->key === 'why_choose_us')
            @php $features = $s['features'] ?? []; @endphp
            <section class="py-16 md:py-24 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16">
                        <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-3">WHY</p>
                        <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $s['title'] ?? 'Why Niagara Tours?' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-4 text-lg text-gray-600 max-w-4xl mx-auto">{{ $s['subtitle'] }}</p>
                        @else
                            <p class="mt-4 text-lg text-gray-600 max-w-4xl mx-auto">Why choose Niagara Tours for your next experience? Quite simply, our value proposition is the best in the industry! We're present, accountable, honest, fun and put the focus of every tour we operate on YOU!</p>
                        @endif
                    </div>
                    @if(!empty($features))
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                        @foreach($features as $i => $feature)
                            <div class="text-center">
                                <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6 {{ $i % 2 === 1 ? 'bg-primary-100' : 'bg-gray-100' }}">
                                    <svg class="w-10 h-10 {{ $i % 2 === 1 ? 'text-primary-600' : 'text-gray-700' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($i % 4 === 0)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        @elseif($i % 4 === 1)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        @elseif($i % 4 === 2)
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
                    @endif
                </div>
            </section>

        {{-- ==================== REVIEWS ==================== --}}
        @elseif($section->key === 'reviews')
            @php $featuredReviews = App\Models\Review::active()->take(3)->get(); @endphp
            <section class="py-12 my-5 bg-[#f7f7f7] overflow-hidden">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Clients Feedbacks' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="relative reviewSwiper overflow-hidden">
                        <div class="swiper-wrapper">
                            @forelse($featuredReviews as $review)
                                <div class="swiper-slide h-auto">
                                    <div class="bg-white rounded-[24px] border border-[#e5e5e5] p-8 relative h-full transition duration-500 hover:-translate-y-2 hover:shadow-xl">
                                        <div class="absolute top-7 right-7 opacity-20">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M7.17 6A5.001 5.001 0 002 11v7h7v-7H5.08A3.001 3.001 0 017.17 8H9V6H7.17zm10 0A5.001 5.001 0 0012 11v7h7v-7h-3.92A3.001 3.001 0 0117.17 8H19V6h-1.83z"/></svg>
                                        </div>
                                        <div class="flex items-center gap-4 mb-7">
                                            <div class="w-[65px] h-[65px] rounded-full overflow-hidden bg-gray-200 shrink-0">
                                                @if(!empty($review->image))
                                                    <img src="{{ $review->image }}" alt="{{ $review->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-lg font-bold text-gray-700 bg-primary-100">{{ strtoupper(substr($review->name,0,1)) }}</div>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-[20px] font-bold leading-none text-black">{{ $review->name }}</h4>
                                                <p class="mt-2 text-[16px] text-[#666] font-medium">{{ $review->designation ?? 'CEO, Traveller' }}</p>
                                            </div>
                                        </div>
                                        <p class="text-[15px] leading-[1.8] italic text-[#666] font-medium min-h-[100px]">&#8220; {{ $review->content }} &#8221;</p>
                                        <div class="flex items-center gap-1 mt-8">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $i <= ($review->rating ?? 5) ? 'text-orange-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @foreach([1,2,3,4] as $i)
                                    <div class="swiper-slide">
                                        <div class="bg-white rounded-[24px] border border-[#e5e5e5] p-8 relative">
                                            <div class="absolute top-7 right-7 opacity-20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M7.17 6A5.001 5.001 0 002 11v7h7v-7H5.08A3.001 3.001 0 017.17 8H9V6H7.17zm10 0A5.001 5.001 0 0012 11v7h7v-7h-3.92A3.001 3.001 0 0117.17 8H19V6h-1.83z"/></svg>
                                            </div>
                                            <div class="flex items-center gap-4 mb-7">
                                                <div class="w-[65px] h-[65px] rounded-full bg-pink-100"></div>
                                                <div>
                                                    <h4 class="text-[24px] font-bold">Esther Howard</h4>
                                                    <p class="text-[#666] mt-1">CEO, Traveller</p>
                                                </div>
                                            </div>
                                            <p class="text-[19px] leading-[1.8] italic text-[#666]">&#8220; Morem Ipsum Dolor Siter Amet Areaeey Consec Taetur Adipisc Service Ollwing Ipsum Dolor Consectetur. &#8221;</p>
                                            <div class="flex gap-1 mt-8">
                                                @for($x=1;$x<=5;$x++)
                                                    <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

        {{-- ==================== FAQ ==================== --}}
        @elseif($section->key === 'faq')
            @php $faqs = $s['faqs'] ?? []; @endphp
            <section class="py-16 md:py-24 bg-gray-50">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center mb-12 md:mb-16">
                        @if(!empty($s['badge_text']))
                            <p class="inline-block px-5 py-2 bg-primary-600 text-white text-sm font-bold rounded-full mb-5">{{ $s['badge_text'] }}</p>
                        @endif
                        <h2 class="text-3xl md:text-5xl font-bold text-gray-900">{{ $s['title'] ?? 'FREQUENTLY ASKED QUESTIONS?' }}</h2>
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

        {{-- ==================== FEATURED PROMO ==================== --}}
        @elseif($section->key === 'featured_promo')
            <section class="relative py-24 md:py-32 bg-cover bg-center" style="background-image: url('{{ $s['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}');">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/75 to-gray-900/60"></div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-2xl">
                        @if(!empty($s['badge']))
                            <p class="inline-block px-4 py-1.5 mb-4 text-sm font-semibold text-primary-200 bg-primary-900/60 rounded-full border border-primary-700/50">{{ $s['badge'] }}</p>
                        @endif
                        <h2 class="text-4xl md:text-6xl font-extrabold text-white leading-tight">{{ $s['title'] ?? 'Elevate Your Senses' }}</h2>
                        @if(!empty($s['description']))
                            <p class="mt-4 text-lg text-gray-200 leading-relaxed max-w-xl">{{ $s['description'] }}</p>
                        @else
                            <p class="mt-4 text-lg text-gray-200 leading-relaxed max-w-xl">Wine, food, adventure... it's all about making your senses pop. We've partnered with the top Niagara producers to offer unparalleled experiences that will have you craving more!</p>
                        @endif
                        <a href="{{ $s['button_link'] ?? route('tours') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-500 transition-all mt-8 shadow-lg shadow-primary-600/30">
                            {{ $s['button_text'] ?? 'Learn More' }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </section>

        {{-- ==================== BLOG ==================== --}}
        @elseif($section->key === 'blog')
            @php $latestPosts = App\Models\Post::active()->published()->orderBy('published_at', 'desc')->take(3)->get(); @endphp
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Inspiration, guides, stories' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="relative blogSwiper overflow-hidden">
                        <div class="swiper-wrapper">
                            @forelse($latestPosts as $post)
                                <div class="swiper-slide py-10">
                                    <article class="group relative h-full rounded-[24px] bg-white/70 backdrop-blur-xl border border-white/50 shadow-[0_20px_20px_rgba(15,23,42,0.08)] overflow-hidden transition-all duration-700 hover:-translate-y-3 hover:shadow-[0_20px_20px_rgba(15,23,42,0.18)]">
                                        <a href="#" class="block overflow-hidden">
                                            <div class="relative h-[270px] overflow-hidden">
                                                <img src="{{ $post->featured_image ?? 'images/blog/1.jpg' }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition duration-[1200ms] group-hover:scale-110">
                                            </div>
                                        </a>
                                        <div class="p-4">
                                            <div class="flex items-center gap-3 text-[14px] text-[#666] font-medium">
                                                <span>{{ $post->published_at ? $post->published_at->format('F j, Y') : 'March 3, 2026' }}</span>
                                                <span class="w-[4px] h-[4px] rounded-full bg-[#888]"></span>
                                                <span class="lowercase">{{ $post->author ?? 'turie' }}</span>
                                            </div>
                                            <h3 class="text-[18px] font-bold leading-snug text-gray-900 mt-4 tracking-tight">
                                                <a href="#">{{ $post->title ?? 'Experience global festivals and magical travel moments' }}</a>
                                            </h3>
                                        </div>
                                    </article>
                                </div>
                            @empty
                                @foreach([
                                    ['image' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?q=80&w=1200&auto=format&fit=crop', 'title' => 'Experience global festivals and magical travel moments'],
                                    ['image' => 'https://images.unsplash.com/photo-1496417263034-38ec4f0b665a?q=80&w=1200&auto=format&fit=crop', 'title' => 'Travel to exotic destinations and vibrant city festivals'],
                                    ['image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1200&auto=format&fit=crop', 'title' => 'Journey through historic landmarks and festive streets'],
                                    ['image' => 'https://images.unsplash.com/photo-1518509562904-e7ef99cdcc86?q=80&w=1200&auto=format&fit=crop', 'title' => 'Explore ancient cities and lively cultural celebrations'],
                                ] as $item)
                                    <div class="swiper-slide">
                                        <article class="group">
                                            <a href="#" class="block overflow-hidden rounded-[24px]">
                                                <div class="relative h-[270px] overflow-hidden rounded-[24px]">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover transition duration-[1200ms] group-hover:scale-110">
                                                </div>
                                            </a>
                                            <div class="pt-5">
                                                <div class="flex items-center gap-3 text-[14px] text-[#666] font-medium">
                                                    <span>March 3, 2026</span>
                                                    <span class="w-[4px] h-[4px] rounded-full bg-[#888]"></span>
                                                    <span class="lowercase">turie</span>
                                                </div>
                                                <h3 class="mt-4 text-[24px] leading-[1.35] font-semibold text-black tracking-tight transition duration-300 group-hover:text-primary-600">
                                                    <a href="#">{{ $item['title'] }}</a>
                                                </h3>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

        {{-- ==================== CTA ==================== --}}
        @elseif($section->key === 'cta')
            <section class="relative py-20 bg-cover bg-center" style="background-image: url('{{ $s['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?w=1920' }}');">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="relative max-w-4xl mx-auto px-4 text-center">
                    @if(!empty($s['title']))
                        <h2 class="text-3xl md:text-5xl font-bold text-white leading-tight">{{ $s['title'] }}</h2>
                    @endif
                    @if(!empty($s['description']))
                        <p class="mt-4 text-lg text-gray-200 max-w-2xl mx-auto">{{ $s['description'] }}</p>
                    @endif
                    @if(!empty($s['button_text']))
                        <a href="{{ $s['button_link'] ?? '#' }}" class="inline-flex items-center gap-2 mt-8 px-8 py-3.5 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-500 transition-all">
                            {{ $s['button_text'] }}
                        </a>
                    @endif
                </div>
            </section>

        {{-- ==================== POPULAR DESTINATIONS (Tour-based) ==================== --}}
        @elseif($section->key === 'popular_destinations')
            @php
                $pdIds = $s['tour_ids'] ?? [];
                $pdTours = $pdIds ? Tour::whereIn('id', $pdIds)->where('is_active', true)->get() : Tour::where('is_active', true)->orderBy('id', 'desc')->take(4)->get();
            @endphp
            @if($pdTours->isNotEmpty())
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Popular Destinations' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($pdTours as $tour)
                            <div class="group relative rounded-[20px] overflow-hidden h-[320px]">
                                <img src="{{ $tour->featured_image ?? 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=600&auto=format&fit=crop' }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h3 class="text-white text-xl font-bold">{{ $tour->title }}</h3>
                                    <p class="text-white/70 text-sm mt-1">From ${{ number_format($tour->price ?? 0, 0) }}</p>
                                </div>
                                <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="absolute inset-0"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

        {{-- ==================== BROWSE CATEGORIES ==================== --}}
        @elseif($section->key === 'browse_categories')
            @if($showCategories->isNotEmpty())
            <section class="py-10">
                <div class="container-fluid mx-auto px-4">
                    <div class="text-center mb-10">
                        <h2 class="text-2xl md:text-4xl font-bold tracking-tight text-gray-900 leading-tight">{{ $s['title'] ?? 'Browse by Category' }}</h2>
                        @if(!empty($s['subtitle']))
                            <p class="mt-2 text-sm leading-tight text-gray-500 max-w-xl mx-auto">{{ $s['subtitle'] }}</p>
                        @endif
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        @foreach($showCategories as $category)
                            <a href="{{ route('tours', ['category' => $category->slug]) }}" wire:navigate class="px-6 py-3 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-700 hover:bg-primary-50 hover:border-primary-200 hover:text-primary-600 transition-all">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

        @endif
    @endforeach
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const el = document.querySelector(".destinationSwiper");
    if (!el) return;
    new Swiper(".destinationSwiper", {
        loop: true,
        spaceBetween: 20,
        slidesPerView: 1,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: { slidesPerView: 1.2 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
            1280: { slidesPerView: 4 },
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const reviewEl = document.querySelector(".reviewSwiper");
    if (!reviewEl) return;
    new Swiper(".reviewSwiper", {
        loop: true,
        spaceBetween: 25,
        grabCursor: true,
        centeredSlides: false,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        speed: 900,
        breakpoints: {
            0: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 3 },
        }
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const blogEl = document.querySelector(".blogSwiper");
    if (!blogEl) return;
    new Swiper(".blogSwiper", {
        loop: true,
        spaceBetween: 28,
        speed: 900,
        grabCursor: true,
        autoplay: {
            delay: 2800,
            disableOnInteraction: false,
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            640: { slidesPerView: 1.2 },
            768: { slidesPerView: 2 },
            1200: { slidesPerView: 4 },
        }
    });
});
</script>
@endpush
