<div>
    @php
        $schemaImages = collect(array_merge(
            $tour->images ?? [],
            $tour->featured_image ? [$tour->featured_image] : []
        ))->filter()->map(fn($img) => str_starts_with($img, 'http') ? $img : url($img))->values()->toArray();

        $schemaPrice = ($tour->starting_price ?: $tour->price) ?: 0;
    @endphp
    @push('head')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}"},
            {"@type": "ListItem", "position": 2, "name": "Tours", "item": "{{ route('tours') }}"},
            {"@type": "ListItem", "position": 3, "name": "{{ $tour->title }}"}
        ]
    }
    </script>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "Product",
        "@id": "{{ route('tour.detail', $tour->slug) }}#product",
        "name": "{{ $tour->title }}",
        "description": "{{ strip_tags($tour->short_description ?: $tour->description ?? '') }}",
        "url": "{{ route('tour.detail', $tour->slug) }}",
        "image": {{ json_encode($schemaImages) }},
        "brand": {
            "@type": "Brand",
            "name": "{{ App\Models\Setting::get('site_name', 'Niagara Tours') }}"
        },
        "offers": {
            "@type": "Offer",
            "price": "{{ number_format($schemaPrice, 2, '.', '') }}",
            "priceCurrency": "CAD",
            "availability": "https://schema.org/InStock",
            "url": "{{ route('tour.detail', $tour->slug) }}"
        }
        @if(($tour->review_count ?? 0) > 0)
        ,"aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "{{ number_format($tour->rating ?? 5, 1) }}",
            "reviewCount": "{{ $tour->review_count }}",
            "bestRating": "5"
        }
        @endif
    }
    </script>
    @endpush

    {{-- =========================
        TOP HERO SECTION
    ========================== --}}
    <section>
        <div class="bg-[#F8FAFB] border-t border-b border-gray-200">

            <div class="container-fluid mx-auto px-4 py-10">

                {{-- Breadcrumb --}}
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-8">

                    <a href="{{ route('home') }}"
                    class="hover:text-primary-600 transition">
                        Home
                    </a>

                    <svg class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>
                    </svg>

                    <a href="{{ route('tours') }}"
                    class="hover:text-primary-600 transition">
                        Tours
                    </a>

                    <svg class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>
                    </svg>

                    <span class="text-gray-700 truncate">
                        {{ $tour->title }}
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight w-full">
                    {{ $tour->title }}
                </h1>

                {{-- Meta Info --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-8 gap-x-6 mt-14">

                    {{-- PRICE --}}
                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 rounded-full border border-[#d9d9d9] bg-white flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#d52b1e]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 0V5m0 9v3m7-7h-3M8 12H5"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                from
                            </p>

                            <h3 class="text-2xl font-bold text-[#d52b1e]">
                                ${{ number_format($tour->price ?? 0, 2) }}
                            </h3>
                        </div>

                    </div>

                    {{-- DURATION --}}
                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 rounded-full border border-[#d9d9d9] bg-white flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#d52b1e]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                Duration
                            </p>

                            <h3 class="text-xl font-medium text-black">
                                {{ $tour->duration ?? '4 days' }}
                            </h3>
                        </div>

                    </div>

                    {{-- MAX PEOPLE --}}
                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 rounded-full border border-[#d9d9d9] bg-white flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#d52b1e]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                                <circle cx="9" cy="7" r="4"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M23 21v-2a4 4 0 00-3-3.87"/>
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 3.13a4 4 0 010 7.75"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                Max People
                            </p>

                            <h3 class="text-xl font-medium text-black">
                                {{ $tour->max_people ?? '100' }}
                            </h3>
                        </div>

                    </div>

                    {{-- MIN AGE --}}
                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 rounded-full border border-[#d9d9d9] bg-white flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#d52b1e]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 14c2.761 0 5-2.239 5-5S14.761 4 12 4 7 6.239 7 9s2.239 5 5 5zm0 0c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                Min Age
                            </p>

                            <h3 class="text-xl font-medium text-black">
                                {{ $tour->min_age ?? '10+' }}
                            </h3>
                        </div>

                    </div>

                    {{-- TOUR TYPE --}}
                    <div class="flex items-center gap-4">

                        <div class="w-16 h-16 rounded-full border border-[#d9d9d9] bg-white flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-[#d52b1e]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-2m-6 2V2m6 16l5.447-2.724A1 1 0 0021 14.382V3.618a1 1 0 00-.553-.894L15 0m0 18V0m-6 2l6-2"/>
                            </svg>
                        </div>

                        <div>
                            <p class="text-gray-500 text-sm">
                                Tour Type
                            </p>

                            <h3 class="text-xl font-medium text-black leading-snug">
                                {{ $tour->category->name ?? 'Bike Tours' }}
                            </h3>
                        </div>

                    </div>

                    {{-- REVIEWS --}}
                    <div class="flex items-center gap-4">

                        <div>
                            <p class="text-gray-500 text-sm mb-1">
                                Reviews
                            </p>

                            <div class="flex items-center gap-2">

                                <div class="flex items-center">

                                    @for($i = 1; $i <= 5; $i++)

                                        <svg class="w-5 h-5 {{ $i <= round($tour->rating ?? 4) ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>

                                    @endfor

                                </div>

                                <span class="text-xl font-medium text-black">
                                    {{ $tour->rating ?? '4.33' }}/5
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="mt-5">
        {{-- =========================================
            TOUR GALLERY
        ========================================= --}}

        @php
            $allImages = $tour->images ?? [];

            if ($tour->featured_image && !in_array($tour->featured_image, $allImages)) {
                array_unshift($allImages, $tour->featured_image);
            }

            $mainImage = $allImages[0] ?? null;
            $sideImages = array_slice($allImages, 1, 4);
        @endphp

        <section
            x-data="{
                galleryOpen: false,
                currentIndex: 0,
                images: {{ json_encode($allImages) }},

                next() {
                    this.currentIndex =
                        this.currentIndex < this.images.length - 1
                            ? this.currentIndex + 1
                            : 0
                },

                prev() {
                    this.currentIndex =
                        this.currentIndex > 0
                            ? this.currentIndex - 1
                            : this.images.length - 1
                }
            }"
            @keydown.window.escape="galleryOpen = false"
            @keydown.window.right="next()"
            @keydown.window.left="prev()"
            class="py-2 bg-white"
        >

            <div class="container-fluid mx-auto px-4">

                {{-- =========================================
                    MOBILE SLIDER
                ========================================== --}}
                <div class="md:hidden">

                    <div class="flex gap-3 overflow-x-auto snap-x snap-mandatory scrollbar-hide">

                        @foreach($allImages as $index => $img)

                            <div
                                class="min-w-full snap-center"
                            >
                                <img
                                    src="{{ $img }}"
                                    alt=""
                                    loading="lazy"
                                    @click="
                                        galleryOpen = true;
                                        currentIndex = {{ $index }}
                                    "
                                    class="w-full h-72 object-cover rounded-2xl cursor-pointer"
                                >
                            </div>

                        @endforeach

                    </div>

                    {{-- Mobile thumbnails --}}
                    <div class="flex gap-2 mt-3 overflow-x-auto scrollbar-hide">

                        @foreach($allImages as $index => $img)

                            <button
                                @click="
                                    galleryOpen = true;
                                    currentIndex = {{ $index }}
                                "
                                class="shrink-0"
                            >
                                <img
                                    src="{{ $img }}"
                                    alt=""
                                    class="w-20 h-16 object-cover rounded-lg border-2"
                                    :class="currentIndex === {{ $index }}
                                        ? 'border-primary-600'
                                        : 'border-transparent'"
                                >
                            </button>

                        @endforeach

                    </div>

                </div>

                {{-- =========================================
                    DESKTOP GRID
                ========================================== --}}
                <div class="hidden md:grid grid-cols-5 gap-3">

                    {{-- BIG IMAGE --}}
                    <div class="col-span-3 row-span-2">

                        @if($mainImage)

                            <img
                                src="{{ $mainImage }}"
                                alt="{{ $tour->title }}"
                                loading="lazy"
                                @click="
                                    galleryOpen = true;
                                    currentIndex = 0
                                "
                                class="w-full h-[450px] object-cover rounded-2xl cursor-pointer"
                            >

                        @endif

                    </div>

                    {{-- SIDE IMAGES --}}
                    @foreach($sideImages as $index => $img)

                        <div class="relative overflow-hidden rounded-2xl">

                            <img
                                src="{{ $img }}"
                                alt=""
                                loading="lazy"
                                @click="
                                    galleryOpen = true;
                                    currentIndex = {{ $index + 1 }}
                                "
                                class="w-full h-[220px] object-cover rounded-2xl cursor-pointer hover:scale-105 transition duration-500"
                            >

                            {{-- LAST IMAGE OVERLAY --}}
                            @if($loop->last && count($allImages) > 5)

                                <button
                                    @click="
                                        galleryOpen = true;
                                        currentIndex = 0
                                    "
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center"
                                >
                                    <span class="text-white text-xl font-bold">
                                        +{{ count($allImages) - 5 }} More
                                    </span>
                                </button>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>

            {{-- =========================================
                LIGHTBOX MODAL
            ========================================== --}}
            <div
                x-show="galleryOpen"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-[999] bg-black/95 flex items-center justify-center"
            >

                {{-- CLOSE --}}
                <button
                    @click="galleryOpen = false"
                    class="absolute top-5 right-5 z-50 text-white hover:text-gray-300"
                >
                    <svg class="w-10 h-10"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- PREV --}}
                <button
                    @click="prev()"
                    class="absolute left-5 top-1/2 -translate-y-1/2 z-50 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full p-3"
                >
                    <svg class="w-8 h-8 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                {{-- NEXT --}}
                <button
                    @click="next()"
                    class="absolute right-5 top-1/2 -translate-y-1/2 z-50 bg-white/10 hover:bg-white/20 backdrop-blur-md rounded-full p-3"
                >
                    <svg class="w-8 h-8 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                {{-- IMAGE --}}
                <div class="w-full h-full flex items-center justify-center p-4 md:p-16">

                    <img
                        :src="images[currentIndex]"
                        alt=""
                        class="max-w-full max-h-full object-contain rounded-xl"
                    >

                </div>

                {{-- COUNTER --}}
                <div
                    class="absolute top-5 left-1/2 -translate-x-1/2 text-white text-sm md:text-base font-medium"
                    x-text="`${currentIndex + 1} / ${images.length}`"
                ></div>

                {{-- THUMBNAILS --}}
                <div class="absolute bottom-5 left-1/2 -translate-x-1/2 flex gap-2 overflow-x-auto max-w-[95vw] px-2">

                    <template x-for="(img, index) in images" :key="index">

                        <button
                            @click="currentIndex = index"
                            class="shrink-0 overflow-hidden rounded-lg border-2 transition"
                            :class="currentIndex === index
                                ? 'border-white'
                                : 'border-transparent opacity-60 hover:opacity-100'"
                        >

                            <img
                                :src="img"
                                alt=""
                                class="w-20 h-16 md:w-24 md:h-20 object-cover"
                            >

                        </button>

                    </template>

                </div>

            </div>

        </section>

        {{-- Tour Info Header --}}
        <section class="py-10">
            <div class="container-fluid mx-auto px-4">
                <div class="flex flex-col-reverse lg:flex-row gap-8">
                    {{-- Left Column --}}
                    <div class="lg:w-2/3">

                        <div class="space-y-8">

                            {{-- DESCRIPTION --}}
                            @if(isset($tour->description) && $tour->description)
                                <div x-data="{ expanded: false }" class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                    <h2 class="text-[26px] font-bold text-gray-900 mb-5">
                                        Description
                                    </h2>

                                    <div class="relative">

                                        {{-- CONTENT --}}
                                        <div
                                            x-ref="content"
                                            :style="expanded
                                                ? 'max-height:' + $refs.content.scrollHeight + 'px'
                                                : 'max-height:130px'"
                                            class="overflow-hidden transition-all duration-500 ease-in-out"
                                        >

                                            <div class="prose prose-gray max-w-none text-gray-600 leading-8">

                                                {!! Purify::clean($tour->description) !!}

                                            </div>

                                        </div>

                                        {{-- FADE --}}
                                        <div
                                            x-show="!expanded"
                                            x-transition
                                            class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#F8FAFB] to-transparent pointer-events-none"
                                        ></div>

                                    </div>

                                    {{-- BUTTON --}}
                                    <button
                                        @click="expanded = !expanded"
                                        class="mt-5 text-sm font-semibold text-[#d52b1e] hover:text-red-700 transition"
                                    >

                                        <span x-text="expanded ? 'Show Less' : 'Show More'"></span>

                                    </button>

                                </div>
                            @endif


                            {{-- HIGHLIGHTS --}}
                            @if(isset($tour->highlights) && count($tour->highlights))

                                <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                        Highlights
                                    </h2>

                                    <div class="space-y-4">

                                        @foreach($tour->highlights as $highlight)

                                            <div class="flex items-start gap-4">

                                                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center shrink-0 mt-0.5">

                                                    <svg class="w-4 h-4 text-red-500"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24">

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M5 13l4 4L19 7"/>

                                                    </svg>

                                                </div>

                                                <p class="text-gray-700 leading-relaxed">
                                                    {{ $highlight }}
                                                </p>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            @endif


                            {{-- ITINERARY --}}
                            @if(isset($tour->itinerary) && count($tour->itinerary))
                                <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                    <h2 class="text-[26px] font-bold text-gray-900 mb-8">
                                        Itinerary
                                    </h2>

                                    <div class="border border-gray-200 rounded-2xl bg-white overflow-hidden">

                                        @foreach($tour->itinerary as $day)

                                            <div class="relative flex gap-5 p-6">

                                                {{-- LEFT TIMELINE --}}
                                                <div class="relative flex flex-col items-center shrink-0">

                                                    {{-- LINE --}}
                                                    @if(!$loop->last)
                                                        <div class="absolute top-16 bottom-[-30px] left-1/2 -translate-x-1/2 border-l-2 border-dashed border-gray-400"></div>
                                                    @endif

                                                    <div class="relative z-10 w-12 h-12 rounded-xl bg-[#d52b1e] text-white flex items-center justify-center font-bold text-sm shadow-md">

                                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}

                                                    </div>

                                                </div>

                                                {{-- CONTENT --}}
                                                <div class="flex-1 min-w-0">

                                                    <div class="flex items-start justify-between gap-4">

                                                        <div>

                                                            <h3 class="text-lg font-bold text-gray-900">
                                                                {{ $day['title'] ?? 'Day '.$loop->iteration }}
                                                            </h3>

                                                            @if(isset($day['date']))
                                                                <p class="text-sm text-gray-400 mt-1">
                                                                    {{ $day['date'] }}
                                                                </p>
                                                            @endif

                                                        </div>

                                                        @if(isset($day['image']))
                                                            <img
                                                                src="{{ $day['image'] }}"
                                                                alt=""
                                                                class="w-14 h-14 rounded-full object-cover border border-gray-200 shrink-0"
                                                            >
                                                        @endif

                                                    </div>

                                                    <div class="mt-4 text-gray-600 leading-7 text-[15px]">

                                                        {!! Purify::clean($day['description'] ?? '') !!}

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            @endif


                            {{-- INCLUDES & EXCLUDES --}}
                            <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                <h2 class="text-2xl font-bold text-gray-900 mb-8">
                                    Includes & Excludes
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    {{-- INCLUSIONS --}}
                                    @if(isset($tour->inclusions) && count($tour->inclusions))
                                        <div>
                                            <div class="space-y-4">

                                                @foreach($tour->inclusions as $item)

                                                    <div class="flex items-start gap-4">

                                                        <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">

                                                            <svg class="w-4 h-4 text-green-600"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24">

                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M5 13l4 4L19 7"/>

                                                            </svg>

                                                        </div>

                                                        <p class="text-gray-700">
                                                            {{ $item }}
                                                        </p>

                                                    </div>

                                                @endforeach

                                            </div>
                                        </div>
                                    @endif

                                    {{-- EXCLUSIONS --}}
                                    @if(isset($tour->exclusions) && count($tour->exclusions))
                                        <div>

                                            <div class="space-y-4">

                                                @foreach($tour->exclusions as $item)

                                                    <div class="flex items-start gap-4">

                                                        <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">

                                                            <svg class="w-4 h-4 text-red-600"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                viewBox="0 0 24 24">

                                                                <path stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M6 18L18 6M6 6l12 12"/>

                                                            </svg>

                                                        </div>

                                                        <p class="text-gray-700">
                                                            {{ $item }}
                                                        </p>

                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>
                                    @endif
                                </div>

                            </div>


                            {{-- LOCATION --}}
                            @if(isset($tour->location))
                                <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                        Location
                                    </h2>

                                    <div class="overflow-hidden rounded-2xl border border-gray-200">

                                        {{-- MAP --}}
                                        <iframe
                                            src="https://maps.google.com/maps?q={{ urlencode($tour->location) }}&t=&z=10&ie=UTF8&iwloc=&output=embed"
                                            class="w-full h-[400px]"
                                            loading="lazy"
                                        ></iframe>

                                    </div>

                                </div>
                            @endif


                            {{-- FAQ --}}
                            @if(isset($tour->faqs) && count($tour->faqs))
                                <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">

                                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                                        Frequently Asked Questions
                                    </h2>

                                    <div class="space-y-4">

                                        @foreach($tour->faqs as $faq)

                                            <div
                                                x-data="{ open: false }"
                                                class="border border-gray-200 rounded-xl overflow-hidden"
                                            >

                                                {{-- QUESTION --}}
                                                <button
                                                    @click="open = !open"
                                                    class="w-full flex items-center justify-between px-5 py-4 bg-white transition"
                                                >

                                                    <span class="font-medium text-gray-900 text-left">

                                                        {{ $faq['question'] ?? '' }}

                                                    </span>

                                                    <svg
                                                        class="w-5 h-5 text-gray-400 transition-transform"
                                                        :class="open ? 'rotate-180' : ''"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >

                                                        <path stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 9l-7 7-7-7"/>

                                                    </svg>

                                                </button>

                                                {{-- ANSWER --}}
                                                <div
                                                    x-show="open"
                                                    x-collapse
                                                    class="px-5 py-3 text-gray-600 leading-relaxed bg-white border-t border-gray-100"
                                                >

                                                    {!! Purify::clean($faq['answer'] ?? '') !!}

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            @endif


                            {{-- REVIEWS --}}
                            <div class="bg-[#F8FAFB] border border-gray-200 rounded-2xl p-6 md:p-8">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

                                    <div>

                                        <h2 class="text-2xl font-bold text-gray-900">
                                            Reviews (45)
                                        </h2>

                                    </div>

                                    <button class="px-5 py-3 rounded-xl bg-[#d52b1e] text-white font-semibold hover:bg-red-700 transition">

                                        Write a Review

                                    </button>

                                </div>

                                {{-- REVIEW STATS --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

                                    {{-- LEFT --}}
                                    <div class="border border-gray-200 bg-white rounded-2xl p-8 text-center">

                                        <h3 class="text-5xl font-black text-gray-900">
                                            4.9
                                            <span class="text-2xl font-bold text-gray-500">
                                                / 5.0
                                            </span>
                                        </h3>

                                        <div class="flex items-center justify-center gap-1 mt-4">

                                            @for($i=0; $i<5; $i++)

                                                <svg class="w-5 h-5 text-yellow-400"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20">

                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>

                                                </svg>

                                            @endfor

                                        </div>

                                        <p class="text-gray-500 mt-3">
                                            Based On 2,459 Reviews
                                        </p>

                                    </div>

                                    {{-- RIGHT --}}
                                    <div class="border border-gray-200 bg-white rounded-2xl p-6 space-y-4">

                                        @foreach([
                                            ['5 Star Ratings', '90%'],
                                            ['4 Star Ratings', '75%'],
                                            ['3 Star Ratings', '55%'],
                                            ['2 Star Ratings', '35%'],
                                            ['1 Star Ratings', '15%'],
                                        ] as $rate)

                                            <div>

                                                <div class="flex justify-between text-sm mb-2">

                                                    <span class="text-gray-600">
                                                        {{ $rate[0] }}
                                                    </span>

                                                    <span class="font-semibold text-gray-900">
                                                        {{ $rate[1] }}
                                                    </span>

                                                </div>

                                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">

                                                    <div
                                                        class="h-full bg-[#d52b1e] rounded-full"
                                                        style="width: {{ $rate[1] }}"
                                                    ></div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- Right Column -- Booking Card --}}
                    <div class="lg:w-1/3">
                        <div class="lg:sticky lg:top-[110px]">

                            <div class="rounded-[28px] bg-[#F8FAFB] border border-gray-200 shadow-[0_10px_30px_rgba(0,0,0,0.08)] overflow-hidden">

                                {{-- HEADER --}}
                                <div class="px-7 pt-7 pb-5 border-b border-gray-100">
                                    <div class="flex items-center justify-between gap-3">

                                        <h3 class="text-2xl font-bold text-gray-900">
                                            Book This Tour
                                        </h3>

                                        {{-- URGENCY BADGE --}}
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-red-50 text-red-600 text-xs font-semibold border border-red-100 whitespace-nowrap">                                            
                                            Likely to sell out
                                        </span>

                                    </div>

                                    {{-- PRICE --}}
                                    <div class="mt-5">
                                        <p class="text-xs text-gray-500 uppercase tracking-wide">
                                            Starting from
                                        </p>

                                        <div class="flex items-end gap-3 mt-1">
                                            @if(isset($tour->discount_price) && $tour->discount_price < $tour->price)
                                                <span class="text-lg text-gray-400 line-through">
                                                    ${{ number_format($tour->price, 2) }}
                                                </span>
                                            @endif
                                            <h2 class="text-4xl font-bold text-primary-600 leading-none">
                                                ${{ number_format($tour->discount_price ?? $tour->price, 2) }}
                                            </h2>                                            

                                        </div>

                                        @if(isset($tour->discount_price) && $tour->discount_price < $tour->price)
                                            <p class="text-xs text-green-600 mt-1 font-medium">
                                                Save {{ round((1 - $tour->discount_price / $tour->price) * 100) }}%
                                            </p>
                                        @endif
                                    </div>

                                </div>

                                {{-- CTA --}}
                                <div class="px-7 pb-6">

                                    @if(($tour->booking_type ?? 'internal') === 'external' && $tour->booking_url)

                                        <a href="{{ $tour->booking_url }}"
                                            target="_blank"
                                            class="block w-full text-center bg-primary-600 hover:bg-primary-500 text-white font-bold py-4 rounded-xl transition">

                                            Book Now

                                        </a>

                                    @else

                                        <button type="button"
                                            wire:click="bookNow"
                                            class="w-full bg-primary-600 hover:bg-primary-500 text-white font-bold py-4 rounded-xl transition">

                                            Book Now

                                        </button>

                                    @endif

                                    {{-- TRUST FEATURES (clean + simple) --}}
                                    <div class="mt-5 space-y-3 text-sm text-gray-600">

                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Free cancellation up to 48 hours</span>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Reserve now, pay later</span>
                                        </div>

                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span>Secure booking</span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

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
</div>
