<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Permissions</h1>
            <p class="mt-1 text-gray-500">Manage permission modules for the system.</p>
        </div>
        <a href="{{ route('admin.permissions.create') }}" wire:navigate class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Permission
        </a>
    </div>

    @if(session('message'))
        <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">{{ session('error') }}</div>
    @endif

    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search permissions..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
        </div>
    </div>

    @forelse($permissions as $group => $groupPermissions)
        <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">{{ $group }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                            <th class="px-6 py-3">Permission</th>
                            <th class="px-6 py-3">Slug</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($groupPermissions as $permission)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="font-medium text-gray-900">{{ $permission->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $permission->slug }}</code>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.permissions.edit', $permission) }}" wire:navigate class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Edit Permission">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @if(!in_array($permission->slug, ['dashboard', 'tours', 'categories', 'destinations', 'orders', 'payments', 'pages', 'notifications', 'reviews', 'posts', 'newsletter', 'media', 'sections', 'menus', 'users', 'settings', 'roles', 'activity-logs', 'permissions']))
                                            <button wire:click="delete({{ $permission->id }})" wire:confirm="Are you sure you want to delete this permission?" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete Permission">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <p class="text-gray-500 font-medium">No permissions found</p>
            </div>
        </div>
    @endforelse
</div>
