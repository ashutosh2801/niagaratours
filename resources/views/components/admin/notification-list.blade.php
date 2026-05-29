<div>
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Notifications</h2>
            <p class="text-sm text-gray-500 mt-1">Manage system notifications and contact form submissions</p>
        </div>
        <div class="flex items-center gap-3">
            <select wire:model.live="filter"
                    class="px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option value="all">All Notifications</option>
                <option value="unread">Unread</option>
                <option value="read">Read</option>
            </select>
            <button wire:click="markAllAsRead" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700">Mark All as Read</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Type</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Message</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($notifications ?? [] as $notification)
                    <tr class="hover:bg-gray-50 {{ !$notification->is_read ? 'bg-primary-50/50' : '' }}">
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $notification->type === 'order' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $notification->type === 'payment' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $notification->type === 'user' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $notification->type === 'contact' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $notification->type === 'system' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ !in_array($notification->type, ['order', 'payment', 'user', 'contact', 'system']) ? 'bg-primary-100 text-primary-800' : '' }}
                            ">{{ ucfirst($notification->type ?? 'system') }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">{{ $notification->message }}</td>
                        <td class="px-4 py-3">
                            @if($notification->is_read)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-500">Read</span>
                            @else
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-primary-100 text-primary-700">Unread</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $notification->created_at->format('M d, Y g:i A') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center justify-end gap-1">
                                @if(!$notification->is_read)
                                    <button wire:click="markAsRead({{ $notification->id }})"
                                            class="p-2 text-emerald-600 bg-emerald-50 hover:text-emerald-700 hover:bg-emerald-100 rounded-lg transition-colors"
                                            title="Mark as read" aria-label="Mark as read">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </button>
                                @endif
                                <button wire:click="viewNotification({{ $notification->id }})"
                                        class="p-2 text-sky-600 bg-sky-50 hover:text-sky-700 hover:bg-sky-100 rounded-lg transition-colors"
                                        title="View details" aria-label="View details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                                <button wire:click="delete({{ $notification->id }})" wire:confirm="Delete this notification?"
                                        class="p-2 text-red-600 bg-red-50 hover:text-red-700 hover:bg-red-100 rounded-lg transition-colors"
                                        title="Delete" aria-label="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-sm text-gray-500">No notifications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if(method_exists($notifications ?? [], 'links'))
            <div class="px-4 py-3 border-t border-gray-100">{{ $notifications->links() }}</div>
        @endif
    </div>

    @if($selectedNotification)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" wire:click="closeNotificationView">
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-gray-200" wire:click.stop>
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Notification Details</h3>
                    <button wire:click="closeNotificationView"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                            title="Close" aria-label="Close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4 text-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500">ID</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Type</p>
                            <p class="text-gray-900 font-medium">{{ ucfirst($selectedNotification->type ?? 'system') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Status</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->is_read ? 'Read' : 'Unread' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Created At</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->created_at?->format('M d, Y g:i A') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Read At</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->read_at?->format('M d, Y g:i A') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Name</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->name ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Email</p>
                            <p class="text-gray-900 font-medium break-all">{{ $selectedNotification->email ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Subject</p>
                            <p class="text-gray-900 font-medium">{{ $selectedNotification->subject ?: '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-gray-500 mb-1">Message</p>
                        <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-gray-700 whitespace-pre-line">{{ $selectedNotification->message ?: '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
