@extends('layouts.app')

@section('title', 'Home')

@php
    use App\Models\HomepageSection;
    use App\Models\Tour;
    use App\Models\Category;
    use App\Models\Destination;
    $enabledSections = HomepageSection::where('is_enabled', true)->orderBy('sort_order')->get();
    $showCategories = Category::where('is_active', true)->orderBy('sort_order')->get();
    $showDestinations = Destination::where('is_active', true)->orderBy('sort_order')->get();
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

        @if($section->key === 'why_choose_us' && $settings)
            <section class="py-16 bg-white">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $settings['title'] ?? 'Why Choose Us' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-3 text-lg text-gray-600">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if(!empty($settings['features']))
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                            @foreach($settings['features'] as $feature)
                                <div class="text-center p-6">
                                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $feature['title'] ?? '' }}</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">{{ $feature['description'] ?? '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

        @elseif($section->key === 'popular_tours' && $settings)
            @php
                $ptIds = $settings['tour_ids'] ?? [];
                $ptTours = $ptIds ? Tour::whereIn('id', $ptIds)->where('is_active', true)->get() : collect();
            @endphp
            <section class="py-16 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $settings['title'] ?? 'Popular Tours' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-3 text-lg text-gray-600">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if($ptTours->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($ptTours as $tour)
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
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                                            <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>{{ $tour->title }}</a>
                                        </h3>
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
                            @endforeach
                        </div>
                        <div class="text-center mt-8">
                            <a href="{{ route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-6 py-3 border-2 border-primary-600 text-primary-600 font-semibold rounded-lg hover:bg-primary-50 transition-colors">
                                View All Tours
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

        @elseif($section->key === 'cta' && $settings)
            <section class="relative py-20 bg-cover bg-center" style="background-image: url('{{ $settings['background_image'] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}');">
                <div class="absolute inset-0 bg-primary-900/70"></div>
                <div class="relative max-w-7xl mx-auto px-4 text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $settings['title'] ?? 'Ready for an Unforgettable Adventure?' }}</h2>
                    @if(!empty($settings['description']))
                        <p class="text-lg text-primary-200 mb-8 max-w-2xl mx-auto">{{ $settings['description'] }}</p>
                    @endif
                    <a href="{{ $settings['button_link'] ?? route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 bg-white text-primary-600 font-semibold rounded-lg hover:bg-primary-50 transition-colors text-lg shadow-lg">
                        {{ $settings['button_text'] ?? 'Start Your Adventure' }}
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </section>

        @elseif($section->key === 'popular_destinations' && $settings)
            @php
                $destIds = $settings['tour_ids'] ?? [];
                $destTours = $destIds ? Tour::whereIn('id', $destIds)->where('is_active', true)->get() : collect();
            @endphp
            <section class="py-16 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                <div class="max-w-7xl mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-900">{{ $settings['title'] ?? 'Popular Destinations' }}</h2>
                        @if(!empty($settings['subtitle']))
                            <p class="mt-3 text-lg text-gray-600">{{ $settings['subtitle'] }}</p>
                        @endif
                    </div>
                    @if($destTours->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($destTours as $tour)
                                <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                                    <img src="{{ $tour->featured_image ?? $tour->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $tour->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4">
                                        <h3 class="text-white font-semibold text-lg">{{ $tour->title }}</h3>
                                        <p class="text-primary-200 text-sm">From ${{ number_format($tour->sale_price ?? $tour->price, 2) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <a href="{{ route('tours') }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Niagara Falls" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-white font-semibold text-lg">Niagara Falls</h3>
                                    <p class="text-primary-200 text-sm">Explore Tours</p>
                                </div>
                            </a>
                            <a href="{{ route('tours') }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1572274401328-0a7cb0d2c649?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Niagara-on-the-Lake" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-white font-semibold text-lg">Niagara-on-the-Lake</h3>
                                    <p class="text-primary-200 text-sm">Explore Tours</p>
                                </div>
                            </a>
                            <a href="{{ route('tours') }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Toronto" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-white font-semibold text-lg">Toronto</h3>
                                    <p class="text-primary-200 text-sm">Explore Tours</p>
                                </div>
                            </a>
                            <a href="{{ route('tours') }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Wine Country" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-4">
                                    <h3 class="text-white font-semibold text-lg">Wine Country</h3>
                                    <p class="text-primary-200 text-sm">Explore Tours</p>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    @endforeach

    @if($showCategories->isNotEmpty())
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Browse by Category</h2>
                    <p class="mt-3 text-lg text-gray-600">Find the perfect tour for your style</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach($showCategories as $cat)
                        <a href="{{ route('tours', ['selectedCategories' => [$cat->id]]) }}" wire:navigate class="group flex flex-col items-center p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md hover:border-primary-200 transition-all">
                            @if($cat->image)
                                <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-16 h-16 object-cover rounded-full mb-3">
                            @else
                                <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                            @endif
                            <span class="text-sm font-medium text-gray-900 group-hover:text-primary-600 transition-colors">{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($showDestinations->isNotEmpty())
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900">Popular Destinations</h2>
                    <p class="mt-3 text-lg text-gray-600">Explore tours by destination</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($showDestinations as $dest)
                        <a href="{{ route('tours', ['selectedDestinations' => [$dest->id]]) }}" wire:navigate class="group relative h-64 rounded-xl overflow-hidden">
                            @if($dest->image)
                                <img src="{{ $dest->image }}" alt="{{ $dest->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3 class="text-white font-semibold text-lg">{{ $dest->name }}</h3>
                                <p class="text-primary-200 text-sm">{{ $dest->tours()->where('is_active', true)->count() }} tours</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
