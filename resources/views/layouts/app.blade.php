<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $siteName = App\Models\Setting::get('site_name', 'Niagara Tours');
        $metaTitle = App\Models\Setting::get('meta_title', 'Niagara Tours - Book Your Niagara Falls Adventure');
        $metaDescription = App\Models\Setting::get('meta_description', 'Experience the best Niagara Falls tours with Niagara Tours. Book your adventure today!');
        $metaKeywords = App\Models\Setting::get('meta_keywords', '');
        $favicon = App\Models\Setting::get('favicon', '');
    @endphp
    <title>@yield('title', $siteName) - {{ $siteName }}</title>
    <meta name="description" content="@yield('meta_description', $metaDescription)">
    @if($metaKeywords)<meta name="keywords" content="{{ $metaKeywords }}">@endif
    @if($favicon)<link rel="icon" href="{{ $favicon }}" type="image/x-icon">@endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- Open Graph / Social Meta --}}
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@yield('og_title', $metaTitle)">
    <meta property="og:description" content="@yield('og_description', $metaDescription)">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:locale" content="en_US">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', $metaTitle)">
    <meta name="twitter:description" content="@yield('og_description', $metaDescription)">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

</head>
<body class="antialiased text-gray-800 bg-white">
    @php
        $settings = App\Models\Setting::all()->pluck('value', 'key')->toArray();
        $phone = $settings['contact_phone'] ?? '+1-877-888-2339';
        $tagline = $settings['site_tagline'] ?? 'Experience the Falls Like Never Before';
        $logo = $settings['logo'] ?? '';
        $siteName = $settings['site_name'] ?? 'Niagara Tours';
        $menus = App\Models\Menu::getActive();
        $contactEmail = $settings['contact_email'] ?? 'info@tourbeez.com';
        $contactAddress = $settings['contact_address'] ?? '123 Falls Avenue, Niagara Falls, ON, Canada';
        $socialFacebook = $settings['social_facebook'] ?? '#';
        $socialInstagram = $settings['social_instagram'] ?? '#';
        $socialTwitter = $settings['social_twitter'] ?? '#';
        $socialYoutube = $settings['social_youtube'] ?? '#';
    @endphp

    <div class="flex flex-col min-h-screen">
        <!-- Discount Banner -->
        <!-- <div class="bg-primary-700 text-white text-xs sm:text-sm py-2.5 text-center">
            <div class="max-w-7xl mx-auto px-4">
                <span>Use discount code: <strong class="text-yellow-300">NIAGARA10</strong> — Save $10/person!</span>
            </div>
        </div> -->

        <!-- HEADER -->
        <header id="mainHeader"
            class="fixed top-0 left-0 w-full z-50 bg-white transition-all duration-300">

            <div class="container-fluid mx-auto px-4">

                <!-- DESKTOP HEADER -->
                <div class="hidden lg:flex items-center justify-between h-[78px]">

                    <!-- LOGO -->
                    <a href="{{ route('home') }}"
                        wire:navigate
                        class="shrink-0">

                        @if($logo)
                            <img src="{{ $logo }}"
                                alt="{{ $siteName }}"
                                class="h-12 w-auto">
                        @else

                            <div class="text-2xl font-bold text-primary-600">
                                {{ $siteName }}
                            </div>

                        @endif

                    </a>

                    <!-- DESKTOP MENU -->
                    <nav class="flex items-center gap-[50px]">

                        @foreach($menus as $menu)

                            <!-- PARENT MENU -->
                            <a href="{{ $menu->url }}"
                                wire:navigate
                                class="group relative text-[15px] font-semibold transition-all duration-300
                                {{ request()->fullUrlIs($menu->url)
                                    ? 'text-primary-600'
                                    : 'text-gray-800 hover:text-primary-600' }}">

                                {{ $menu->label }}

                                <span
                                    class="absolute left-0 -bottom-2 h-[2px] bg-primary-600 rounded-full transition-all duration-300
                                    {{ request()->fullUrlIs($menu->url)
                                        ? 'w-full'
                                        : 'w-0 group-hover:w-full' }}">
                                </span>

                            </a>

                            <!-- CHILD MENUS INLINE -->
                            @foreach($menu->children as $child)

                                <a href="{{ $child->url }}"
                                    wire:navigate
                                    class="group relative text-[15px] font-semibold transition-all duration-300
                                    {{ request()->fullUrlIs($child->url)
                                        ? 'text-primary-600'
                                        : 'text-gray-800 hover:text-primary-600' }}">

                                    {{ $child->label }}

                                    <span
                                        class="absolute left-0 -bottom-2 h-[2px] bg-primary-600 rounded-full transition-all duration-300
                                        {{ request()->fullUrlIs($child->url)
                                            ? 'w-full'
                                            : 'w-0 group-hover:w-full' }}">
                                    </span>

                                </a>

                            @endforeach

                        @endforeach

                    </nav>

                    <!-- RIGHT -->
                    <div class="flex items-center gap-5">

                        <!-- BOOK BUTTON -->
                        <a href="{{ route('tours') }}"
                            wire:navigate
                            class="px-7 py-3 rounded-full bg-primary-600 text-white text-sm font-bold hover:scale-105 transition-all duration-300">

                            Book Now

                        </a>

                    </div>

                </div>

                <!-- MOBILE HEADER -->
                <div class="flex lg:hidden items-center justify-between h-[74px]">

                    <!-- LEFT : MENU BUTTON -->
                    <button id="mobileMenuBtn"
                        class="flex items-center justify-center w-11 h-11 rounded-full text-gray-800 hover:bg-gray-100 transition-all duration-300">

                        <svg class="w-7 h-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                    </button>

                    <!-- CENTER : LOGO -->
                    <a href="{{ route('home') }}"
                        wire:navigate
                        class="absolute left-1/2 -translate-x-1/2">

                        @if($logo)

                            <img src="{{ $logo }}"
                                alt="{{ $siteName }}"
                                class="h-11 w-auto">

                        @endif

                    </a>

                    <!-- RIGHT : BUTTON -->
                    <a href="{{ route('tours') }}"
                        wire:navigate
                        class="px-5 h-11 inline-flex items-center justify-center rounded-full bg-primary-600 text-white text-sm font-bold hover:scale-105 transition-all duration-300">

                        Book Now

                    </a>

                </div>

            </div>

            <!-- MOBILE MENU -->
            <div id="mobileMenu"
                class="fixed inset-0 z-50 bg-black/50 opacity-0 invisible transition-all duration-300 lg:hidden">

                <!-- PANEL -->
                <div id="mobilePanel"
                    class="absolute top-0 left-0 h-full w-[280px] bg-white shadow-2xl -translate-x-full transition-transform duration-300">

                    <!-- TOP -->
                    <div class="flex items-center justify-between px-5 h-[74px] border-b">

                        <h3 class="text-lg font-bold text-gray-900">
                            Menu
                        </h3>

                        <button id="closeMobileMenu"
                            class="w-10 h-10 rounded-full flex items-center justify-center hover:bg-gray-100 transition-all duration-300">

                            <svg class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>

                        </button>

                    </div>

                    <!-- MOBILE LINKS -->
                    <div class="p-5 flex flex-col space-y-1">

                        @foreach($menus as $menu)

                            <!-- PARENT -->
                            <a href="{{ $menu->url }}"
                                wire:navigate
                                class="px-4 py-3 rounded-xl text-[15px] font-semibold transition-all duration-300
                                {{ request()->fullUrlIs($menu->url)
                                    ? 'bg-primary-50 text-primary-600'
                                    : 'text-gray-800 hover:bg-gray-100 hover:text-primary-600' }}">

                                {{ $menu->label }}

                            </a>

                            <!-- CHILD LINKS -->
                            @foreach($menu->children as $child)

                                <a href="{{ $child->url }}"
                                    wire:navigate
                                    class="px-4 py-3 rounded-xl text-[15px] font-semibold transition-all duration-300
                                    {{ request()->fullUrlIs($child->url)
                                        ? 'bg-primary-50 text-primary-600'
                                        : 'text-gray-800 hover:bg-gray-100 hover:text-primary-600' }}">

                                    {{ $child->label }}

                                </a>

                            @endforeach

                        @endforeach

                    </div>

                </div>

            </div>

        </header>

        <!-- HEADER SPACING -->
        <div class="h-[78px]"></div>

        @hasSection('hero')
            @yield('hero')
        @endif

        <!-- Main Content -->
        <main class="flex-1">
            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </main>

        <!-- Trustpilot Placeholder -->
        <div class="bg-gray-50 border-y border-gray-200">
            <div class="max-w-7xl mx-auto px-4 py-6">
                <div class="flex items-center justify-center gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <span class="font-medium text-gray-700">Trustpilot</span>
                        <span class="text-gray-400">|</span>
                        <span>4.8 out of 5 based on 2,347 reviews</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== FOOTER ==================== --}}
        <footer class="bg-[#f7f7f7] overflow-hidden">

            <div class="container-fluid mx-auto px-4">

                {{-- Main Footer --}}
                <div class="py-10">

                    <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-5 gap-y-12 gap-x-10">

                        {{-- Logo & About --}}
                        <div class="col-span-2 xl:col-span-1">

                            {{-- Logo --}}
                            <a href="{{ route('home') }}" wire:navigate class="inline-block">

                                @if($logo)
                                    <img
                                        src="{{ $logo }}"
                                        alt="{{ $siteName }}"
                                        class="h-[70px] object-contain"
                                    >
                                @else
                                    <h2 class="text-3xl font-bold text-red-600">
                                        NIAGARA
                                    </h2>
                                @endif

                            </a>

                            {{-- Text --}}
                            <p class="mt-6 text-[14px] leading-[1.8] text-[#666] max-w-[320px]">

                                {{ $settings['site_description'] ?? 'Your one-stop travel solution, from planning to discovering, booking, and sharing memories.' }}

                            </p>

                            {{-- Social --}}
                            <div class="flex items-center gap-5 mt-8">

                                {{-- Facebook --}}
                                <a
                                    href="{{ $socialFacebook }}"
                                    target="_blank"
                                    class="text-[#999] hover:text-black transition duration-300"
                                >
                                    <svg class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M22 12.073C22 6.477 17.523 2 12 2S2 6.477 2 12.073c0 5.018 3.657 9.174 8.438 9.927v-7.03H7.898v-2.897h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562v1.876h2.773l-.443 2.897h-2.33V22c4.78-.753 8.437-4.909 8.437-9.927z"/>
                                    </svg>
                                </a>

                                {{-- X --}}
                                <a
                                    href="{{ $socialTwitter }}"
                                    target="_blank"
                                    class="text-[#999] hover:text-black transition duration-300"
                                >
                                    <svg class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>

                                {{-- Instagram --}}
                                <a
                                    href="{{ $socialInstagram }}"
                                    target="_blank"
                                    class="text-[#999] hover:text-black transition duration-300"
                                >
                                    <svg class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                        <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                                        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                    </svg>
                                </a>

                                {{-- Pinterest --}}
                                <a
                                    href="#"
                                    class="text-[#999] hover:text-black transition duration-300"
                                >
                                    <svg class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M12.04 2C6.58 2 4 5.66 4 9.67c0 2.36.89 4.46 2.8 5.24.31.13.58.01.67-.34.07-.24.21-.84.28-1.09.09-.34.06-.46-.19-.76-.54-.63-.88-1.45-.88-2.61 0-3.37 2.52-6.39 6.57-6.39 3.58 0 5.55 2.19 5.55 5.12 0 3.85-1.7 7.1-4.22 7.1-1.39 0-2.43-1.15-2.1-2.56.4-1.68 1.17-3.49 1.17-4.7 0-1.08-.58-1.98-1.77-1.98-1.4 0-2.53 1.45-2.53 3.39 0 1.24.42 2.07.42 2.07l-1.69 7.16c-.5 2.12-.07 4.72-.04 4.98.02.15.21.19.29.07.11-.15 1.53-1.89 2.01-3.63.14-.5.79-3.08.79-3.08.39.74 1.53 1.39 2.74 1.39 3.61 0 6.05-3.29 6.05-7.69C20 5.1 16.74 2 12.04 2z"/>
                                    </svg>
                                </a>

                                {{-- YouTube --}}
                                <a
                                    href="{{ $socialYoutube }}"
                                    target="_blank"
                                    class="text-[#999] hover:text-black transition duration-300"
                                >
                                    <svg class="w-5 h-5"
                                        fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8zM9.8 15.5v-7L16 12l-6.2 3.5z"/>
                                    </svg>
                                </a>

                            </div>

                        </div>

                        {{-- Our Company --}}
                        <div>

                            <h3 class="text-[18px] font-semibold text-red-600 mb-7">
                                Our Company
                            </h3>

                            <ul class="space-y-3">

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        About Us
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Careers
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        News and Blog
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Support Policy
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Contact Us
                                    </a>
                                </li>

                            </ul>

                        </div>

                        {{-- Quick Links --}}
                        <div>

                            <h3 class="text-[18px] font-semibold text-red-600 mb-7">
                                Quick Links
                            </h3>

                            <ul class="space-y-3">

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        View Account
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Track Your Order
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Return/Exchange
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Promotions
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Customer Reviews
                                    </a>
                                </li>

                            </ul>

                        </div>

                        {{-- Top Destinations --}}
                        <div>

                            <h3 class="text-[18px] font-semibold text-red-600 mb-7">
                                Top Destinations
                            </h3>

                            <ul class="space-y-3">

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Las Vegas
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        New York City
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Washington DC
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Florence
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                    class="text-[14px] text-gray-500 hover:text-black transition duration-300">
                                        Barcelona
                                    </a>
                                </li>

                            </ul>

                        </div>

                        {{-- Contact --}}
                        <div>

                            <h3 class="text-[18px] font-semibold text-red-600 mb-7">
                                Contact Info
                            </h3>

                            <div class="space-y-5">

                                <p class="text-[14px] leading-[1.8] text-[#777] max-w-[240px]">
                                    <!-- {{ $contactAddress ?? '5853 Royal Manor Dr, Niagara Falls, ON L2G 1W4, Canada' }} -->
                                    5853 Royal Manor Dr, Niagara Falls, ON L2G 1W4, Canada
                                </p>

                                <a
                                    href="tel:{{ $phone }}"
                                    class="block text-[20px] font-bold text-black hover:text-black transition duration-300"
                                >
                                    {{ $phone ?? '+1 834 123 456 789' }}
                                </a>

                                <a
                                    href="mailto:{{ $contactEmail }}"
                                    class="block text-[14px] text-[#777] hover:text-black transition duration-300"
                                >
                                    {{ $contactEmail ?? 'info@niagaratours.com' }}
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Bottom --}}
                <div class="border-t border-[#dddddd] py-8">

                    <div class="flex flex-col md:flex-row items-center justify-center gap-6">

                        {{-- Copyright --}}
                        <p class="text-[14px] text-[#777] text-center md:text-left">

                            Copyright © {{ date('Y') }}
                            <span class="font-semibold text-black">
                                {{ strtolower($siteName ?? 'niagaratours.com') }}
                            </span>.
                            All rights reserved

                        </p>

                        {{-- Payment Icons --}}
                        <!-- <div class="flex items-center gap-3 flex-wrap justify-center">

                            {{-- AMEX --}}
                            <div class="h-[28px] px-3 rounded bg-[#1f72cd] text-white text-[11px] font-bold flex items-center justify-center">
                                AMEX
                            </div>

                            {{-- Bitcoin --}}
                            <div class="h-[28px] px-3 rounded bg-[#f7931a] text-white text-[11px] font-bold flex items-center justify-center">
                                ₿
                            </div>

                            {{-- Apple Pay --}}
                            <div class="h-[28px] px-3 rounded bg-black text-white text-[11px] font-bold flex items-center justify-center">
                                 Pay
                            </div>

                            {{-- Discover --}}
                            <div class="h-[28px] px-3 rounded bg-white border border-[#ddd] text-[#ff6000] text-[11px] font-bold flex items-center justify-center">
                                DISCOVER
                            </div>

                            {{-- Diners --}}
                            <div class="h-[28px] px-3 rounded bg-[#0079be] text-white text-[11px] font-bold flex items-center justify-center">
                                D
                            </div>

                            {{-- Visa --}}
                            <div class="h-[28px] px-3 rounded bg-[#1a1f71] text-white text-[11px] font-bold flex items-center justify-center">
                                VISA
                            </div>

                            {{-- Master --}}
                            <div class="h-[28px] px-3 rounded bg-[#eb001b] text-white text-[11px] font-bold flex items-center justify-center">
                                MC
                            </div>

                        </div> -->

                    </div>

                </div>

            </div>

        </footer>
    </div>

    <!-- SCRIPT -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const mobileMenu = document.getElementById('mobileMenu');
        const mobilePanel = document.getElementById('mobilePanel');

        const openBtn = document.getElementById('mobileMenuBtn');
        const closeBtn = document.getElementById('closeMobileMenu');

        // OPEN MENU
        openBtn.addEventListener('click', () => {

            mobileMenu.classList.remove('opacity-0', 'invisible');

            setTimeout(() => {
                mobilePanel.classList.remove('-translate-x-full');
            }, 10);

            document.body.classList.add('overflow-hidden');
        });

        // CLOSE MENU
        function closeMenu() {

            mobilePanel.classList.add('-translate-x-full');

            setTimeout(() => {
                mobileMenu.classList.add('opacity-0', 'invisible');
            }, 300);

            document.body.classList.remove('overflow-hidden');
        }

        closeBtn.addEventListener('click', closeMenu);

        mobileMenu.addEventListener('click', (e) => {

            if (e.target === mobileMenu) {
                closeMenu();
            }

        });

        // HEADER SHADOW ON SCROLL
        const header = document.getElementById('mainHeader');

        window.addEventListener('scroll', () => {

            if (window.scrollY > 20) {

                header.classList.add('shadow-md');

            } else {

                header.classList.remove('shadow-md');
            }

        });

    });
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
