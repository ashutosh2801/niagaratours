<div>
    @if($successMessage)
        <p class="text-green-400 text-sm">{{ $successMessage }}</p>
    @else
        <form wire:submit="subscribe" class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
            <input type="email" wire:model="email" placeholder="Email*" required class="flex-1 px-5 py-3 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-500 transition-colors text-sm whitespace-nowrap">
                Subscribe
            </button>
        </form>
        @if($errorMessage)
            <p class="text-red-400 text-sm mt-2">{{ $errorMessage }}</p>
        @endif
    @endif
</div>
