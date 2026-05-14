<section class="py-16 md:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Get In Touch</h2>
            <p class="mt-3 text-lg text-gray-600">Have a question or need help planning your trip? We'd love to hear from you.</p>
        </div>

        @if($submitted ?? false)
            <div class="max-w-lg mx-auto text-center bg-green-50 border border-green-200 rounded-2xl p-8 md:p-12">
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="mt-4 text-xl font-bold text-gray-900">Message Sent!</h3>
                <p class="mt-2 text-gray-600">Thank you for reaching out. We'll get back to you within 24 hours.</p>
                <button wire:click="$set('submitted', false)" class="mt-6 px-5 py-2.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200">
                    Send Another Message
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                {{-- Left: Form --}}
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-200">
                    <form wire:submit="submitContact" class="space-y-5">
                        <div>
                            <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                            <input type="text" id="contact_name" wire:model="name" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-400 @enderror">
                            @error('name') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email" id="contact_email" wire:model="email" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-400 @enderror">
                            @error('email') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="contact_message" class="block text-sm font-medium text-gray-700 mb-1">Your Message</label>
                            <textarea id="contact_message" wire:model="message" rows="5" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('message') border-red-400 @enderror"></textarea>
                            @error('message') <span class="mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-lg transition-colors duration-200">
                            Send Message
                        </button>
                    </form>
                </div>

                {{-- Right: Contact Info --}}
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Phone</h4>
                            <p class="mt-1 text-gray-600">+1 (555) 123-4567</p>
                            <p class="text-gray-500 text-sm">Mon-Sat, 9am-6pm EST</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <p class="mt-1 text-gray-600">info@niagaratours.com</p>
                            <p class="text-gray-500 text-sm">We reply within 24 hours</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Address</h4>
                            <p class="mt-1 text-gray-600">6650 Niagara Parkway</p>
                            <p class="text-gray-600">Niagara Falls, ON L2E 3E8</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Business Hours</h4>
                            <div class="mt-1 text-sm text-gray-600 space-y-1">
                                <p class="flex justify-between"><span>Monday - Friday</span><span class="font-medium">9:00 AM - 6:00 PM</span></p>
                                <p class="flex justify-between"><span>Saturday</span><span class="font-medium">10:00 AM - 4:00 PM</span></p>
                                <p class="flex justify-between"><span>Sunday</span><span class="font-medium text-red-500">Closed</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
