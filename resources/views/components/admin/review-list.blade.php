<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Reviews</h2>
            <p class="text-sm text-gray-500 mt-1">Manage customer testimonials</p>
        </div>
        @if(!$editId)
            <button wire:click="resetForm" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Add Review</button>
        @endif
    </div>

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('message') }}</div>
    @endif

    @if($editId !== null || !$reviews->count())
        <form wire:submit="save" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $editId ? 'Edit Review' : 'New Review' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" wire:model="location" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <select wire:model="rating" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm">
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
                <textarea wire:model="content" rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm"></textarea>
                @error('content') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Save</button>
                @if($editId)
                    <button type="button" wire:click="resetForm" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
                @endif
            </div>
        </form>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Rating</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Content</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $review->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">{{ $review->content }}</td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleActive({{ $review->id }})" class="px-2 py-1 text-xs font-medium rounded-full {{ $review->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $review->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $review->id }})" class="text-sm text-primary-600 hover:text-primary-700 font-medium mr-3">Edit</button>
                            <button wire:click="delete({{ $review->id }})" wire:confirm="Delete this review?" class="text-sm text-red-600 hover:text-red-700 font-medium">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($reviews->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $reviews->links() }}</div>
        @endif
    </div>
</div>
