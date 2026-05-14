@extends('layouts.app')

@section('title', $tour->title ?? 'Tour Details')

@section('content')
    <!-- Hero / Gallery -->
    @php
        $allImages = array_merge(
            $tour->featured_image ? [$tour->featured_image] : [],
            $tour->images ?? []
        );
        $mainImage = $allImages[0] ?? null;
        $thumbImages = array_slice($allImages, 1, 4);
        $remainingCount = count($allImages) - 5;
    @endphp
    <section class="relative"
             x-data="{ galleryOpen: false, currentIndex: 0, images: {{ json_encode($allImages) }} }"
             @keydown.window.escape="galleryOpen = false"
             @keydown.window.left="currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1"
             @keydown.window.right="currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0">

        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-2 h-[300px] lg:h-[400px]">
            {{-- Main large image --}}
            <div class="lg:col-span-3 relative overflow-hidden rounded-lg bg-gray-900 h-full">
                @if($mainImage)
                    <img src="{{ $mainImage }}" alt="{{ $tour->title }}" class="w-full h-full object-cover cursor-pointer" @click="galleryOpen = true; currentIndex = 0">
                @else
                    <img src="https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="{{ $tour->title }}" class="w-full h-full object-cover cursor-pointer" @click="galleryOpen = true; currentIndex = 0">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 pointer-events-none">
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        @if($tour->category)
                            <span class="px-3 py-1 bg-primary-600 text-white text-sm font-medium rounded-full">{{ $tour->category->name }}</span>
                        @endif
                        <span class="flex items-center gap-1 text-white/80 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $tour->location ?? 'Niagara Falls' }}
                        </span>
                        <span class="flex items-center gap-1 text-white/80 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $tour->duration ?? '2 hours' }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-white">{{ $tour->title }}</h1>
                </div>
            </div>

            {{-- Thumbnails grid (right side) --}}
            @if(count($thumbImages) > 0)
                <div class="hidden lg:grid grid-cols-2 gap-2 h-full">
                    @foreach($thumbImages as $index => $img)
                        <div class="relative overflow-hidden rounded-lg bg-gray-900 cursor-pointer group h-full"
                             @click="galleryOpen = true; currentIndex = {{ $index + 1 }}">
                            <img src="{{ $img }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if($index === 3 && $remainingCount > 0)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                    <span class="text-white text-lg font-bold">+{{ $remainingCount }} more</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @for($i = count($thumbImages); $i < 4; $i++)
                        <div class="rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 h-full"></div>
                    @endfor
                </div>
            @endif
        </div>

        {{-- View all photos button --}}
        @if(count($allImages) > 1)
            <div class="max-w-7xl mx-auto px-4 mt-2">
                <button @click="galleryOpen = true; currentIndex = 0"
                        class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-900 text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    View all photos ({{ count($allImages) }})
                </button>
            </div>
        @endif

        {{-- Mobile thumbnails row --}}
        @if(count($thumbImages) > 0)
            <div class="max-w-7xl mx-auto px-4 mt-2 flex gap-2 overflow-x-auto pb-1 lg:hidden">
                @foreach($thumbImages as $index => $img)
                    <div class="w-20 h-14 shrink-0 rounded-lg overflow-hidden cursor-pointer" @click="galleryOpen = true; currentIndex = {{ $index + 1 }}">
                        <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                    </div>
                @endforeach
                @if($remainingCount > 0)
                    <div class="w-20 h-14 shrink-0 rounded-lg overflow-hidden bg-black/80 flex items-center justify-center cursor-pointer" @click="galleryOpen = true; currentIndex = 4">
                        <span class="text-white text-xs font-bold">+{{ $remainingCount }}</span>
                    </div>
                @endif
            </div>
        @endif

        {{-- Gallery Modal --}}
        <div x-show="galleryOpen"
             x-cloak
             class="fixed inset-0 z-50 bg-black/70 flex items-center justify-center"
             x-transition.opacity.duration.300ms
             @click.self="galleryOpen = false">

            <button @click="galleryOpen = false" class="absolute top-4 right-4 text-white/80 hover:text-white z-10 transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="absolute top-6 left-1/2 -translate-x-1/2 text-white/80 text-sm font-medium z-10" x-text="`${currentIndex + 1} / ${images.length}`"></div>

            <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : images.length - 1"
                    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 flex items-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 text-white rounded-full transition-colors backdrop-blur-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                <span class="text-sm font-medium hidden md:inline">Previous</span>
            </button>

            <div class="flex items-center justify-center w-full h-full p-16">
                <img :src="images[currentIndex]" alt="" class="max-w-full max-h-full object-contain">
            </div>

            <button @click="currentIndex = currentIndex < images.length - 1 ? currentIndex + 1 : 0"
                    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 flex items-center gap-2 px-4 py-3 bg-white/10 hover:bg-white/20 text-white rounded-full transition-colors backdrop-blur-sm">
                <span class="text-sm font-medium hidden md:inline">Next</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 max-w-[90vw] overflow-x-auto pb-1 z-10">
                <template x-for="(img, index) in images" :key="index">
                    <div @click="currentIndex = index"
                         :class="{ 'ring-2 ring-white ring-offset-2 ring-offset-black': currentIndex === index, 'opacity-60 hover:opacity-100': currentIndex !== index }"
                         class="w-16 h-10 shrink-0 rounded overflow-hidden cursor-pointer transition-all">
                        <img :src="img" alt="" class="w-full h-full object-cover">
                    </div>
                </template>
            </div>
        </div>
    </section>

    <x-breadcrumbs :items="[
        ['label' => 'Tours', 'url' => route('tours')],
        ['label' => $tour->title],
    ]" />

    <!-- Main Content -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Left: Tabbed Content -->
                <div class="lg:col-span-2">
                    <div x-data="{ tab: 'overview' }" class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <!-- Tabs -->
                        <div class="border-b border-gray-200">
                            <nav class="flex overflow-x-auto">
                                <button @click="tab = 'overview'" :class="{ 'text-primary-600 border-primary-600': tab === 'overview', 'text-gray-500 border-transparent hover:text-gray-700': tab !== 'overview' }" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Overview</button>
                                <button @click="tab = 'highlights'" :class="{ 'text-primary-600 border-primary-600': tab === 'highlights', 'text-gray-500 border-transparent hover:text-gray-700': tab !== 'highlights' }" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Highlights</button>
                                <button @click="tab = 'itinerary'" :class="{ 'text-primary-600 border-primary-600': tab === 'itinerary', 'text-gray-500 border-transparent hover:text-gray-700': tab !== 'itinerary' }" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Itinerary</button>
                                <button @click="tab = 'inclusions'" :class="{ 'text-primary-600 border-primary-600': tab === 'inclusions', 'text-gray-500 border-transparent hover:text-gray-700': tab !== 'inclusions' }" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">Inclusions</button>
                                <button @click="tab = 'faq'" :class="{ 'text-primary-600 border-primary-600': tab === 'faq', 'text-gray-500 border-transparent hover:text-gray-700': tab !== 'faq' }" class="px-6 py-4 text-sm font-medium border-b-2 whitespace-nowrap transition-colors">FAQ</button>
                            </nav>
                        </div>

                        <!-- Tab Panels -->
                        <div class="p-6">
                            <!-- Overview -->
                            <div x-show="tab === 'overview'" class="prose prose-gray max-w-none">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tour Overview</h2>
                                <p class="text-gray-600 leading-relaxed">{{ $tour->description ?? 'Experience the breathtaking beauty of Niagara Falls with our expert-guided tour. This unforgettable journey takes you up close to the thundering waterfalls, through scenic tunnels, and aboard the iconic Maid of the Mist boat cruise.' }}</p>
                            </div>

                            <!-- Highlights -->
                            <div x-show="tab === 'highlights'" x-cloak>
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tour Highlights</h2>
                                <ul class="space-y-3">
                                    @forelse($tour->highlights ?? [] as $highlight)
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span class="text-gray-600">{{ $highlight }}</span>
                                        </li>
                                    @empty
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span class="text-gray-600">Up-close views of Horseshoe Falls</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span class="text-gray-600">Maid of the Mist boat cruise</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span class="text-gray-600">Journey Behind the Falls</span>
                                        </li>
                                        <li class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span class="text-gray-600">Skylon Tower observation deck</span>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>

                            <!-- Itinerary -->
                            <div x-show="tab === 'itinerary'" x-cloak>
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Itinerary</h2>
                                <div class="space-y-4">
                                    @forelse($tour->itinerary ?? [] as $item)
                                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-primary-600">{{ $loop->iteration }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $item['title'] ?? 'Stop ' . $loop->iteration }}</h4>
                                                <p class="text-sm text-gray-600 mt-1">{{ $item['description'] ?? 'Details about this stop on your tour.' }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-primary-600">1</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Welcome & Orientation</h4>
                                                <p class="text-sm text-gray-600 mt-1">Meet your guide at the designated pickup location.</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-primary-600">2</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Maid of the Mist</h4>
                                                <p class="text-sm text-gray-600 mt-1">Experience the falls up close on this iconic boat tour.</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-primary-600">3</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Journey Behind the Falls</h4>
                                                <p class="text-sm text-gray-600 mt-1">Explore tunnels behind the cascading water.</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-4 p-4 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center shrink-0">
                                                <span class="text-sm font-bold text-primary-600">4</span>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-900">Free Time & Departure</h4>
                                                <p class="text-sm text-gray-600 mt-1">Enjoy free time at the falls before return transfer.</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Inclusions / Exclusions -->
                            <div x-show="tab === 'inclusions'" x-cloak>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Inclusions</h2>
                                        <ul class="space-y-2">
                                            @forelse($tour->inclusions ?? [] as $inclusion)
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="text-sm text-gray-600">{{ $inclusion }}</span>
                                                </li>
                                            @empty
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="text-sm text-gray-600">Professional tour guide</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="text-sm text-gray-600">Hotel pickup and drop-off</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="text-sm text-gray-600">Maid of the Mist boat ticket</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-green-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    <span class="text-sm text-gray-600">Journey Behind the Falls admission</span>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Exclusions</h2>
                                        <ul class="space-y-2">
                                            @forelse($tour->exclusions ?? [] as $exclusion)
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span class="text-sm text-gray-600">{{ $exclusion }}</span>
                                                </li>
                                            @empty
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span class="text-sm text-gray-600">Personal expenses</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span class="text-sm text-gray-600">Meals and beverages</span>
                                                </li>
                                                <li class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                    <span class="text-sm text-gray-600">Gratuities (optional)</span>
                                                </li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ -->
                            <div x-show="tab === 'faq'" x-cloak>
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">Frequently Asked Questions</h2>
                                <div class="space-y-3">
                                    @forelse($tour->faqs ?? [] as $faq)
                                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
                                                <span class="font-medium text-gray-900 text-sm">{{ $faq['question'] ?? $faq }}</span>
                                                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <div x-show="open" x-cloak class="px-5 pb-4">
                                                <p class="text-sm text-gray-600">{{ $faq['answer'] ?? '' }}</p>
                                            </div>
                                        </div>
                                    @empty
                                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
                                                <span class="font-medium text-gray-900 text-sm">What should I bring?</span>
                                                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <div x-show="open" x-cloak class="px-5 pb-4">
                                                <p class="text-sm text-gray-600">Comfortable walking shoes, a light jacket, and your camera! We provide rain ponchos for the boat ride.</p>
                                            </div>
                                        </div>
                                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
                                                <span class="font-medium text-gray-900 text-sm">Is the tour wheelchair accessible?</span>
                                                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <div x-show="open" x-cloak class="px-5 pb-4">
                                                <p class="text-sm text-gray-600">Most of our tours are wheelchair accessible. Please contact us for specific accommodations.</p>
                                            </div>
                                        </div>
                                        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
                                            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
                                                <span class="font-medium text-gray-900 text-sm">What is the cancellation policy?</span>
                                                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                            </button>
                                            <div x-show="open" x-cloak class="px-5 pb-4">
                                                <p class="text-sm text-gray-600">Free cancellation up to 48 hours before the tour. Full refund guaranteed.</p>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Booking Sidebar -->
                <aside class="lg:col-span-1 mt-8 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                        <div class="mb-6">
                            @if($tour->sale_price ?? false)
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-gray-900">${{ number_format($tour->sale_price, 2) }}</span>
                                    <span class="text-lg text-gray-400 line-through">${{ number_format($tour->price, 2) }}</span>
                                </div>
                                <span class="text-sm text-green-600 font-medium">You save ${{ number_format($tour->price - $tour->sale_price, 2) }}</span>
                            @else
                                <span class="text-3xl font-bold text-gray-900">${{ number_format($tour->price ?? 99.99, 2) }}</span>
                            @endif
                            <span class="text-sm text-gray-500">/ per person</span>
                        </div>

                        <form wire:submit.prevent="bookTour" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                                <input type="date" wire:model="travelDate" min="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                    <button type="button" wire:click="decrementQuantity" class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                    </button>
                                    <input type="number" wire:model="quantity" min="1" max="20" class="w-full text-center border-0 focus:ring-0 text-sm">
                                    <button type="button" wire:click="incrementQuantity" class="px-3 py-2 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">${{ number_format($tour->price ?? 99.99, 2) }} x {{ $quantity ?? 1 }}</span>
                                    <span class="text-gray-900 font-medium">${{ number_format(($tour->sale_price ?? $tour->price ?? 99.99) * ($quantity ?? 1), 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Tax (13% HST)</span>
                                    <span class="text-gray-900 font-medium">${{ number_format(($tour->sale_price ?? $tour->price ?? 99.99) * ($quantity ?? 1) * 0.13, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 flex items-center justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total</span>
                                    <span class="text-xl font-bold text-primary-600">${{ number_format(($tour->sale_price ?? $tour->price ?? 99.99) * ($quantity ?? 1) * 1.13, 2) }}</span>
                                </div>
                            </div>

                            @if(($tour->booking_type ?? 'internal') === 'external' && $tour->booking_url)
                                <a href="{{ $tour->booking_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                    Book Now
                                </a>
                            @else
                                <a href="{{ route('booking.create', $tour) }}" wire:navigate class="block w-full text-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                                    Book Now
                                </a>
                            @endif
                        </form>

                        <div class="mt-4 space-y-2 text-sm text-gray-500">
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
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Related Tours -->
    @if(($relatedTours ?? null) && count($relatedTours) > 0)
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold text-gray-900">Related Tours</h2>
                    <p class="mt-2 text-gray-600">You might also be interested in</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedTours as $related)
                        <div class="group bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $related->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @if($related->category)
                                    <span class="absolute top-3 left-3 px-3 py-1 bg-primary-600 text-white text-xs font-medium rounded-full">{{ $related->category->name }}</span>
                                @endif
                            </div>
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('tours.show', $related) }}" wire:navigate>{{ $related->title }}</a>
                                </h3>
                                <div class="flex items-center gap-1 mt-2 mb-3">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($related->rating ?? 5))
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endif
                                    @endfor
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($related->sale_price ?? $related->price, 2) }}</span>
                                    <a href="{{ route('tours.show', $related) }}" wire:navigate class="text-sm font-medium text-primary-600 hover:text-primary-700">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
