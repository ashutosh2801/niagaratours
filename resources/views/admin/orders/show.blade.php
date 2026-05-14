    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="hover:text-primary-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('admin.orders') }}" wire:navigate class="hover:text-primary-600 transition-colors">Orders</a>
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-900 font-medium">Order #{{ $order->order_number ?? '' }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h2>
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            'completed' => 'bg-blue-100 text-blue-800',
                        ];
                        $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $class }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Order Date</span>
                        <p class="font-medium text-gray-900">{{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Total</span>
                        <p class="font-medium text-gray-900">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Order Items</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                <th class="px-6 py-3">Item</th>
                                <th class="px-6 py-3">Qty</th>
                                <th class="px-6 py-3">Price</th>
                                <th class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->items ?? [] as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900">{{ $item->tour_title }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 text-gray-700">${{ number_format($item->price, 2) }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Subtotal</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">Tax</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-900">${{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-6 py-3 text-right text-sm font-bold text-gray-900">Total</td>
                                <td class="px-6 py-3 text-sm font-bold text-gray-900">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if($order->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Notes</h2>
                <p class="text-sm text-gray-700">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h2>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Name</span>
                        <p class="font-medium text-gray-900">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Email</span>
                        <p class="font-medium text-gray-900">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Phone</span>
                        <p class="font-medium text-gray-900">{{ $order->customer_phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h2>
                @if($order->payment)
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Method</span>
                        <p class="font-medium text-gray-900">{{ $order->payment->payment_method ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Transaction ID</span>
                        <p class="font-medium text-gray-900">{{ $order->payment->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Status</span>
                        @php
                            $pStatusClasses = [
                                'pending' => 'text-yellow-600',
                                'paid' => 'text-green-600',
                                'failed' => 'text-red-600',
                                'refunded' => 'text-gray-600',
                            ];
                            $pClass = $pStatusClasses[$order->payment->status] ?? 'text-gray-600';
                        @endphp
                        <p class="font-medium {{ $pClass }}">{{ ucfirst($order->payment->status) }}</p>
                    </div>
                </div>
                @else
                    <p class="text-sm text-gray-500">No payment recorded yet.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                <form wire:submit.prevent="updateStatus" class="space-y-3">
                    <select wire:model="newStatus"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="w-full px-4 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
