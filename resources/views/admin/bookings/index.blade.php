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
                                        <td class="px-6 py-4 text-right">
                                            <x-dropdown align="right" width="48">
                                                <x-slot name="trigger">
                                                    <button class="inline-flex items-center justify-center w-8 h-8 text-gray-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">

                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm4-6a2 2 0 114 0 2 2 0 01-4 0zm0 12a2 2 0 114 0 2 2 0 01-4 0z"/>
                                                    </svg>

                                                    </button>
                                                </x-slot>

                                                <x-slot name="content">
                                                    {{-- <x-dropdown-link :href="route('admin.bookings.show', $booking->id)">
                                                        {{ __('Detail') }}
                                                    </x-dropdown-link> --}}

                                                    <button
                                                        class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out text-start dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-green-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800"
                                                        @click="$dispatch('open-confirm-modal', {
                                                            title: 'Approve Booking',
                                                            message: 'Approve this booking request?',
                                                            confirmText: 'Approve',
                                                            confirmColor: 'bg-green-600 hover:bg-green-700',
                                                            action: '{{ route('admin.bookings.approve', $booking->id) }}',
                                                            method: 'PATCH'
                                                        })"
                                                    >
                                                        Approve
                                                    </button>

                                                    <button
                                                        class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out text-start dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-red-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800"
                                                        @click="$dispatch('open-confirm-modal', {
                                                            title: 'Cancel Booking',
                                                            message: 'Do you want to cancel this booking?',
                                                            confirmText: 'Yes, Cancel',
                                                            confirmColor: 'bg-orange-600 hover:bg-orange-700',
                                                            action: '{{ route('admin.bookings.reject', $booking->id) }}',
                                                            method: 'PATCH'
                                                        })"
                                                    >
                                                        Reject
                                                    </button>



                                                </x-slot>
                                            </x-dropdown>
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
