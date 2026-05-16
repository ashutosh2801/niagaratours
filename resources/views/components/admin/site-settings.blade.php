<div>
    @if($successMessage)
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ $successMessage }}</div>
    @endif

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Site Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Manage your website name, branding, SEO info, and contact details.</p>
    </div>

    <form wire:submit="save" class="space-y-8">
        {{-- Branding --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Branding</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Name *</label>
                    <input type="text" wire:model="site_name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('site_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" wire:model="site_tagline" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                    <textarea wire:model="site_description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    <div class="flex items-center gap-3">
                        <button type="button" x-data @click="$wire.openMediaPickerFor('logo').then(() => $dispatch('openMediaPicker'))" class="px-4 py-2 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100">
                            Choose from Media Library
                        </button>
                        @if($logo)
                            <button type="button" wire:click="$set('logo', '')" class="text-xs text-red-600 hover:text-red-700">Remove</button>
                        @endif
                    </div>
                    @if($logo)
                        <img src="{{ $logo }}" class="mt-2 h-12 object-contain border border-gray-200 rounded-lg">
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
                    <div class="flex items-center gap-3">
                        <button type="button" x-data @click="$wire.openMediaPickerFor('favicon').then(() => $dispatch('openMediaPicker'))" class="px-4 py-2 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100">
                            Choose from Media Library
                        </button>
                        @if($favicon)
                            <button type="button" wire:click="$set('favicon', '')" class="text-xs text-red-600 hover:text-red-700">Remove</button>
                        @endif
                    </div>
                    @if($favicon)
                        <img src="{{ $favicon }}" class="mt-2 h-8 w-8 object-contain border border-gray-200 rounded">
                    @endif
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" wire:model="meta_title" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea wire:model="meta_description" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500"></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                    <input type="text" wire:model="meta_keywords" placeholder="tour, niagara, travel" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" wire:model="contact_email" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('contact_email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" wire:model="contact_phone" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" wire:model="contact_address" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        {{-- Social Media --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                    <input type="url" wire:model="social_facebook" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Twitter URL</label>
                    <input type="url" wire:model="social_twitter" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                    <input type="url" wire:model="social_instagram" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">YouTube URL</label>
                    <input type="url" wire:model="social_youtube" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        {{-- Storage --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
             x-data="{ disk: $wire.$entangle('storage_disk', true) }">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Storage</h3>
            <p class="text-sm text-gray-500 mb-4">Choose where uploaded media files are stored.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Storage Disk</label>
                    <select x-model="disk" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="public">Local (public/storage)</option>
                        <option value="s3">Amazon S3</option>
                    </select>
                </div>
            </div>
            <div>
                <template x-if="disk === 's3'">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="md:col-span-2">
                            <p class="text-xs text-amber-700 font-medium">S3 credentials can also be set via .env file (AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY, AWS_DEFAULT_REGION, AWS_BUCKET). Values entered here will override .env values.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AWS Access Key ID</label>
                            <input type="text" wire:model="aws_key" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AWS Secret Access Key</label>
                            <input type="password" wire:model="aws_secret" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AWS Region</label>
                            <input type="text" wire:model="aws_region" placeholder="us-east-1" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">AWS Bucket</label>
                            <input type="text" wire:model="aws_bucket" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Stripe --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Stripe Payment</h3>
            <p class="text-sm text-gray-500 mb-4">Enter your Stripe API keys. You can also set them via <code class="text-xs bg-gray-100 px-1 rounded">STRIPE_KEY</code> and <code class="text-xs bg-gray-100 px-1 rounded">STRIPE_SECRET</code> in your .env file. Values entered here will override .env values.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Publishable Key</label>
                    <input type="text" wire:model="stripe_key" placeholder="pk_live_..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                    <input type="password" wire:model="stripe_secret" placeholder="sk_live_..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700" wire:loading.attr="disabled">
                Save All Settings
            </button>
        </div>
    </form>

    <livewire:admin.media-picker />
</div>
