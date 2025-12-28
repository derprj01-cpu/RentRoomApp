<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                Booking Details
            </h2>
            <div class="flex gap-2">
                <button onclick="window.print()"
                        class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50">
                    Print
                </button>
                <a href="{{ url()->previous() }}"
                   class="px-3 py-2 text-sm text-white bg-gray-600 border border-gray-600 rounded-md hover:bg-gray-700">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl py-6 mx-auto">
        <div class="overflow-hidden bg-white shadow dark:bg-gray-900 sm:rounded-lg">
            <!-- Status Banner -->
            <div class="px-6 py-4 border-b dark:border-gray-700
                {{ $booking->status === 'approved' ? 'bg-green-50 dark:bg-green-900/20' :
                   ($booking->status === 'pending' ? 'bg-yellow-50 dark:bg-yellow-900/20' :
                   'bg-red-50 dark:bg-red-900/20') }}">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Booking #{{ $booking->id }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Created on {{ $booking->created_at->format('F d, Y') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100' :
                           'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100') }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="px-6 py-4">
                <div class="grid gap-4 md:grid-cols-2">
                    <!-- Room Section -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Room Information</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Room Name</p>
                                <p class="font-medium text-indigo-500">{{ $booking->room->room_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                                <p class="font-medium text-indigo-500">{{ $booking->room->location ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Section -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Schedule</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                                <p class="font-medium text-indigo-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Start Time</p>
                                    <p class="font-medium text-indigo-500">{{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">End Time</p>
                                    <p class="font-medium text-indigo-500">{{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Duration Type</p>
                                <p class="font-medium text-indigo-500">{{ ucfirst(str_replace('_', ' ', $booking->duration_type)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- User Section -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Booked By</h4>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                                <p class="font-medium text-indigo-500">{{ $booking->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                <p class="text-sm text-indigo-500">{{ $booking->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose Section -->
                    <div class="space-y-3">
                        <h4 class="font-medium text-gray-700 dark:text-gray-300">Purpose</h4>
                        <div class="p-3 rounded bg-gray-50 dark:bg-gray-800">
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ $booking->purpose ?? 'No purpose specified' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 border-t dark:border-gray-700">
                <div class="flex gap-2">
                    @if(auth()->user()->role === 'admin' && $booking->status === 'pending')
                        <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-4 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700">
                                Approve
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="px-4 py-2 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                                Reject
                            </button>
                        </form>
                    @endif

                    @if(auth()->user()->role === 'user' && in_array($booking->status, ['pending', 'approved']))
                        <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    class="px-4 py-2 text-sm text-white bg-orange-500 rounded hover:bg-orange-600">
                                Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            header, footer, nav, .no-print, button:not(.print-only) {
                display: none !important;
            }
            body {
                font-size: 12pt;
            }
            .print-break {
                page-break-inside: avoid;
            }
            .shadow {
                box-shadow: none !important;
            }
        }
    </style>
</x-app-layout>
