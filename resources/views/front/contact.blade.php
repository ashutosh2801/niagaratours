@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')

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
                        Contact Us
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight w-full">
                    Contact Us
                </h1>
                <p class="mt-2 text-gray-600">Have a question or need help planning your trip? We are here to help.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-10">
        <div class="container-fluid mx-auto px-4">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">

                <!-- LEFT SIDE -->
                <div>

                    <p class="text-sm uppercase tracking-[3px] text-red-600 font-semibold mb-4">
                        Get To Know Us
                    </p>

                    <h2 class="text-lg md:text-2xl font-bold text-gray-700 leading-tight mb-4">
                        Lets talk our Expert Travel Guides
                    </h2>

                    <p class="text-gray-500 text-base leading-normal w-full">
                        Our expert travel guides bring every destination to life with local
                        knowledge passion and care They ensure safe authentic.
                    </p>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-12"></div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-y-10 md:gap-x-8">

                        <!-- Phone -->
                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm text-gray-500 mb-1">
                                    Call Us Directly
                                </p>

                                <a href="tel:+18778882339"
                                    class="text-base sm:text-lg font-semibold text-gray-700 hover:text-red-600 transition break-words">
                                    +(1) 877 888 2339
                                </a>
                            </div>

                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm text-gray-500 mb-1">
                                    Need Support?
                                </p>

                                <a href="mailto:info@niagaratours.com"
                                    class="text-base sm:text-lg font-semibold text-gray-700 hover:text-red-600 transition break-all">
                                    info@niagaratours.com
                                </a>
                            </div>

                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-4 md:col-span-2">

                            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm text-gray-500 mb-1">
                                    Address
                                </p>

                                <p class="text-base sm:text-lg font-semibold text-gray-700 leading-7">
                                    5853 Royal Manor Dr, Niagara Falls, ON L2G 1W4, Canada
                                </p>
                            </div>

                        </div>

                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-12"></div>

                    <!-- Social -->
                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-6">
                            Follow Us
                        </h4>

                        <div class="flex items-center gap-4">

                            <a href="#"
                                class="w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white transition">
                                <svg class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M22 12.073C22 6.477 17.523 2 12 2S2 6.477 2 12.073c0 5.018 3.657 9.174 8.438 9.927v-7.03H7.898v-2.897h2.54V9.845c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562v1.876h2.773l-.443 2.897h-2.33V22c4.78-.753 8.437-4.909 8.437-9.927z"/>
                                </svg>
                            </a>

                            <a href="#"
                                class="w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2H21l-6.56 7.497L22 22h-6.828l-5.345-6.99L3.72 22H1l7.017-8.017L2 2h7l4.83 6.35L18.244 2z" />
                                </svg>
                            </a>

                            <a href="#"
                                class="w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white transition">
                                <svg class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                                    <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                </svg>
                            </a>

                            <a href="#"
                                class="w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white transition">
                                <svg class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M12.04 2C6.58 2 4 5.66 4 9.67c0 2.36.89 4.46 2.8 5.24.31.13.58.01.67-.34.07-.24.21-.84.28-1.09.09-.34.06-.46-.19-.76-.54-.63-.88-1.45-.88-2.61 0-3.37 2.52-6.39 6.57-6.39 3.58 0 5.55 2.19 5.55 5.12 0 3.85-1.7 7.1-4.22 7.1-1.39 0-2.43-1.15-2.1-2.56.4-1.68 1.17-3.49 1.17-4.7 0-1.08-.58-1.98-1.77-1.98-1.4 0-2.53 1.45-2.53 3.39 0 1.24.42 2.07.42 2.07l-1.69 7.16c-.5 2.12-.07 4.72-.04 4.98.02.15.21.19.29.07.11-.15 1.53-1.89 2.01-3.63.14-.5.79-3.08.79-3.08.39.74 1.53 1.39 2.74 1.39 3.61 0 6.05-3.29 6.05-7.69C20 5.1 16.74 2 12.04 2z"/>
                                </svg>
                            </a>

                            <a href="#"
                                class="w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center hover:bg-orange-500 hover:text-white transition">
                               <svg class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path d="M23.5 6.2a3 3 0 00-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 00.5 6.2 31 31 0 000 12a31 31 0 00.5 5.8 3 3 0 002.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 002.1-2.1A31 31 0 0024 12a31 31 0 00-.5-5.8zM9.8 15.5v-7L16 12l-6.2 3.5z"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div>

                    <p class="text-sm uppercase tracking-[3px] text-red-600 font-semibold mb-4">
                        Send A Massage
                    </p>

                    <h2 class="text-lg md:text-2xl font-bold text-gray-700 leading-tight mb-4">
                        Looking For Any Help
                    </h2>

                    <form class="space-y-7">

                        <!-- Name -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-3">
                                Name <span class="text-orange-500">*</span>
                            </label>

                            <input
                                type="text"
                                placeholder="Your Name"
                                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-3">
                                Email <span class="text-orange-500">*</span>
                            </label>

                            <input
                                type="email"
                                placeholder="Your Email"
                                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
                            >
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-3">
                                Subject <span class="text-orange-500">*</span>
                            </label>

                            <input
                                type="text"
                                placeholder="Your Subject"
                                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
                            >
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-3">
                                Message <span class="text-orange-500">*</span>
                            </label>

                            <textarea
                                rows="3"
                                placeholder="Write your message"
                                class="w-full rounded-2xl border border-gray-200 bg-white px-6 py-5 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
                            ></textarea>
                        </div>

                        <!-- Button -->
                        <button
                            type="submit"
                            class="w-full h-14 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold text-base transition duration-300">
                            Submit Now →
                        </button>

                    </form>

                </div>

            </div>

            <!-- Map Section -->
            <div class="mt-10 rounded-xl overflow-hidden">

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2557.0879396657597!2d-79.1199759243271!3d43.08949837113445!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89d34484cdbfe4a9%3A0x456d77e555a07802!2s5853%20Royal%20Manor%20Dr%2C%20Niagara%20Falls%2C%20ON%20L2G%201W4%2C%20Canada!5e1!3m2!1sen!2slk!4v1779880516154!5m2!1sen!2slk" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>

        </div>
    </section>
@endsection