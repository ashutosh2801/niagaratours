<div>
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search destinations..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
        <a href="{{ route('admin.destinations.create') }}" wire:navigate class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add New Destination
        </a>
    </div>

    @if(session('message'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">{{ session('message') }}</div>
    @endif

    @if(!empty($selectedIds))
        <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
            <span class="text-sm text-blue-700">{{ count($selectedIds) }} destination(s) selected</span>
            <button wire:click="deleteSelected" wire:confirm="Delete {{ count($selectedIds) }} selected destination(s)?" class="px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                Delete Selected
            </button>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                        <th class="px-6 py-3 w-12">
                            <input type="checkbox" wire:click="toggleSelectAll" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th class="px-6 py-3 w-16">Image</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Slug</th>
                        <th class="px-6 py-3">Sort Order</th>
                        <th class="px-6 py-3">Tours</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($destinations ?? [] as $destination)
                        <tr class="hover:bg-gray-50 {{ in_array($destination->id, $selectedIds) ? 'bg-blue-50' : '' }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $destination->id }}" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            </td>
                            <td class="px-6 py-4">
                                @if($destination->image)
                                    <img src="{{ $destination->image }}" alt="{{ $destination->name }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.destinations.edit', $destination) }}" wire:navigate class="font-medium text-gray-900 hover:text-primary-600">{{ $destination->name }}</a>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $destination->slug }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $destination->sort_order ?? 0 }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $destination->tours->count() }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button wire:click="toggleActive({{ $destination->id }})" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border-0 cursor-pointer transition-colors
                                        {{ $destination->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        {{ $destination->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                    @if($destination->is_popular)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Popular</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.destinations.edit', $destination) }}" wire:navigate class="p-1.5 text-gray-400 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button type="button" wire:click="delete({{ $destination->id }})" wire:confirm="Delete this destination?" class="p-1.5 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <p class="text-sm">No destinations found.</p>
                                <a href="{{ route('admin.destinations.create') }}" wire:navigate class="mt-2 inline-flex items-center text-sm text-primary-600 hover:text-primary-700">Create your first destination</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($destinations->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
</div>
