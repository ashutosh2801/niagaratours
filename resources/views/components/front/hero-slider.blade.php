{{-- HERO SECTION --}}
<section
    x-data="heroSlider()"
    x-init="startSlider()"
    class="relative overflow-hidden md:rounded-[34px] container-fluid mx-auto md:px-4"
    style="height: 80vh;"
>
    <!-- BACKGROUND SLIDES -->
    <template x-for="(slide, index) in slides" :key="index">
        <div
            x-show="currentSlide === index"
            x-transition:enter="transition-opacity duration-[2000ms] ease-out"
            x-transition:enter-start="opacity-0 scale-105"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition-opacity duration-[2000ms] ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-110"
            class="absolute inset-0"
        >
            <div
                class="absolute inset-0 bg-cover bg-center bg-no-repeat scale-100 animate-slowZoom"
                :style="`background-image:url(${slide})`"
            ></div>
        </div>
    </template>

    <!-- OVERLAY -->
    <div class="absolute inset-0 bg-black/20"></div>

    <!-- CONTENT -->
    <div class="relative z-10 flex items-center justify-center h-full px-4">
        <div class="w-full md:max-w-6xl text-center">

            <!-- HEADING -->
            <h1
                class="text-white font-semibold leading-tight
                text-[30px] md:text-[40px]
                drop-shadow-[0_4px_12px_rgba(0,0,0,0.65)]"
            >
                Millions Of Experiences. One Simple Search.
            </h1>

            <!-- SUBTEXT -->
            <p
                class="text-white/95 mt-5
                text-[16px] md:text-[20px]
                font-bold
                drop-shadow-[0_2px_8px_rgba(0,0,0,0.6)]"
            >
                Find what makes you happy anytime, anywhere
            </p>

            <!-- DESKTOP SEARCH -->
            <form
                x-data="heroSearch()"
                @submit.prevent="submitSearch()"
                @click.away="open = false"
                class="hidden md:flex items-center justify-between
                bg-white/95 backdrop-blur-md
                rounded-full
                shadow-[0_20px_60px_rgba(0,0,0,0.25)]
                mt-12
                mx-auto
                max-w-3xl
                h-[75px]
                px-4 relative"
            >

                <!-- LOCATION -->
                <div class="flex items-center gap-4 flex-1 relative">

                    <!-- ICON -->
                    <div class="text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-7 h-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>

                    <!-- INPUT -->
                    <div class="text-left w-full">
                        <label class="block text-[14px] font-semibold text-gray-800">
                            Where To?
                        </label>

                        <input
                            type="text"
                            name="search"
                            x-model="query"
                            @keydown.escape="open = false"
                            @keydown.down.prevent="selectedIndex = Math.min(selectedIndex + 1, results.length - 1)"
                            @keydown.up.prevent="selectedIndex = Math.max(selectedIndex - 1, 0)"
                            @keydown.enter="selectHighlighted()"
                            placeholder="Search a place or activitiy Destination"
                            class="w-full bg-transparent border-none outline-none
                            text-[15px] text-gray-500
                            placeholder:text-gray-400 mt-1"
                        >

                        <!-- DROPDOWN -->
                        <div x-show="open" x-cloak
                            @click.outside="open = false"
                            class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 max-h-72 overflow-y-auto"
                        >
                            <template x-for="(result, i) in results" :key="result.id">
                                <a :href="'/tour/' + result.slug"
                                   @click.prevent="selectResult(result)"
                                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-0"
                                   :class="{ 'bg-gray-50': i === selectedIndex }"
                                >
                                    <img :src="result.image || 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=80&auto=format&fit=crop'"
                                         class="w-10 h-10 rounded-lg object-cover shrink-0">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate" x-text="result.title"></p>
                                        <p class="text-xs text-gray-500 truncate" x-text="result.location || ''"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- DIVIDER -->
                <div class="w-px h-12 bg-gray-200 mx-8"></div>

                <!-- DATE -->
                <div class="flex items-center gap-4 flex-1">

                    <!-- ICON -->
                    <div class="text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-7 h-7"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <!-- DATE -->
                    <div class="text-left w-full">
                        <label class="block text-[14px] font-semibold text-gray-800">
                            When?
                        </label>

                        <input
                            type="date"
                            class="w-full bg-transparent border-none outline-none text-gray-500 mt-1 text-[15px]"
                        >
                    </div>
                </div>

                <!-- SEARCH BUTTON -->
                <button type="submit"
                    class="w-[50px] h-[50px]
                    rounded-full
                    bg-[#c53a2f]
                    hover:bg-[#b63429]
                    transition
                    flex items-center justify-center
                    shadow-lg"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            <!-- MOBILE SEARCH -->
            <form
                x-data="heroSearch()"
                @submit.prevent="submitSearch()"
                @click.away="open = false"
                class="md:hidden
                bg-white
                rounded-[28px]
                mt-10
                p-6 relative"
            >

                <!-- LOCATION -->
                <div class="flex gap-4 items-start relative">

                    <div class="pt-1 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>

                    <div class="w-full text-left">
                        <label class="block text-[14px] font-semibold text-gray-800">
                            Where To?
                        </label>

                        <input
                            type="text"
                            name="search"
                            x-model="query"
                            @keydown.escape="open = false"
                            @keydown.down.prevent="selectedIndex = Math.min(selectedIndex + 1, results.length - 1)"
                            @keydown.up.prevent="selectedIndex = Math.max(selectedIndex - 1, 0)"
                            @keydown.enter="selectHighlighted()"
                            placeholder="Search a place or Destination"
                            class="w-full bg-transparent border-none outline-none
                            text-[14px] text-gray-500
                            placeholder:text-gray-400 mt-1"
                        >

                        <!-- DROPDOWN -->
                        <div x-show="open" x-cloak
                            @click.outside="open = false"
                            class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50 max-h-72 overflow-y-auto"
                        >
                            <template x-for="(result, i) in results" :key="result.id">
                                <a :href="'/tour/' + result.slug"
                                   @click.prevent="selectResult(result)"
                                   class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition cursor-pointer border-b border-gray-100 last:border-0"
                                   :class="{ 'bg-gray-50': i === selectedIndex }"
                                >
                                    <img :src="result.image || 'https://images.unsplash.com/photo-1541417904950-b855846fe074?q=80&w=80&auto=format&fit=crop'"
                                         class="w-10 h-10 rounded-lg object-cover shrink-0">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 truncate" x-text="result.title"></p>
                                        <p class="text-xs text-gray-500 truncate" x-text="result.location || ''"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- DIVIDER -->
                <div class="h-px bg-gray-200 my-6"></div>

                <!-- DATE -->
                <div class="flex gap-4 items-start">

                    <div class="pt-1 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                        </svg>
                    </div>

                    <div class="w-full text-left">
                        <label class="block text-[14px] font-semibold text-gray-800">
                            When?
                        </label>

                        <input
                            type="date"
                            class="w-full bg-transparent border-none outline-none
                            text-[14px] text-gray-500 mt-1"
                        >
                    </div>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="mt-8 w-full h-[50px]
                    rounded-full
                    bg-[#c53a2f]
                    hover:bg-[#b63429]
                    transition
                    flex items-center justify-center gap-3"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-6 h-6 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    <span class="text-white text-[17px] font-semibold">
                        Search
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>

{{-- ALPINE --}}
<script>
    function heroSlider() {
        return {
            currentSlide: 0,

            slides: [
                'images/slides/01.jpg',
                'images/slides/02.jpg',
                'images/slides/03.jpg',
            ],

            startSlider() {
                setInterval(() => {
                    this.currentSlide =
                        (this.currentSlide + 1) % this.slides.length;
                }, 5000);
            }
        }
    }

    function heroSearch() {
        return {
            query: '',
            results: [],
            open: false,
            loading: false,
            selectedIndex: -1,
            debounceTimer: null,

            init() {
                this.$watch('query', () => {
                    clearTimeout(this.debounceTimer);
                    this.selectedIndex = -1;
                    if (this.query.length < 2) {
                        this.results = [];
                        this.open = false;
                        return;
                    }
                    this.debounceTimer = setTimeout(() => this.fetchResults(), 300);
                });
            },

            async fetchResults() {
                this.loading = true;
                try {
                    let res = await fetch(`/api/tours/search?q=${encodeURIComponent(this.query)}`);
                    this.results = await res.json();
                    this.open = this.results.length > 0;
                } catch (e) {
                    this.results = [];
                    this.open = false;
                } finally {
                    this.loading = false;
                }
            },

            selectResult(result) {
                this.open = false;
                window.location.href = '/tour/' + result.slug;
            },

            selectHighlighted() {
                if (this.selectedIndex > -1 && this.results[this.selectedIndex]) {
                    this.selectResult(this.results[this.selectedIndex]);
                } else {
                    this.submitSearch();
                }
            },

            submitSearch() {
                if (this.query.trim()) {
                    window.location.href = '/tours?search=' + encodeURIComponent(this.query);
                }
            }
        }
    }
</script>