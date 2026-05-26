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

                    <span class="text-gray-700 truncate">
                        All Destinations
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight w-full">
                    All Destinations
                </h1>
                <p class="mt-2 text-gray-600">Explore all our amazing destinations and find your next adventure.</p>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-50">
        <div class="container-fluid mx-auto px-4">
            @if($destinations->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($destinations as $destination)
                        <div class="group relative rounded-[22px] overflow-hidden h-[380px] bg-white shadow-sm border border-gray-200 hover:shadow-xl transition-all duration-300">
                            <img src="{{ $destination->image ?? 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=600&auto=format&fit=crop' }}"
                                 alt="{{ $destination->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-center">
                                <p class="text-white/80 text-sm">Things to do in</p>
                                <h3 class="text-white text-xl font-bold mt-1">{{ $destination->name }}</h3>
                                @if($destination->tours_count)
                                    <p class="text-white/70 text-sm mt-2">{{ $destination->tours_count }} tours</p>
                                @endif
                            </div>
                            <a href="{{ route('tour.detail', $destination->slug) }}" wire:navigate class="absolute inset-0"></a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $destinations->links() }}
                </div>
            @else
                <div class="py-16 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No destinations found</h3>
                    <p class="text-gray-500">Check back soon for new destinations.</p>
                </div>
            @endif
        </div>
    </section>
</div>
