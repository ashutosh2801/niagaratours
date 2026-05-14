@extends('layouts.app')

@section('title', 'Book Your Tour')

@section('content')
    <!-- Page Header -->
    <section class="bg-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600 transition-colors">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('tours') }}" wire:navigate class="hover:text-primary-600 transition-colors">Tours</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('tours.show', $tour ?? '') }}" wire:navigate class="hover:text-primary-600 transition-colors">{{ $tour->title ?? 'Tour' }}</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-900 font-medium">Book Now</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Book Your Tour</h1>
            <p class="mt-2 text-gray-600">Complete your booking details below.</p>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="lg:grid lg:grid-cols-3 lg:gap-8">
                <!-- Left: Form -->
                <div class="lg:col-span-2">
                    <form wire:submit.prevent="submitBooking" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
                        <h2 class="text-xl font-semibold text-gray-900">Personal Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" id="first_name" wire:model="first_name" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" placeholder="John">
                                @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" id="last_name" wire:model="last_name" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" placeholder="Doe">
                                @error('last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" wire:model="email" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" placeholder="john@example.com">
                                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" id="phone" wire:model="phone" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" placeholder="+1 (555) 123-4567">
                                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <h2 class="text-xl font-semibold text-gray-900">Booking Details</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="travel_date" class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                                <input type="date" id="travel_date" wire:model="travel_date" min="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                                @error('travel_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Number of Travelers</label>
                                <select id="quantity" wire:model="quantity" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500">
                                    @for($i = 1; $i <= 20; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Traveler' : 'Travelers' }}</option>
                                    @endfor
                                </select>
                                @error('quantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                            <textarea id="special_requests" wire:model="special_requests" rows="4" class="w-full border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500" placeholder="Any special requirements, dietary restrictions, or accommodations we should know about?"></textarea>
                            @error('special_requests') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <hr class="border-gray-200">

                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="terms" wire:model="terms" class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <label for="terms" class="text-sm text-gray-600">
                                I agree to the <a href="#" class="text-primary-600 hover:text-primary-700 underline">Terms & Conditions</a> and <a href="#" class="text-primary-600 hover:text-primary-700 underline">Cancellation Policy</a>.
                            </label>
                        </div>
                        @error('terms') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                        <button type="submit" class="w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors">
                            Confirm Booking
                        </button>
                    </form>
                </div>

                <!-- Right: Order Summary -->
                <aside class="lg:col-span-1 mt-8 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>

                        <div class="flex items-center gap-4 mb-4">
                            <img src="{{ $tour->featured_image ?? $tour->images[0] ?? 'https://images.unsplash.com/photo-1564507004663-b6dfb3c824d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" alt="{{ $tour->title }}" class="w-20 h-20 object-cover rounded-lg">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $tour->title ?? 'Tour Name' }}</h4>
                                <p class="text-xs text-gray-500 mt-1">{{ $tour->duration ?? '2 hours' }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Price per person</span>
                                <span class="text-gray-900 font-medium">${{ number_format($tour->sale_price ?? $tour->price ?? 0, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Quantity</span>
                                <span class="text-gray-900 font-medium">{{ $quantity ?? 1 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Travel Date</span>
                                <span class="text-gray-900 font-medium">{{ $travel_date ?? date('M d, Y') }}</span>
                            </div>
                        </div>

                        <hr class="border-gray-200 my-4">

                        <div class="space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">${{ number_format(($tour->sale_price ?? $tour->price ?? 0) * ($quantity ?? 1), 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Tax (13% HST)</span>
                                <span class="text-gray-900">${{ number_format(($tour->sale_price ?? $tour->price ?? 0) * ($quantity ?? 1) * 0.13, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                                <span class="text-base font-semibold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-primary-600">${{ number_format(($tour->sale_price ?? $tour->price ?? 0) * ($quantity ?? 1) * 1.13, 2) }}</span>
                            </div>
                        </div>

                        <hr class="border-gray-200 my-4">

                        <!-- Trust Badges -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Secure checkout with SSL encryption</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <span>Your payment info is secure</span>
                            </div>
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <span>Pay with Visa, Mastercard, Amex</span>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-center gap-2">
                            <div class="h-8 w-12 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-500">VISA</div>
                            <div class="h-8 w-12 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-500">MC</div>
                            <div class="h-8 w-12 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-500">AMEX</div>
                            <div class="h-8 w-12 bg-gray-100 rounded flex items-center justify-center text-xs font-bold text-gray-500">PP</div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
