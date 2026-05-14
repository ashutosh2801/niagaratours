@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 border-b border-gray-200">
        <x-breadcrumbs :items="[
            ['label' => 'Contact Us'],
        ]" />
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Contact Us</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Have a question or need help planning your trip? We are here to help.</p>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Contact Info Cards -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Address</h3>
                            <p class="text-sm text-gray-600 mt-1">1 Dundas Street West, Suite 2500<br>Toronto, ON, M5G 1Z3</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Phone</h3>
                            <a href="tel:+1-877-888-2339" class="text-sm text-primary-600 hover:text-primary-700 mt-1 block">+1-877-888-2339</a>
                            <p class="text-xs text-gray-500 mt-0.5">Toll-free, available 24/7</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Email</h3>
                            <a href="mailto:info@tourbeez.com" class="text-sm text-primary-600 hover:text-primary-700 mt-1 block">info@tourbeez.com</a>
                            <p class="text-xs text-gray-500 mt-0.5">We respond within 2 hours</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Business Hours</h3>
                            <p class="text-sm text-gray-600 mt-1">Monday - Friday: 8:00 AM - 8:00 PM</p>
                            <p class="text-sm text-gray-600">Saturday - Sunday: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-2 mt-8 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Send Us a Message</h2>
                        <livewire:front.contact-form />
                    </div>

                    <!-- Map -->
                    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="aspect-video bg-gray-200 flex items-center justify-center">
                            <div class="text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="text-sm">Google Map Placeholder</p>
                                <p class="text-xs">1 Dundas Street West, Toronto, ON</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
