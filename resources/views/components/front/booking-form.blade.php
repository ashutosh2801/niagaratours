<section class="py-12 md:py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($bookingConfirmed ?? false)
            {{-- Success State --}}
            <div class="max-w-lg mx-auto text-center bg-white rounded-2xl shadow-lg border border-gray-200 p-8 md:p-12">
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 class="mt-4 text-2xl font-bold text-gray-900">Booking Confirmed!</h2>
                <p class="mt-2 text-gray-600">Thank you for your booking. Your order number is:</p>
                <p class="mt-2 text-lg font-bold text-primary-600">{{ $orderNumber ?? 'N/A' }}</p>
                <p class="mt-1 text-sm text-gray-500">We'll send a confirmation email with your tour details.</p>
                <a href="{{ route('tours') }}" wire:navigate class="mt-6 inline-block px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200">
                    Book Another Tour
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                {{-- Left: Booking Form --}}
                <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Book Your Tour</h2>

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span class="text-sm font-medium text-red-800">Please fix the following errors:</span>
                            </div>
                            <ul class="mt-2 ml-7 list-disc text-sm text-red-600">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form wire:submit="submit" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="customer_name" wire:model="customer_name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_name') border-red-400 @enderror">
                                @error('customer_name') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="customer_email" wire:model="customer_email" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_email') border-red-400 @enderror">
                                @error('customer_email') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="customer_phone" wire:model="customer_phone" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('customer_phone') border-red-400 @enderror">
                            @error('customer_phone') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="travel_date" class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                                <input type="date" id="travel_date" wire:model="travel_date" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('travel_date') border-red-400 @enderror">
                                @error('travel_date') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Number of Guests</label>
                                <input type="number" id="quantity" wire:model="quantity" min="1" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('quantity') border-red-400 @enderror">
                                @error('quantity') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests (optional)</label>
                            <textarea id="special_requests" wire:model="special_requests" rows="4" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('special_requests') border-red-400 @enderror"></textarea>
                            @error('special_requests') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200 text-lg">
                            Confirm Booking
                        </button>
                    </form>
                </div>

                {{-- Right: Order Summary --}}
                <div class="lg:col-span-2 lg:sticky lg:top-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Order Summary</h3>

                        <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                            @php $tourImg = $tour->featured_image ?? $tour->images[0] ?? null; @endphp
                            @if($tourImg)
                                <div class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-gray-200">
                                    <img src="{{ $tourImg }}" alt="{{ $tour->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-gray-900">{{ $tour->title }}</p>
                                <p class="text-sm text-gray-500">${{ number_format($tour->price, 2) }} per person</p>
                            </div>
                        </div>

                        @php
                            $qty = $quantity ?? 1;
                            $subtotal = $tour->price * $qty;
                            $serviceFee = $subtotal * 0.05;
                            $total = $subtotal + $serviceFee;
                        @endphp

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Price per person</span>
                                <span class="text-gray-900">${{ number_format($tour->price, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Quantity</span>
                                <span class="text-gray-900">{{ $qty }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="text-gray-900">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Service Fee (5%)</span>
                                <span class="text-gray-900">${{ number_format($serviceFee, 2) }}</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-primary-600">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
