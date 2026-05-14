<div>
    @if(session('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('message') }}</div>
    @endif

    <div x-data="{ dragId: null, dropIndex: null }" class="space-y-4">
        @foreach($sections ?? [] as $index => $section)
            <div wire:key="section-{{ $section->id }}"
                 x-data
                 draggable="true"
                 @dragstart="dragId = {{ $section->id }}; $el.classList.add('opacity-50')"
                 @dragover.prevent="dropIndex = {{ $index }}; $el.classList.add('border-primary-400')"
                 @dragleave="$el.classList.remove('border-primary-400')"
                 @drop.prevent="if (dragId && dragId !== {{ $section->id }}) { let items = document.querySelectorAll('[data-section-id]'); let ids = Array.from(items).map(el => el.dataset.sectionId); let idx = ids.indexOf(String(dragId)); let toIdx = ids.indexOf(String({{ $section->id }})); if (idx > -1 && toIdx > -1) { ids.splice(idx, 1); ids.splice(toIdx, 0, String(dragId)); $wire.reorderSections(JSON.stringify(ids)); } } dragId = null; $el.classList.remove('border-primary-400')"
                 @dragend="dragId = null; $el.classList.remove('opacity-50'); document.querySelectorAll('[draggable]').forEach(e => e.classList.remove('border-primary-400'))"
                 data-section-id="{{ $section->id }}"
                 class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-border duration-150 cursor-move">
                <div class="px-6 py-4 flex items-center justify-between {{ $editId === $section->id ? 'border-b border-gray-200 bg-gray-50' : '' }}">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-gray-300 hover:text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $section->title }}</h3>
                                <p class="text-xs text-gray-500 font-mono">{{ $section->key }}</p>
                            </div>
                        </div>
                        @if($section->is_enabled)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Enabled</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Disabled</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($editId === $section->id)
                            <button wire:click="cancelEdit" class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        @else
                            <button wire:click="edit({{ $section->id }})" class="px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100">Edit Content</button>
                        @endif
                        <button wire:click="toggle({{ $section->id }})" class="px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ $section->is_enabled ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                            {{ $section->is_enabled ? 'Disable' : 'Enable' }}
                        </button>
                    </div>
                </div>

                @if($editId === $section->id)
                    <div class="p-6">
                        <form wire:submit="save" class="space-y-6">
                            @if($section->key === 'hero')
                                <div>
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Slides</h4>
                                        <button type="button" wire:click="addHeroSlide" class="text-xs font-medium text-primary-600 hover:text-primary-700">+ Add Slide</button>
                                    </div>
                                    <div class="space-y-6">
                                        @foreach($heroSlides ?? [] as $i => $slide)
                                            <div wire:key="hero-slide-{{ $i }}" class="border border-gray-200 rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-3">
                                                    <span class="text-sm font-medium text-gray-700">Slide {{ $i + 1 }}</span>
                                                    @if(count($heroSlides) > 1)
                                                        <button type="button" wire:click="removeHeroSlide({{ $i }})" class="text-xs text-red-600 hover:text-red-700">Remove</button>
                                                    @endif
                                                </div>
                                                <div class="space-y-3">
                                                    <div>
                                                        <div class="flex items-center justify-between mb-1">
                                                            <label class="block text-xs font-medium text-gray-600">Background Image</label>
                                                            <button type="button" x-data @click="$wire.openMediaPickerForHero({{ $i }}).then(() => $dispatch('openMediaPicker'))" class="text-xs text-primary-600 hover:text-primary-700">Choose from Media Library</button>
                                                        </div>
                                                        @if($slide['image'])
                                                            <div class="mb-2">
                                                                <img src="{{ $slide['image'] }}" class="h-32 w-full object-cover rounded-lg border border-gray-200">
                                                            </div>
                                                        @endif
                                                        <input type="url" wire:model="heroSlides.{{ $i }}.image" placeholder="Image URL" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1">Title</label>
                                                        <input type="text" wire:model="heroSlides.{{ $i }}.title" placeholder="Slide title" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                                                        <textarea wire:model="heroSlides.{{ $i }}.description" rows="2" placeholder="Slide description" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 mb-1">Link Type</label>
                                                            <select wire:model="heroSlides.{{ $i }}.link_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                                <option value="tour">Tour Detail</option>
                                                                <option value="tours">Tours Page</option>
                                                                <option value="custom">Custom URL</option>
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                                                {{ $slide['link_type'] === 'tour' ? 'Tour Slug' : ($slide['link_type'] === 'custom' ? 'Custom URL' : '') }}
                                                            </label>
                                                            @if($slide['link_type'] === 'tour')
                                                                <input type="text" wire:model="heroSlides.{{ $i }}.link_value" placeholder="tour-slug" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                            @elseif($slide['link_type'] === 'custom')
                                                                <input type="url" wire:model="heroSlides.{{ $i }}.link_value" placeholder="https://..." class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif($section->key === 'why_choose_us')
                                <div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                            <input type="text" wire:model="whyTitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                                            <input type="text" wire:model="whySubtitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Features</h4>
                                        <button type="button" wire:click="addWhyFeature" class="text-xs font-medium text-primary-600 hover:text-primary-700">+ Add Feature</button>
                                    </div>
                                    <div class="space-y-3">
                                        @foreach($whyFeatures ?? [] as $i => $feature)
                                            <div wire:key="why-feature-{{ $i }}" class="border border-gray-200 rounded-lg p-4">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-medium text-gray-600">Feature {{ $i + 1 }}</span>
                                                    @if(count($whyFeatures) > 1)
                                                        <button type="button" wire:click="removeWhyFeature({{ $i }})" class="text-xs text-red-600">Remove</button>
                                                    @endif
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <input type="text" wire:model="whyFeatures.{{ $i }}.title" placeholder="Feature title" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                                    <textarea wire:model="whyFeatures.{{ $i }}.description" rows="2" placeholder="Feature description" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                            @elseif($section->key === 'cta')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" wire:model="ctaTitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                        <textarea wire:model="ctaDescription" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                                        <input type="text" wire:model="ctaButtonText" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Button Link</label>
                                        <input type="text" wire:model="ctaButtonLink" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div class="md:col-span-2">
                                        <div class="flex items-center justify-between mb-1">
                                            <label class="block text-sm font-medium text-gray-700">Background Image</label>
                                            <button type="button" x-data @click="$wire.openMediaPickerForCta().then(() => $dispatch('openMediaPicker'))" class="text-xs text-primary-600 hover:text-primary-700">Choose from Media</button>
                                        </div>
                                        @if($ctaBgImage)
                                            <img src="{{ $ctaBgImage }}" class="h-24 w-full object-cover rounded-lg border border-gray-200 mb-2">
                                        @endif
                                        <input type="url" wire:model="ctaBgImage" placeholder="Background image URL" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>

                            @elseif($section->key === 'popular_destinations')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" wire:model="popTitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                                        <input type="text" wire:model="popSubtitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Tours to Display</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        @foreach($tours ?? [] as $tour)
                                            <label wire:key="dest-tour-{{ $tour->id }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ in_array($tour->id, $selectedTours ?? []) ? 'border-primary-500 bg-primary-50' : '' }}">
                                                <input type="checkbox" wire:model="selectedTours" value="{{ $tour->id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $tour->title }}</p>
                                                    <p class="text-xs text-gray-500">${{ number_format($tour->price, 2) }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @if(empty($tours))
                                        <p class="text-sm text-gray-400 italic">No active tours available.</p>
                                    @endif
                                </div>

                            @elseif($section->key === 'browse_categories')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" wire:model="browseTitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                                        <input type="text" wire:model="browseSubtitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>

                            @elseif($section->key === 'popular_tours')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                        <input type="text" wire:model="popToursTitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                                        <input type="text" wire:model="popToursSubtitle" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Tours to Display</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        @foreach($tours ?? [] as $tour)
                                            <label wire:key="ptour-{{ $tour->id }}" class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ in_array($tour->id, $selectedPopularTours ?? []) ? 'border-primary-500 bg-primary-50' : '' }}">
                                                <input type="checkbox" wire:model="selectedPopularTours" value="{{ $tour->id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $tour->title }}</p>
                                                    <p class="text-xs text-gray-500">${{ number_format($tour->price, 2) }}</p>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @if(empty($tours))
                                        <p class="text-sm text-gray-400 italic">No active tours available.</p>
                                    @endif
                                </div>
                            @endif

                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                                <button type="button" wire:click="cancelEdit" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700" wire:loading.attr="disabled">
                                    Save Settings
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <livewire:admin.media-picker />
</div>
