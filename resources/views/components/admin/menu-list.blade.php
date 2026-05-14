<div>
    @if(session('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('message') }}</div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Navigation Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your website navigation menu items. Quickly add tours or categories below.</p>
        </div>
        @if(!$showForm)
            <button wire:click="create" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">
                + Add Custom Link
            </button>
        @endif
    </div>

    @if($showForm)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $editId ? 'Edit Menu Item' : 'New Menu Item' }}</h3>
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
                        <input type="text" wire:model="label" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('label') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Parent</label>
                        <select wire:model="parent_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option value="">— None (Top Level) —</option>
                            @foreach($parentOptions ?? [] as $parent)
                                @if($parent->id !== $editId)
                                    <option value="{{ $parent->id }}">{{ $parent->label }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                        <input type="text" wire:model="url" placeholder="/tours or https://..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Route Name</label>
                        <input type="text" wire:model="route" placeholder="tours" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <p class="text-xs text-gray-400 mt-1">If set, URL will be auto-generated from this route. URL field takes priority.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <input type="number" wire:model="sort_order" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                    <div class="flex items-center gap-3 pt-6">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <label for="is_active" class="text-sm font-medium text-gray-700">Active</label>
                    </div>
                </div>
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <button type="button" wire:click="cancel" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Save</button>
                </div>
            </form>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Current Menu Items</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($menus ?? [] as $menu)
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-medium text-gray-900">{{ $menu->label }}</span>
                                    <span class="text-xs text-gray-400">{{ $menu->url ?: ($menu->route ? 'route: '.$menu->route : '') }}</span>
                                    @if($menu->is_active)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactive</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <button wire:click="edit({{ $menu->id }})" class="text-xs text-primary-600 hover:text-primary-800">Edit</button>
                                    <button wire:click="delete({{ $menu->id }})" wire:confirm="Delete this menu item?" class="text-xs text-red-600 hover:text-red-800">Delete</button>
                                </div>
                            </div>
                            @if($menu->children->isNotEmpty())
                                <div class="ml-6 mt-3 space-y-2">
                                    @foreach($menu->children as $child)
                                        <div class="flex items-center justify-between py-1.5 px-3 bg-gray-50 rounded-lg">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm text-gray-700">↳ {{ $child->label }}</span>
                                                <span class="text-xs text-gray-400">{{ $child->url ?: ($child->route ? 'route: '.$child->route : '') }}</span>
                                                @if(!$child->is_active)
                                                    <span class="text-xs text-red-500">(inactive)</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button wire:click="edit({{ $child->id }})" class="text-xs text-primary-600 hover:text-primary-800">Edit</button>
                                                <button wire:click="delete({{ $child->id }})" wire:confirm="Delete this menu item?" class="text-xs text-red-600 hover:text-red-800">Delete</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-6 text-center text-sm text-gray-400">No menu items yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Tours</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($tours ?? [] as $tour)
                        <div class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-50">
                            <span class="text-sm text-gray-700 truncate">{{ $tour->title }}</span>
                            <button wire:click="addTour({{ $tour->id }})" class="shrink-0 text-xs font-medium text-primary-600 hover:text-primary-800">+ Add</button>
                        </div>
                    @empty
                        <div class="p-4 text-center text-sm text-gray-400">No tours found.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">Categories</h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    @forelse($categories ?? [] as $category)
                        <div class="flex items-center justify-between px-4 py-2.5 hover:bg-gray-50">
                            <span class="text-sm text-gray-700 truncate">{{ $category->name }}</span>
                            <button wire:click="addCategory({{ $category->id }})" class="shrink-0 text-xs font-medium text-primary-600 hover:text-primary-800">+ Add</button>
                        </div>
                    @empty
                        <div class="p-4 text-center text-sm text-gray-400">No categories found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
