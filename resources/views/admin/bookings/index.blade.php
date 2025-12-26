<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Bookings Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6">

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="sticky top-0 text-xs uppercase bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Room</th>
                                    <th class="px-6 py-4">Location</th>
                                    <th class="px-6 py-4">Capacity</th>
                                    <th class="px-6 py-4">Schedule</th>
                                    <th class="px-6 py-4">Type</th>
                                    <th class="px-6 py-4">Purpose</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr class="transition border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">

                                        <!-- User -->
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $booking->user->name }}
                                        </td>

                                        <!-- Room -->
                                        <td class="px-6 py-4">
                                            {{ $booking->room->room_name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $booking->room->location }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $booking->room->capacity }}
                                        </td>

                                        <!-- Time -->
                                        <td class="px-6 py-4 text-xs">
                                            <div>{{ $booking->start_time }} – {{ $booking->end_time }}</div>
                                            <div class="text-gray-400">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} mins
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ ucfirst($booking->room->type) }}
                                        </td>

                                        <td class="max-w-xs px-6 py-4 truncate">
                                            {{ $booking->purpose }}
                                        </td>

                                        <!-- Status -->
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

                                        <!-- Action -->
                                        <td class="px-6 py-4 space-x-2 text-right">
                                            <x-secondary-button>
                                                Detail
                                            </x-secondary-button>

                                            <x-danger-button>
                                                Cancel
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                            No bookings available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
