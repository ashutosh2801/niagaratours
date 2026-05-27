<div>
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

                    <a href="{{ route('destinations') }}"
                    class="hover:text-primary-600 transition">
                        Destinations
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
                        {{ $destination->name }}
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight w-full">
                    {{ $destination->name }} Tours
                </h1>
                <p class="mt-2 text-gray-600">{{ $destination->description ?? 'Explore tours in ' . $destination->name }}.</p>

            </div>
        </div>
    </section>

    <section class="py-8 bg-gray-50">
    <div class="container-fluid mx-auto px-4">
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
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @forelse($tours ?? [] as $tour)

                @php
                    $startingPrice = $tour->starting_price ?: $tour->price;
                    $oldPrice = $startingPrice ? $startingPrice + 70 : 280;

                    $image = $tour->featured_image
                        ?? ($tour->images[0] ?? 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=1200&auto=format&fit=crop');

                    $rating = $tour->rating ?? 5;
                @endphp

                <div class="group relative mb-2">

                    <div class="relative h-full rounded-[24px] bg-white/70 backdrop-blur-xl border border-white/50 overflow-hidden shadow-[0_20px_20px_rgba(15,23,42,0.08)] transition-all duration-700 hover:-translate-y-3 hover:shadow-[0_20px_20px_rgba(15,23,42,0.18)]">

                        {{-- IMAGE --}}
                        <div class="relative overflow-hidden">

                            <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>

                                <img
                                    src="{{ $image }}"
                                    alt="{{ $tour->title }}"
                                    class="w-full h-[280px] object-cover transition duration-[1200ms] group-hover:scale-110"
                                >

                            </a>

                            {{-- OVERLAY --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                            {{-- SELL OUT --}}
                            @if($loop->first)
                                <div class="absolute top-5 left-5">

                                    <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 text-white text-xs font-semibold tracking-wide shadow-lg">

                                        Likely to Sell Out

                                    </div>

                                </div>
                            @endif

                            {{-- RATING --}}
                            <div class="absolute top-5 right-5">

                                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/15 backdrop-blur-md border border-white/20 shadow-lg">

                                    <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>

                                    <span class="text-white text-sm font-bold">
                                        {{ number_format($rating,1) }}
                                    </span>

                                </div>

                            </div>

                            {{-- PRICE --}}
                            <div class="absolute bottom-0 left-0 right-0 p-6">

                                <div class="flex items-end justify-between">

                                    <div>

                                        <div class="text-white/60 line-through text-sm mb-1">

                                            ${{ number_format($oldPrice, 2) }}

                                        </div>

                                        <div class="flex items-end gap-1">

                                            <span class="text-white/70 text-sm mb-1">
                                                From
                                            </span>

                                            <span class="text-3xl font-bold text-white leading-none">

                                                ${{ number_format($startingPrice ?? 210, 0) }}

                                            </span>

                                        </div>

                                    </div>

                                    <a
                                        href="{{ route('tour.detail', $tour->slug) }}"
                                        wire:navigate
                                        class="w-10 h-10 rounded-2xl bg-white text-gray-900 flex items-center justify-center shadow-2xl transition-all duration-300 hover:bg-primary-600 hover:text-white hover:scale-110"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"/>

                                        </svg>

                                    </a>

                                </div>

                            </div>

                        </div>

                        {{-- CONTENT --}}
                        <div class="p-4">

                            <h3 class="text-[18px] font-bold leading-snug text-gray-900 mb-2 tracking-tight group-hover:text-primary-600 transition duration-300">

                                <a href="{{ route('tour.detail', $tour->slug) }}" wire:navigate>

                                    {{ $tour->title }}

                                </a>

                            </h3>

                            <p class="text-[15px] leading-tight text-gray-500 mb-5 line-clamp-1">

                                {{ $tour->short_description ?? 'Experience breathtaking destinations with luxury comfort.' }}

                            </p>

                            <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent mb-6"></div>

                            {{-- FEATURES --}}
                            <div class="grid grid-cols-2 gap-4">

                                {{-- DURATION --}}
                                <div class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100">

                                    <div class="w-11 h-11 rounded-xl bg-white shadow-sm flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-primary-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>

                                        </svg>

                                    </div>

                                    <div>

                                        <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">

                                            Duration

                                        </div>

                                        <div class="text-sm font-bold text-gray-900">

                                            {{ $tour->duration ?? '6 Hours' }}

                                        </div>

                                    </div>

                                </div>

                                {{-- GUESTS --}}
                                <div class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100">

                                    <div class="w-11 h-11 rounded-xl bg-white shadow-sm flex items-center justify-center">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-primary-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>

                                        </svg>

                                    </div>

                                    <div>

                                        <div class="text-xs uppercase tracking-wide text-gray-400 font-semibold">

                                            Guests

                                        </div>

                                        <div class="text-sm font-bold text-gray-900">

                                            {{ $tour->max_people ?: '12' }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-full py-16 text-center">

                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>

                    </svg>

                    <h3 class="text-lg font-medium text-gray-900 mb-1">
                        No tours found
                    </h3>

                    <p class="text-gray-500">
                        No tours available for this destination yet.
                    </p>

                </div>

            @endforelse
        </div>

        @if(method_exists($tours ?? [], 'links'))
            <div class="mt-8">
                {{ $tours->links() }}
            </div>
        @endif
    </div>
</section>
</div>
