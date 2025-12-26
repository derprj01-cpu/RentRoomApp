<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto space-y-8 max-w-7xl sm:px-6 lg:px-8">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">

                <!-- Total Bookings -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Total Bookings
                    </div>
                    <div class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $totalBookings }}
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Active Bookings
                    </div>
                    <div class="mt-2 text-3xl font-bold text-green-600">
                        {{ $activeBookings }}
                    </div>
                </div>

                <!-- Today Bookings -->
                <div class="p-6 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Today's Booking
                    </div>
                    <div class="mt-2 text-3xl font-bold text-blue-600">
                        {{ $todayBookings }}
                    </div>
                </div>

            </div>

            <!-- Upcoming Bookings -->
            <div class="bg-white shadow dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Upcoming Bookings
                        </h3>

                        <a href="{{ route('user.bookings.index') }}"
                           class="text-sm text-indigo-600 hover:underline">
                            View All
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3">Room</th>
                                    <th class="px-6 py-3">Schedule</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($upcomingBookings as $booking)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $booking->room->room_name }}
                                        </td>

                                        <td class="px-6 py-4 text-xs">
                                            {{ $booking->start_time }} – {{ $booking->end_time }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @class([
                                                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' => $booking->status === 'pending',
                                                    'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $booking->status === 'approved',
                                                    'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => $booking->status === 'rejected',
                                                ])">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                            No upcoming bookings.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Action -->
            <div class="flex justify-end">
                <a href="{{ route('user.bookings.create') }}">
                    <x-primary-button>
                        + Create Booking
                    </x-primary-button>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
