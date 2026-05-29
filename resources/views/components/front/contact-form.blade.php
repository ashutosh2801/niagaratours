<div>
    @if($submitted)
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            Message sent successfully.
        </div>
    @endif

    <form wire:key="contact-form-{{ $formKey }}" wire:submit.prevent="submitContact" class="space-y-7 mt-4">
        <!-- Name -->
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Name <span class="text-orange-500">*</span>
            </label>

            <input
                type="text"
                wire:model="name"
                placeholder="Your Name"
                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
            >
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Email <span class="text-orange-500">*</span>
            </label>

            <input
                type="email"
                wire:model="email"
                placeholder="Your Email"
                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Subject -->
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Subject <span class="text-orange-500">*</span>
            </label>

            <input
                type="text"
                wire:model="subject"
                placeholder="Your Subject"
                class="w-full h-12 rounded-xl border border-gray-200 bg-white text-base px-6 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
            >
            @error('subject')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Message -->
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Message <span class="text-orange-500">*</span>
            </label>

            <textarea
                rows="3"
                wire:model="message"
                placeholder="Write your message"
                class="w-full rounded-2xl border border-gray-200 bg-white px-6 py-5 text-gray-700 placeholder-gray-400 focus:outline-none focus:border-red-600"
            ></textarea>
            @error('message')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Button -->
        <button
            type="submit"
            class="w-full h-14 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold text-base transition duration-300">
            Submit Now ->
        </button>
    </form>
</div>
