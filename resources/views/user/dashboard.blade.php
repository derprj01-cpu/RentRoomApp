<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Simple Stats Cards -->
            <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
                <!-- Total Bookings -->
                <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bookings</div>
                    <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">{{ $totalBookings }}</div>
                </div>

                <!-- Active Bookings -->
                <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Bookings</div>
                    <div class="mt-1 text-2xl font-bold text-green-600 dark:text-green-400">{{ $activeBookings }}</div>
                </div>

                <!-- Today's Bookings -->
                <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Bookings</div>
                    <div class="mt-1 text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $todayBookings }}</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Upcoming Bookings -->
                <div class="lg:col-span-2">
                    <div class="overflow-hidden bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <div class="px-4 py-5 border-b sm:px-6 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Upcoming Bookings</h3>
                                <a href="{{ route('user.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                    View All
                                </a>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Room</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Date & Time</th>
                                        <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @forelse ($upcomingBookings as $booking)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $booking->room->room_name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->room->capacity }} seats</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} -
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                                    'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                                    'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                                    'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
                                                ];
                                            @endphp
                                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No upcoming bookings
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Sidebar -->
                <div class="space-y-4">
                    <!-- Create Booking Card -->
                    <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <h4 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Quick Actions</h4>
                        <a href="{{ route('user.bookings.create') }}"
                           class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            New Booking
                        </a>
                    </div>

                    <!-- Status Summary -->
                    <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <h4 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Booking Status</h4>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $upcomingBookings->where('status', 'pending')->count() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Approved</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $upcomingBookings->where('status', 'approved')->count() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">This Week</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $upcomingBookings->whereBetween('booking_date', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="p-4 bg-white border rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <h4 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Recent Activity</h4>
                        <div class="space-y-3">
                            @foreach($upcomingBookings->take(2) as $booking)
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 rounded-md bg-blue-100 dark:bg-blue-900"></div>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $booking->room->room_name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d') }} •
                                        {{ ucfirst($booking->status) }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
