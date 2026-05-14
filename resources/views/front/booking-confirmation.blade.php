@php
    $orderNumber = session('order_number');
    $order = $orderNumber ? \App\Models\Order::where('order_number', $orderNumber)->first() : null;
    $success = session('booking_success', false);
@endphp

@extends('layouts.app')

@section('title', $success ? 'Booking Confirmed' : 'Booking')

@section('content')
    <section class="bg-gray-50 border-b border-gray-200">
        <x-breadcrumbs :items="[
            ['label' => $success ? 'Booking Confirmed' : 'Booking'],
        ]" />
    </section>
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto px-4">
            @if($success && $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 md:p-12 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Confirmed!</h1>
                    <p class="text-gray-600 mb-6">Your tour has been booked and paid successfully. A confirmation will be sent to your email.</p>

                    <div class="bg-gray-50 rounded-lg p-4 mb-6 inline-block">
                        <p class="text-sm text-gray-500 mb-1">Order Number</p>
                        <p class="text-xl font-bold text-primary-600 font-mono">{{ $order->order_number }}</p>
                    </div>

                    <div class="text-left bg-gray-50 rounded-lg p-6 mb-8 space-y-3">
                        <h3 class="font-semibold text-gray-900 mb-3">Booking Summary</h3>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Customer</span>
                            <span class="text-gray-900 font-medium">{{ $order->customer_name }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Email</span>
                            <span class="text-gray-900 font-medium">{{ $order->customer_email }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Travel Date</span>
                            <span class="text-gray-900 font-medium">{{ $order->travel_details['travel_date'] ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Total Paid</span>
                            <span class="text-lg font-bold text-primary-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Status</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <a href="{{ route('tours') }}" wire:navigate class="block w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                            Browse More Tours
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 md:p-12 text-center">
                    <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">No Booking Found</h1>
                    <p class="text-gray-600 mb-6">We couldn't find a confirmed booking. If you've just paid, please wait a moment and refresh.</p>
                    <a href="{{ route('tours') }}" wire:navigate class="inline-block px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                        Browse Tours
                    </a>
                </div>
            @endif

            <div class="text-center mt-8">
                <p class="text-sm text-gray-500">Need help with your booking?</p>
                <div class="flex items-center justify-center gap-6 mt-3 text-sm">
                    <a href="mailto:info@tourbeez.com" class="flex items-center gap-2 text-primary-600 hover:text-primary-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        info@tourbeez.com
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection