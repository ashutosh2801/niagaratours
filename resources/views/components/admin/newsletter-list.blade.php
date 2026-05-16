<div>
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Newsletter Subscribers</h2>
        <p class="text-sm text-gray-500 mt-1">People who subscribed to your newsletter</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Subscribed</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($subscribers as $sub)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $sub->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $sub->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="delete({{ $sub->id }})" wire:confirm="Delete this subscriber?" class="text-sm text-red-600 hover:text-red-700 font-medium">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-12 text-center text-sm text-gray-500">No subscribers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($subscribers->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">{{ $subscribers->links() }}</div>
        @endif
    </div>
</div>
