@extends('layouts.app')

@section('title', 'Booking Confirmed')

@section('content')
    <section class="bg-gray-50 border-b border-gray-200">
        <x-breadcrumbs :items="[
            ['label' => 'Booking Confirmed'],
        ]" />
    </section>
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 md:p-12 text-center">
                <!-- Success Icon -->
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Confirmed!</h1>
                <p class="text-gray-600 mb-6">Your tour has been booked successfully. A confirmation email has been sent to your email address.</p>

                <!-- Order Number -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6 inline-block">
                    <p class="text-sm text-gray-500 mb-1">Order Number</p>
                    <p class="text-xl font-bold text-primary-600 font-mono">{{ $booking->order_number ?? 'NT-' . strtoupper(Str::random(8)) }}</p>
                </div>

                <!-- Booking Details -->
                <div class="text-left bg-gray-50 rounded-lg p-6 mb-8 space-y-3">
                    <h3 class="font-semibold text-gray-900 mb-3">Booking Summary</h3>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Tour</span>
                        <span class="text-gray-900 font-medium">{{ $booking->tour->title ?? 'Niagara Falls Tour' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Travel Date</span>
                        <span class="text-gray-900 font-medium">{{ $booking->travel_date ?? date('M d, Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Travelers</span>
                        <span class="text-gray-900 font-medium">{{ $booking->quantity ?? 1 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Total Paid</span>
                        <span class="text-lg font-bold text-primary-600">${{ number_format($booking->total ?? 0, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($booking->status ?? 'confirmed') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-3">
                    <a href="{{ route('my.bookings') }}" wire:navigate class="block w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        View My Bookings
                    </a>
                    <a href="{{ route('tours') }}" wire:navigate class="block w-full px-6 py-3 bg-white text-primary-600 font-semibold rounded-lg border border-primary-600 hover:bg-primary-50 transition-colors">
                        Browse More Tours
                    </a>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">Need help with your booking?</p>
                <div class="flex items-center justify-center gap-6 mt-3 text-sm">
                    <a href="tel:+1-877-888-2339" class="flex items-center gap-2 text-primary-600 hover:text-primary-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        +1-877-888-2339
                    </a>
                    <a href="mailto:info@tourbeez.com" class="flex items-center gap-2 text-primary-600 hover:text-primary-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        info@tourbeez.com
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
