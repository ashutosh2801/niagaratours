<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-1 text-gray-500">Overview of your Niagara Tours business performance.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Total Tours --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-primary-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Tours</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalTours ?? 0 }}</p>
            </div>
        </div>

        {{-- Total Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue ?? 0, 2) }}</p>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-900">{{ $pendingOrders ?? 0 }}</p>
            </div>
        </div>

        {{-- Total Users --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-purple-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Users</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
            </div>
        </div>

        {{-- Unread Notifications --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex items-center gap-5">
            <div class="w-14 h-14 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Unread Notifications</p>
                <p class="text-3xl font-bold text-gray-900">{{ $unreadNotifications ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>
