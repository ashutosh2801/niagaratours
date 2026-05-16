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
        <div class="bg-primary-700 text-white text-xs sm:text-sm py-2.5 text-center">
            <div class="max-w-7xl mx-auto px-4">
                <span>Use discount code: <strong class="text-yellow-300">NIAGARA10</strong> — Save $10/person!</span>
            </div>
        </div>

        <!-- Navbar -->
        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Menu Button -->
                    <div class="flex items-center">
                        <button id="menuToggleBtn" class="p-2 -ml-2 text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors flex items-center gap-1.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            <span class="hidden sm:inline text-sm font-medium">Menu</span>
                        </button>

                        <!-- Slide-out Mobile Menu Overlay -->
                        <div id="mobileMenuOverlay" class="fixed inset-0 z-50 hidden">
                            <div id="menuBackdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm opacity-0 transition-opacity duration-300"></div>
                            <div id="menuPanel" class="absolute inset-y-0 left-0 w-80 max-w-[85vw] bg-white shadow-2xl overflow-y-auto -translate-x-full transition-transform duration-300">
                                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
                                    <span class="text-lg font-bold text-gray-900">Menu</span>
                                    <button id="menuCloseBtn" class="p-2 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                                <div class="px-5 py-4 space-y-1">
                                    @foreach($menus as $menu)
                                        @if($menu->children->isNotEmpty())
                                            <div>
                                                <button class="submenu-toggle flex items-center justify-between w-full px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                                    {{ $menu->label }}
                                                    <svg class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                </button>
                                                <div class="submenu-content ml-4 mt-1 space-y-1 hidden">
                                                    @foreach($menu->children as $child)
                                                        <a href="{{ $child->url }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">{{ $child->label }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <a href="{{ $menu->url }}" wire:navigate class="block px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->fullUrlIs($menu->url) ? 'text-primary-600 bg-primary-50' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-50' }} transition-colors">{{ $menu->label }}</a>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="px-5 py-4 border-t border-gray-200 mt-4">
                                    <a href="tel:{{ $phone }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">
                                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $phone }}
                                    </a>
                                    <a href="{{ route('tours') }}" wire:navigate class="flex items-center justify-center gap-2 mt-2 w-full px-4 py-3 bg-primary-600 text-white text-sm font-bold rounded-lg hover:bg-primary-500 transition-colors shadow-lg shadow-primary-600/20">
                                        Book Tour
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logo (centered) -->
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 shrink-0 lg:absolute lg:left-1/2 lg:-translate-x-1/2">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-10 lg:h-12">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif
                    </a>

                    <!-- Desktop Right Actions -->
                    <div class="hidden lg:flex items-center gap-4">
                        <a href="tel:{{ $phone }}" class="flex items-center gap-2 text-sm font-semibold text-gray-900 hover:text-primary-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $phone }}
                        </a>
                        <a href="{{ route('tours') }}" wire:navigate class="px-5 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-lg hover:bg-primary-500 transition-colors shadow-lg shadow-primary-600/20">
                            Book Tour
                        </a>
                    </div>

                    <!-- Mobile: Phone + Book Tour -->
                    <div class="flex items-center gap-3 lg:hidden">
                        <a href="tel:{{ $phone }}" class="p-2 text-gray-600 hover:text-primary-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </a>
                        <a href="{{ route('tours') }}" wire:navigate class="px-4 py-2 bg-primary-600 text-white text-xs font-bold rounded-lg hover:bg-primary-500 transition-colors">
                            Book Tour
                        </a>
                    </div>
                </div>
            </div>
        </header>

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

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300">
            <div class="max-w-7xl mx-auto px-4 py-16">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8 lg:gap-12">
                    <!-- Logo & About -->
                    <div class="col-span-2 md:col-span-3 lg:col-span-1 space-y-4">
                        <div class="flex items-center gap-2">
                            @if($logo)
                                <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-10">
                            @else
                                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                            @endif
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $settings['site_description'] ?? 'Experience the majesty of Niagara Falls with our expertly curated tours. Your adventure awaits.' }}</p>
                        <div class="flex flex-wrap gap-2 pt-2">
                            <a href="{{ $socialFacebook }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Facebook">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="{{ $socialInstagram }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Instagram">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                            </a>
                            <a href="{{ $socialTwitter }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Twitter / X">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="{{ $socialYoutube }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-colors" aria-label="YouTube">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.017 3.017 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Tours Column -->
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Tours</h3>
                        <ul class="space-y-2.5">
                            <li><a href="{{ route('tours') }}" wire:navigate class="text-sm text-gray-400 hover:text-white transition-colors">All Tours</a></li>
                            @php $footerCategories = \App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(5)->get(); @endphp
                            @foreach($footerCategories as $cat)
                                <li><a href="{{ route('tours', ['selectedCategories' => [$cat->id]]) }}" wire:navigate class="text-sm text-gray-400 hover:text-white transition-colors">{{ $cat->name }}</a></li>
                            @endforeach
                            <li><a href="{{ route('tours') }}" wire:navigate class="text-sm text-primary-400 hover:text-primary-300 transition-colors">View All →</a></li>
                        </ul>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                        <ul class="space-y-2.5">
                            @foreach($menus as $menu)
                                <li><a href="{{ $menu->url }}" wire:navigate class="text-sm text-gray-400 hover:text-white transition-colors">{{ $menu->label }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xs font-bold text-white uppercase tracking-wider mb-4">Contact</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="text-sm text-gray-400">{{ $contactAddress }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span class="text-sm text-gray-400">{{ $phone }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <a href="mailto:{{ $contactEmail }}" class="text-sm text-gray-400 hover:text-white transition-colors">{{ $contactEmail }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
                    <div class="flex items-center gap-6 text-sm text-gray-500">
                        <a href="{{ route('page.show', 'privacy-policy') }}" wire:navigate class="hover:text-gray-300 transition-colors">Privacy Policy</a>
                        <a href="{{ route('page.show', 'terms-conditions') }}" wire:navigate class="hover:text-gray-300 transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const toggleBtn = document.getElementById('menuToggleBtn');
        const closeBtn = document.getElementById('menuCloseBtn');
        const backdrop = document.getElementById('menuBackdrop');
        const panel = document.getElementById('menuPanel');

        function openMenu() {
            overlay.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                backdrop.classList.add('opacity-100');
                panel.classList.remove('-translate-x-full');
                panel.classList.add('translate-x-0');
            });
        }

        function closeMenu() {
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0');
            panel.classList.remove('translate-x-0');
            panel.classList.add('-translate-x-full');
            setTimeout(() => {
                overlay.classList.add('hidden');
            }, 300);
        }

        toggleBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (backdrop) backdrop.addEventListener('click', closeMenu);

        // Submenu toggles
        document.querySelectorAll('.submenu-toggle').forEach(btn => {
            btn.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('svg');
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
