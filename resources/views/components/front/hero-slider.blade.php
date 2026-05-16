<div>
    <div class="relative bg-gray-900 overflow-hidden" id="hellobackground" style="min-height: 90vh; background-image: url('{{ !empty($slides[0]['image'] ?? '') ? $slides[0]['image'] : 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?auto=format&fit=crop&w=1920&q=80' }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/60 to-gray-900/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-gray-900/10"></div>

        <div class="relative h-full flex items-center" style="min-height: 90vh;">
            <div class="max-w-7xl mx-auto px-4 w-full">
                <div class="flex flex-col lg:flex-row lg:items-center gap-8 lg:gap-12">
                    <!-- Left: Text Content -->
                    <div class="flex-1 max-w-2xl">
                        <h1 class="text-6xl md:text-8xl lg:text-8xl font-black text-white leading-none">
                            TOURS FOR YOUR SENSES
                        </h1>
                        <p class="mt-6 text-xl md:text-2xl text-gray-200 max-w-2xl leading-relaxed">
                            Niagara Tours provides the <strong>BEST</strong> <strong>Niagara Falls tours</strong> for a great day out with your friends. #goniagara
                        </p>
                    </div>

                    <!-- Right: 2x2 Category Image Grid -->
                    @php
                        $heroCategories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(4)->get();
                    @endphp
                    @if($heroCategories->isNotEmpty())
                    <div class="w-full lg:w-auto shrink-0">
                        <div class="grid grid-cols-2 gap-4 md:gap-5">
                            @foreach($heroCategories as $index => $cat)
                                @php
                                    $links = [
                                        route('tours', ['selectedCategories' => [$cat->id]]),
                                        route('tours', ['selectedCategories' => [$cat->id]]),
                                        route('tours', ['selectedCategories' => [$cat->id]]),
                                        route('tours'),
                                    ];
                                    $colors = ['border-primary-500', 'border-amber-400', 'border-pink-500', 'border-emerald-500'];
                                @endphp
                                <a href="{{ $links[$index] ?? route('tours') }}" wire:navigate
                                   class="group relative block w-44 h-44 md:w-64 md:h-64 rounded-xl overflow-hidden border-2 {{ $colors[$index] ?? 'border-white/30' }} hover:shadow-2xl hover:shadow-black/50 transition-all duration-300">
                                    @if($cat->image)
                                        <img src="{{ $cat->image }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full bg-gray-800"></div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
                                    <div class="absolute bottom-3 left-3 right-3 flex items-center gap-2">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm text-white group-hover:bg-primary-500 transition-colors duration-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                        </span>
                                        <span class="text-white group-hover:text-primary-300 text-lg md:text-xl font-bold drop-shadow-lg uppercase tracking-wide">{{ $cat->name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- ONLY THE BEST bar -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
            <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 text-center lg:text-left">
                ONLY THE BEST <span class="text-primary-600">NIAGARA FALLS</span> TOURS
            </h2>
        </div>
    </div>
</div>
