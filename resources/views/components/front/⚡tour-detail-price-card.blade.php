<div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
    <div class="mb-4">
        @if(isset($tour->original_price) && $tour->original_price > $tour->price)
            <span class="text-sm text-gray-400 line-through mr-1">${{ number_format($tour->original_price, 2) }}</span>
        @endif
        <div class="text-3xl font-bold text-primary-600">From ${{ number_format($tour->price, 2) }}</div>
        <span class="text-sm text-gray-500">per person</span>
    </div>

    @if(($tour->booking_type ?? 'internal') === 'external' && $tour->booking_url)
        <a href="{{ $tour->booking_url }}" target="_blank" rel="noopener noreferrer" class="block w-full text-center px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200 text-lg">
            Book Now
        </a>
    @else
        <a href="{{ route('booking', $tour->id) }}" wire:navigate class="block w-full text-center px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200 text-lg">
            Book Now
        </a>
    @endif

    <div class="mt-6 space-y-4 border-t border-gray-100 pt-6">
        @if(isset($tour->duration))
            <div class="flex items-center justify-between">
                <span class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Duration
                </span>
                <span class="text-sm font-medium text-gray-900">{{ $tour->duration }}</span>
            </div>
        @endif
        @if(isset($tour->group_size))
            <div class="flex items-center justify-between">
                <span class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Group Size
                </span>
                <span class="text-sm font-medium text-gray-900">{{ $tour->group_size }}</span>
            </div>
        @endif
        @if(isset($tour->location))
            <div class="flex items-center justify-between">
                <span class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Location
                </span>
                <span class="text-sm font-medium text-gray-900">{{ $tour->location }}</span>
            </div>
        @endif
        @if(isset($tour->availability))
            <div class="flex items-center justify-between">
                <span class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Availability
                </span>
                <span class="text-sm font-medium {{ $tour->availability === 'Available' ? 'text-green-600' : 'text-red-600' }}">{{ $tour->availability }}</span>
            </div>
        @endif
    </div>
</div>
