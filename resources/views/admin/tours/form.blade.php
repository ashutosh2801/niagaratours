    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="hover:text-primary-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.tours') }}" wire:navigate class="hover:text-primary-600 transition-colors">Tours</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium">{{ $tourId ? 'Edit: ' . ($title ?? 'Tour') : 'Create Tour' }}</span>
        </nav>
        <div class="max-w-4xl">
        <form x-data="{
            async submit() {
                const input = document.querySelector('[data-summernote-description]');
                if (input) await $wire.set('description', input.value);
                $wire.save();
            }
        }" x-on:submit.prevent="submit()" class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" id="title" wire:model.blur="title"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" id="slug" wire:model.blur="slug"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                        <textarea id="short_description" wire:model.blur="short_description" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        @error('short_description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <x-admin.summernote-editor ref="description" :value="$description ?? ''" label="Description" :error="$errors->first('description')" />
                    </div>
                </div>
            </div>

            <!-- Category & Meta -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Category & Meta</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="category_id" wire:model="category_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Select Category</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                        <input type="text" id="location" wire:model.blur="location"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('location') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="destination_id" class="block text-sm font-medium text-gray-700 mb-1">Destination</label>
                        <select id="destination_id" wire:model="destination_id"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">Select Destination</option>
                            @foreach($destinations ?? [] as $destination)
                                <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Duration & Capacity -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Duration & Capacity</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                        <input type="number" id="duration" wire:model.blur="duration" min="1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('duration') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="duration_type" class="block text-sm font-medium text-gray-700 mb-1">Duration Type</label>
                        <select id="duration_type" wire:model="duration_type"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="hours">Hours</option>
                            <option value="days">Days</option>
                            <option value="weeks">Weeks</option>
                        </select>
                        @error('duration_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="max_people" class="block text-sm font-medium text-gray-700 mb-1">Max People</label>
                        <input type="number" id="max_people" wire:model.blur="max_people" min="1"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('max_people') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h2>

                <div>
                    <div class="flex items-center gap-6 mb-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="pricingType" value="per_person" wire:model="pricingType"
                                   class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                            <span class="text-sm font-medium text-gray-700">By Person</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="pricingType" value="fixed" wire:model="pricingType"
                                   class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                            <span class="text-sm font-medium text-gray-700">By Fixed (Group Tour)</span>
                        </label>
                    </div>

                    @if($pricingType === 'per_person')
                        <div wire:key="per-person-pricing">
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-200">
                                            <th class="text-left py-2 pr-4 font-medium text-gray-700">Label</th>
                                            <th class="text-left py-2 pr-4 font-medium text-gray-700">Price ($)</th>
                                            <th class="text-left py-2 pr-4 font-medium text-gray-700">Sale Price ($)</th>
                                            <th class="text-left py-2 pr-4 font-medium text-gray-700">Min Qty</th>
                                            <th class="text-left py-2 font-medium text-gray-700"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pricing ?? [] as $index => $item)
                                            <tr wire:key="pricing-{{ $index }}" class="border-b border-gray-100">
                                                <td class="py-3 pr-4">
                                                    <input type="text" wire:model.blur="pricing.{{ $index }}.label" placeholder="Adult"
                                                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    <input type="hidden" wire:model="pricing.{{ $index }}.category">
                                                </td>
                                                <td class="py-3 pr-4">
                                                    <input type="number" wire:model.blur="pricing.{{ $index }}.price" step="0.01" min="0" placeholder="0.00"
                                                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                </td>
                                                <td class="py-3 pr-4">
                                                    <input type="number" wire:model.blur="pricing.{{ $index }}.sale_price" step="0.01" min="0" placeholder="0.00"
                                                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                </td>
                                                <td class="py-3 pr-4">
                                                    <input type="number" wire:model.blur="pricing.{{ $index }}.min_qty" min="0" placeholder="0"
                                                           class="w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                </td>
                                                <td class="py-3">
                                                    <button type="button" wire:click="removePricingRow({{ $index }})"
                                                            class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <button type="button" wire:click="addPricingRow"
                                    class="mt-3 text-sm font-medium text-primary-600 hover:text-primary-700">
                                + Add Category
                            </button>
                        </div>
                    @else
                        <div wire:key="fixed-pricing" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Group Price ($)</label>
                                <input type="number" wire:model.blur="pricing.0.price" step="0.01" min="0" placeholder="0.00"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sale Price ($)</label>
                                <input type="number" wire:model.blur="pricing.0.sale_price" step="0.01" min="0" placeholder="0.00"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                    @endif
                </div>

                @error('pricing.*.price') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                @error('pricing.*.label') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <!-- Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status</h2>
                <div class="flex items-center gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured"
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm font-medium text-gray-700">Featured</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_active"
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                </div>
            </div>

            <!-- Booking -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Booking</h2>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Booking Method</label>
                    <div x-data="{ type: '{{ $booking_type }}' }" class="space-y-3">
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="booking_type" x-model="type" value="internal" @change="$wire.set('booking_type', 'internal')"
                                       class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                <span class="text-sm font-medium text-gray-700">Self Checkout (Internal)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="booking_type" x-model="type" value="external" @change="$wire.set('booking_type', 'external')"
                                       class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                <span class="text-sm font-medium text-gray-700">External Link</span>
                            </label>
                        </div>
                        @error('booking_type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                        <div x-show="type === 'external'" x-cloak>
                            <label for="booking_url" class="block text-sm font-medium text-gray-700 mb-1">Booking URL</label>
                            <input type="url" id="booking_url" wire:model="booking_url" placeholder="https://example.com/book-now"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('booking_url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Upload -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Images</h2>
                    <button type="button" x-data @click="$dispatch('openMediaPicker')"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Media Library
                    </button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    @foreach($images ?? [] as $index => $image)
                        <div wire:key="image-{{ $index }}" class="relative group">
                            <img src="{{ $image }}"
                                 class="w-full h-24 object-cover rounded-lg border border-gray-200 {{ $featured_image === $image ? 'ring-2 ring-yellow-400' : '' }}">
                            @if($featured_image === $image)
                                <div class="absolute top-1 left-1 px-1.5 py-0.5 bg-yellow-400 text-yellow-900 text-xs font-bold rounded">FEATURED</div>
                            @endif
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 rounded-lg">
                                <button type="button" wire:click="setFeaturedImage({{ $index }})" title="Set as Featured"
                                        class="p-1.5 {{ $featured_image === $image ? 'bg-yellow-400 text-yellow-900' : 'bg-white text-gray-700' }} rounded-full hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </button>
                                <button type="button" wire:click="removeImage({{ $index }})" title="Remove"
                                        class="p-1.5 bg-red-500 text-white rounded-full hover:scale-110 transition-transform">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Highlights -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Highlights</h2>
                    <button type="button" wire:click="addHighlight"
                            class="text-sm font-medium text-primary-600 hover:text-primary-700">+ Add</button>
                </div>
                @foreach($highlights ?? [] as $index => $highlight)
                    <div wire:key="highlight-{{ $index }}" class="flex items-center gap-2 mb-2">
                        <input type="text" wire:model.blur="highlights.{{ $index }}" placeholder="Enter a highlight"
                               class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <button type="button" wire:click="removeHighlight({{ $index }})"
                                class="p-2 text-gray-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Inclusions & Exclusions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Inclusions</h2>
                        <button type="button" wire:click="addInclusion"
                                class="text-sm font-medium text-green-600 hover:text-green-700">+ Add</button>
                    </div>
                    @foreach($inclusions ?? [] as $index => $inclusion)
                        <div wire:key="inclusion-{{ $index }}" class="flex items-center gap-2 mb-2">
                            <input type="text" wire:model.blur="inclusions.{{ $index }}" placeholder="Include this..."
                                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <button type="button" wire:click="removeInclusion({{ $index }})"
                                    class="p-2 text-gray-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Exclusions</h2>
                        <button type="button" wire:click="addExclusion"
                                class="text-sm font-medium text-red-600 hover:text-red-700">+ Add</button>
                    </div>
                    @foreach($exclusions ?? [] as $index => $exclusion)
                        <div wire:key="exclusion-{{ $index }}" class="flex items-center gap-2 mb-2">
                            <input type="text" wire:model.blur="exclusions.{{ $index }}" placeholder="Exclude this..."
                                   class="flex-1 px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <button type="button" wire:click="removeExclusion({{ $index }})"
                                    class="p-2 text-gray-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Itinerary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Itinerary</h2>
                    <button type="button" wire:click="addItineraryItem"
                            class="text-sm font-medium text-primary-600 hover:text-primary-700">+ Add Day</button>
                </div>
                @foreach($itinerary ?? [] as $index => $item)
                    <div wire:key="itinerary-{{ $index }}" class="border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-700">Day {{ $index + 1 }}</span>
                            <button type="button" wire:click="removeItineraryItem({{ $index }})"
                                    class="text-sm text-red-600 hover:text-red-700">Remove</button>
                        </div>
                        <div class="space-y-3">
                            <input type="text" wire:model.blur="itinerary.{{ $index }}.title" placeholder="Day title"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <textarea wire:model.blur="itinerary.{{ $index }}.description" rows="3" placeholder="Day description"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- FAQs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">FAQs</h2>
                    <button type="button" wire:click="addFaq"
                            class="text-sm font-medium text-primary-600 hover:text-primary-700">+ Add FAQ</button>
                </div>
                @foreach($faqs ?? [] as $index => $faq)
                    <div wire:key="faq-{{ $index }}" class="border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-700">FAQ #{{ $index + 1 }}</span>
                            <button type="button" wire:click="removeFaq({{ $index }})"
                                    class="text-sm text-red-600 hover:text-red-700">Remove</button>
                        </div>
                        <div class="space-y-3">
                            <input type="text" wire:model.blur="faqs.{{ $index }}.question" placeholder="Question"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <textarea wire:model.blur="faqs.{{ $index }}.answer" rows="3" placeholder="Answer"
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO</h2>
                <div class="space-y-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" id="meta_title" wire:model.blur="meta_title"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('meta_title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea id="meta_description" wire:model.blur="meta_description" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                        @error('meta_description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.tours') }}" wire:navigate class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">{{ $tourId ? 'Update Tour' : 'Create Tour' }}</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>

        <livewire:admin.media-picker />
    </div>
</div>
