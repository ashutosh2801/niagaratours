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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans antialiased text-gray-800 bg-white">
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

    <div x-data="{ mobileMenuOpen: false, activeDropdown: null }" class="flex flex-col min-h-screen">
        <!-- Top Bar -->
        <div class="bg-primary-900 text-white text-sm py-2">
            <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
                <span>{{ $tagline }}</span>
                <span class="hidden sm:block">{{ $phone }}</span>
            </div>
        </div>

        <!-- Navbar -->
        <header class="sticky top-0 z-40 bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 shrink-0">
                        @if($logo)
                            <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-12">
                        @else
                            <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif
                        <!-- <span class="text-xl font-bold text-gray-900">{{ $siteName }}</span> -->
                    </a>

                    <!-- Desktop Nav -->
                    <div class="hidden lg:flex items-center gap-1">
                        @foreach($menus as $menu)
                            @if($menu->children->isNotEmpty())
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-lg {{ request()->fullUrlIs($menu->url) ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                                        {{ $menu->label }}
                                        <svg class="w-3.5 h-3.5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="open" x-cloak @click.outside="open = false" class="absolute left-0 mt-1 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">{{ $child->label }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $menu->url }}" wire:navigate class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->fullUrlIs($menu->url) ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">{{ $menu->label }}</a>
                            @endif
                        @endforeach
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-gray-200 bg-white">
                <div class="px-4 py-3 space-y-1">
                    @foreach($menus as $menu)
                        @if($menu->children->isNotEmpty())
                            <div x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                                    {{ $menu->label }}
                                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-cloak class="ml-4 space-y-1">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-50">{{ $child->label }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" wire:navigate class="block px-3 py-2 text-sm font-medium rounded-lg {{ request()->fullUrlIs($menu->url) ? 'text-primary-600 bg-primary-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">{{ $menu->label }}</a>
                        @endif
                    @endforeach
                </div>
            </div>
        </header>

        @hasSection('hero')
            <section class="relative bg-gray-900">
                @yield('hero')
            </section>
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
            <div class="max-w-7xl mx-auto px-4 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Logo & About -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            @if($logo)
                                <img src="{{ $logo }}" alt="{{ $siteName }}" class="h-9">
                            @else
                                <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                            @endif
                            <!-- <span class="text-lg font-bold text-white">{{ $siteName }}</span> -->
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed">{{ $settings['site_description'] ?? 'Experience the majesty of Niagara Falls with our expertly curated tours. Your adventure awaits.' }}</p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            @foreach($menus as $menu)
                                <li><a href="{{ $menu->url }}" wire:navigate class="text-sm text-gray-400 hover:text-white transition-colors">{{ $menu->label }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Contact</h3>
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

                    <!-- Social Links -->
                    <div>
                        <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Follow Us</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ $socialFacebook }}" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="{{ $socialInstagram }}" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Instagram">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                            </a>
                            <a href="{{ $socialTwitter }}" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Twitter / X">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="{{ $socialYoutube }}" class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-red-600 hover:text-white transition-colors" aria-label="YouTube">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.017 3.017 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="mt-10 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500">
                        <a href="{{ route('page.show', 'privacy-policy') }}" wire:navigate class="hover:text-gray-300 transition-colors">Privacy Policy</a>
                        <a href="{{ route('page.show', 'terms-conditions') }}" wire:navigate class="hover:text-gray-300 transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
