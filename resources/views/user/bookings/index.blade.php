<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('My Bookings') }}
            </h2>

            <x-primary-button>
                <a href="{{ route('user.bookings.create') }}">+ New Booking</a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6">

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4">Room</th>
                                    <th class="px-6 py-4">Location</th>
                                    <th class="px-6 py-4">Schedule</th>
                                    <th class="px-6 py-4">Purpose</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($bookings as $booking)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">

                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $booking->room->room_name }}
                                        </td>

                                        <td class="px-6 py-4">
                                            {{ $booking->room->location }}
                                        </td>

                                        <td class="px-6 py-4 text-xs">
                                            <div>{{ $booking->start_time }} – {{ $booking->end_time }}</div>
                                            <div class="text-gray-400">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} mins
                                            </div>
                                        </td>

                                        <td class="max-w-xs px-6 py-4 truncate">
                                            {{ $booking->purpose }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <span @class([
                                                'px-2 py-1 rounded-full text-xs font-semibold',
                                                'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' => $booking->status === 'pending',
                                                'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' => $booking->status === 'approved',
                                                'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' => $booking->status === 'rejected',
                                            ])>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                                <button
                                                    @click="open = !open"
                                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-500 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M6 10a2 2 0 114 0 2 2 0 01-4 0zm4-6a2 2 0 114 0 2 2 0 01-4 0zm0 12a2 2 0 114 0 2 2 0 01-4 0z"/>
                                                    </svg>
                                                </button>

                                                <div
                                                    x-show="open"
                                                    @click.outside="open = false"
                                                    x-transition
                                                    class="absolute right-0 z-50 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg w-36 dark:bg-gray-800 dark:border-gray-700">

                                                    <a href="{{ route('user.bookings.show', $booking) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                        Detail
                                                    </a>

                                                    @if ($booking->status === 'pending')
                                                        <form method="POST"
                                                            action="{{ route('user.bookings.cancel', $booking->id) }}">
                                                            @csrf
                                                            @method('PATCH')

                                                            <button type="submit"
                                                                class="w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30">
                                                                Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                            You have no bookings yet.
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
