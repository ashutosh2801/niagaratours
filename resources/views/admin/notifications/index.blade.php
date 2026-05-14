    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex gap-3">
            <select wire:model.live="filter"
                    class="px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="">All Notifications</option>
                <option value="unread">Unread</option>
                <option value="read">Read</option>
            </select>
        </div>
        <button wire:click="markAllAsRead" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Mark All as Read
        </button>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($notifications ?? [] as $notification)
                        <tr class="hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-primary-50/50' }}">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $notification->type === 'order' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $notification->type === 'payment' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $notification->type === 'user' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $notification->type === 'system' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">
                                    {{ ucfirst($notification->type ?? 'system') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-900 {{ $notification->read_at ? '' : 'font-medium' }}">{{ $notification->message }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($notification->read_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Read</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700">Unread</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $notification->created_at->format('M d, Y g:i A') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if(!$notification->read_at)
                                        <button wire:click="markAsRead('{{ $notification->id }}')"
                                                class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Mark as read">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </button>
                                    @endif
                                    <button wire:click="delete('{{ $notification->id }}')" wire:confirm="Are you sure?"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                <p class="text-gray-500 font-medium">No notifications</p>
                                <p class="text-gray-400 text-sm mt-1">You're all caught up!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($notifications ?? [], 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
