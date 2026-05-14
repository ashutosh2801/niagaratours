<div>
    @if($show)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" wire:click.self="close">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col m-4">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Media Library</h2>
                    <button type="button" wire:click="close" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="px-6 py-4 border-b border-gray-100">
                    <label class="flex items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-primary-500 hover:bg-primary-50 transition-colors">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Upload images
                        </div>
                        <input type="file" wire:model="uploads" multiple accept="image/*" class="hidden">
                    </label>
                    <div wire:loading wire:target="uploads" class="mt-2 text-sm text-primary-600">Uploading...</div>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                        @forelse($media ?? [] as $item)
                            <button type="button" wire:click="toggleSelect({{ $item->id }})" class="group relative aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 transition-colors {{ in_array($item->id, $selectedIds ?? []) ? 'border-primary-500 ring-2 ring-primary-300' : 'border-transparent hover:border-primary-300' }}">
                                @if($item->isImage())
                                    <img src="{{ $item->url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute top-1 right-1">
                                    <div class="w-5 h-5 rounded border-2 flex items-center justify-center {{ in_array($item->id, $selectedIds ?? []) ? 'bg-primary-500 border-primary-500' : 'bg-white border-gray-300' }}">
                                        @if(in_array($item->id, $selectedIds ?? []))
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-xs text-white truncate">{{ $item->name }}</p>
                                </div>
                            </button>
                        @empty
                            <div class="col-span-full py-12 text-center">
                                <p class="text-gray-500 text-sm">No media yet. Upload some images above.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between gap-3">
                    <span class="text-sm text-gray-500">{{ count($selectedIds ?? []) }} selected</span>
                    <div class="flex items-center gap-3">
                        <button type="button" wire:click="close" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</button>
                        <button type="button" wire:click="select" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 {{ empty($selectedIds) ? 'opacity-50 cursor-not-allowed' : '' }}" @if(empty($selectedIds)) disabled @endif>
                            Select ({{ count($selectedIds ?? []) }})
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
