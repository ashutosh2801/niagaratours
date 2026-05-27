@extends('layouts.app')

@section('title', 'About Us')

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
                        About Us
                    </span>

                </div>

                {{-- Title --}}
                <h1 class="text-4xl lg:text-5xl font-bold text-black leading-tight w-full">
                    About Niagara Tours
                </h1>
                <p class="mt-2 text-gray-600">Creating unforgettable Niagara Falls experiences since 2010. We are passionate about sharing the wonder of one of the world's greatest natural treasures.</p>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-16">
        <div class="container-fluid mx-auto px-4">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <!-- LEFT IMAGES -->
                <div class="relative">

                    <!-- Background Shape -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-10">
                        <img
                            src="https://cdn-icons-png.flaticon.com/512/854/854878.png"
                            class="w-72"
                            alt=""
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-6 relative z-10">

                        <!-- Image 1 -->
                        <div class="space-y-6">

                            <img
                                src="images/banners/about-banner-1.jpg"
                                alt="Travel"
                                class="rounded-[24px] w-full h-[150px] md:h-64 object-cover shadow-lg"
                            >

                            <img
                                src="images/banners/about-banner-2.jpg"
                                alt="Travel"
                                class="rounded-[24px] w-full h-[150px] md:h-80 object-cover shadow-lg"
                            >
                        </div>

                        <!-- Image 2 -->
                        <div class="pt-20">

                            <!-- Circle Badge -->
                            <div class="absolute top-0 left-[75%] md:left-[85%] -translate-x-1/2 z-20">
                                <div class="w-40 h-40 rounded-full bg-white shadow-xl border border-gray-100 flex items-center justify-center">

                                    <div class="text-center">

                                        <!-- Award Icon -->
                                        <div class="w-16 h-16 rounded-full border-2 border-gray-300 flex items-center justify-center mx-auto mb-3">

                                            <img
                                                src="images/icons/icon-4.png"
                                                alt="Travel"
                                                class="object-cover"
                                            >

                                        </div>

                                        <p class="text-xs uppercase tracking-[4px] text-gray-500 font-semibold">
                                            Since 2010
                                        </p>

                                        <h4 class="text-sm font-bold text-gray-900 mt-1">
                                            Niagara Tours
                                        </h4>

                                    </div>

                                </div>
                            </div>

                            <img
                                src="images/banners/about-banner-3.jpg"
                                alt="Travel"
                                class="rounded-[24px] w-full h-[250px] md:h-[520px] object-cover shadow-lg"
                            >
                        </div>

                    </div>

                </div>

                <!-- RIGHT CONTENT -->
                <div>

                    <p class="text-sm uppercase tracking-[3px] text-red-600 font-semibold mb-4">
                        Explore The World With Us
                    </p>

                    <h2 class="text-xl lg:text-4xl font-bold text-gray-900 leading-tight mb-7">
                        Experience the Beauty of<br> Niagara With Experts
                    </h2>

                    <p class="text-gray-600 text-base leading-normal mb-10">
                        Founded in 2010, Niagara Tours was born out of a deep love for the natural wonder that is Niagara Falls. What started as a small family-run operation has grown into one of the region's most trusted tour providers.<br><br>

                        Over the years, we have welcomed hundreds of thousands of guests from around the world, offering them an authentic and unforgettable experience of the falls and the surrounding region.<br><br>

                        Our team of experienced guides, customer service professionals, and operations staff work tirelessly to ensure every tour is safe, enjoyable, and memorable. We pride ourselves on our attention to detail, our commitment to sustainability, and our passion for sharing the beauty of Niagara with every guest.
                    </p>

                </div>

            </div>

        </div>
    </section>

    <!-- Stats -->
    <section class="py-16 bg-primary-600">
        <div class="max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Item -->
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white counter"
                        data-target="15000">
                        0
                    </h3>

                    <p class="text-primary-200 mt-2 text-sm font-medium">
                        Tours Completed
                    </p>
                </div>

                <!-- Item -->
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white counter"
                        data-target="50000">
                        0
                    </h3>

                    <p class="text-primary-200 mt-2 text-sm font-medium">
                        Happy Customers
                    </p>
                </div>

                <!-- Item -->
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white counter"
                        data-target="15">
                        0
                    </h3>

                    <p class="text-primary-200 mt-2 text-sm font-medium">
                        Years in Business
                    </p>
                </div>

                <!-- Item -->
                <div class="text-center">
                    <h3 class="text-4xl font-bold text-white counter"
                        data-target="12">
                        0
                    </h3>

                    <p class="text-primary-200 mt-2 text-sm font-medium">
                        Industry Awards
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- Values -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Our Values</h2>
                <p class="mt-3 text-lg text-gray-600">What drives us every day</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Safety First</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Your safety is our top priority. All our tours meet the highest safety standards and are led by certified guides.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Exceptional Service</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Every guest deserves a five-star experience. We go above and beyond to exceed your expectations.</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Sustainable Tourism</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">We are committed to protecting Niagara's natural beauty for generations to come through eco-friendly practices.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <!-- <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Meet Our Team</h2>
                <p class="mt-3 text-lg text-gray-600">The passionate people behind your Niagara experience</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-primary-100 mx-auto mb-4 flex items-center justify-center overflow-hidden">
                        <span class="text-3xl font-bold text-primary-600">JD</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">John Doe</h3>
                    <p class="text-sm text-primary-600 font-medium">Founder & CEO</p>
                </div>
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-primary-100 mx-auto mb-4 flex items-center justify-center overflow-hidden">
                        <span class="text-3xl font-bold text-primary-600">JS</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Jane Smith</h3>
                    <p class="text-sm text-primary-600 font-medium">Head of Operations</p>
                </div>
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-primary-100 mx-auto mb-4 flex items-center justify-center overflow-hidden">
                        <span class="text-3xl font-bold text-primary-600">MJ</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Mike Johnson</h3>
                    <p class="text-sm text-primary-600 font-medium">Lead Tour Guide</p>
                </div>
                <div class="text-center">
                    <div class="w-32 h-32 rounded-full bg-primary-100 mx-auto mb-4 flex items-center justify-center overflow-hidden">
                        <span class="text-3xl font-bold text-primary-600">SW</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Sarah Wilson</h3>
                    <p class="text-sm text-primary-600 font-medium">Customer Experience</p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Call to Action -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Experience Niagara Falls?</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">Join thousands of satisfied travelers and book your adventure today.</p>
            <a href="{{ route('tours') }}" wire:navigate class="inline-flex items-center gap-2 px-8 py-3.5 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors shadow-lg">
                Browse Our Tours
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </section>

<!-- Counter Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const counters = document.querySelectorAll('.counter');

        const animateCounter = (counter) => {

            const target = +counter.getAttribute('data-target');
            let count = 0;

            const increment = target / 100;

            const updateCounter = () => {

                count += increment;

                if (count < target) {

                    counter.innerText = Math.ceil(count).toLocaleString();

                    requestAnimationFrame(updateCounter);

                } else {

                    counter.innerText = target.toLocaleString() + '+';
                }
            };

            updateCounter();
        };

        // Intersection Observer
        const observer = new IntersectionObserver((entries) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    animateCounter(entry.target);

                    observer.unobserve(entry.target);
                }
            });

        }, {
            threshold: 0.5
        });

        counters.forEach(counter => {
            observer.observe(counter);
        });

    });
</script>
@endsection
