<div>
    @if(session('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-6">
        <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition-colors">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <p class="text-sm text-gray-500">Click to upload images (max 10MB each)</p>
                <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP</p>
            </div>
            <input type="file" wire:model="uploads" multiple accept="image/png,image/jpeg,image/webp" class="hidden">
        </label>
        @error('uploads.*') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
        <div wire:loading wire:target="uploads" class="mt-2 text-sm text-primary-600">Uploading...</div>
    </div>

    @if(!empty($selectedIds))
        <div class="mb-4 px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
            <span class="text-sm text-blue-700">{{ count($selectedIds) }} item(s) selected</span>
            <button wire:click="deleteSelected" wire:confirm="Delete {{ count($selectedIds) }} selected item(s)?" class="px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                Delete Selected
            </button>
        </div>
    @endif

    <div class="flex items-center mb-3">
        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
            <input type="checkbox" wire:click="toggleSelectAll" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
            <span>Select all</span>
        </label>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($media ?? [] as $item)
            <div class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition-shadow {{ in_array($item->id, $selectedIds) ? 'ring-2 ring-primary-500 border-primary-500' : '' }}">
                <div class="aspect-square bg-gray-100">
                    @if($item->isImage())
                        <img src="{{ $item->url }}" alt="{{ $item->alt ?? $item->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute top-2 left-2">
                        <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    </div>
                </div>
                <div class="p-2">
                    <p class="text-xs text-gray-700 truncate">{{ $item->name }}</p>
                    <p class="text-xs text-gray-400">{{ $item->size_for_humans }}</p>
                </div>
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2 pointer-events-none">
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $item->url }}').then(() => { this.innerText = 'Copied!'; setTimeout(() => this.innerText = '', 2000); })" class="px-3 py-1.5 bg-white text-gray-800 text-xs font-medium rounded hover:bg-gray-100 transition-colors pointer-events-auto">
                        Copy URL
                    </button>
                    <button wire:click="delete({{ $item->id }})" wire:confirm="Delete this file?" class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition-colors pointer-events-auto">
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-gray-500 font-medium">No media found</p>
                <p class="text-gray-400 text-sm mt-1">Upload images above to get started.</p>
            </div>
        @endforelse
    </div>

    @if(method_exists($media ?? [], 'links'))
        <div class="mt-6">
            {{ $media->links() }}
        </div>
    @endif
</div>
