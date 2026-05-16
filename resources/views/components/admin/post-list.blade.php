<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Blog Posts</h2>
            <p class="text-sm text-gray-500 mt-1">Manage blog posts and articles</p>
        </div>
        <button wire:click="resetForm" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Add Post</button>
    </div>

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('message') }}</div>
    @endif

    @if($editId !== null)
        <form wire:submit="save" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $editId ? 'Edit Post' : 'New Post' }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                    <input type="text" wire:model="title" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm">
                    @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" wire:model="author" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                <textarea wire:model="excerpt" rows="2" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea wire:model="content" rows="6" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm"></textarea>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <label class="flex items-center gap-2">
                    <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-primary-600 rounded">
                    <span class="text-sm text-gray-700">Active</span>
                </label>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Save</button>
                <button type="button" wire:click="resetForm" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</button>
            </div>
        </form>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Title</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Author</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $post->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $post->author ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $post->published_at?->format('M d, Y') ?? $post->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleActive({{ $post->id }})" class="px-2 py-1 text-xs font-medium rounded-full {{ $post->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $post->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $post->id }})" class="text-sm text-primary-600 hover:text-primary-700 font-medium mr-3">Edit</button>
                            <button wire:click="delete({{ $post->id }})" wire:confirm="Delete this post?" class="text-sm text-red-600 hover:text-red-700 font-medium">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($posts->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $posts->links() }}</div>
        @endif
    </div>
</div>
