<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    Booking Details
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Booking ID: #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="window.print()"
                        class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 transition-colors bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </button>
                <a href="{{ url()->previous() }}"
                   class="flex items-center gap-2 px-4 py-2 text-sm text-white transition-colors bg-gray-600 border border-gray-600 rounded-lg hover:bg-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Status Banner -->
            <div class="mb-6 overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Booking Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Created on {{ $booking->created_at->format('F d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full
                                {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                                   ($booking->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' :
                                   'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300')) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                            @if($booking->status === 'approved' && $booking->start_time > now())
                                <span class="px-3 py-1.5 text-sm font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                    Upcoming
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Left Column - Room & Schedule -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Room Card -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Room Details</h4>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $booking->room->room_name }}</h5>
                                    <div class="grid grid-cols-2 gap-4 mt-4">
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $booking->room->location ?? 'Not specified' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Capacity</p>
                                            <p class="font-medium text-gray-900 dark:text-white">{{ $booking->room->capacity }} people</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Room Type</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($booking->room->type === 'meeting') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                                @elseif($booking->room->type === 'classroom') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                                @elseif($booking->room->type === 'lab') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                                                @else bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400 @endif">
                                                {{ ucfirst($booking->room->type) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Room Status</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $booking->room->status === 'available' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                {{ ucfirst($booking->room->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($booking->room->description)
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                                            <p class="mt-1 text-gray-600 dark:text-gray-300">{{ $booking->room->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Card -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Booking Schedule</h4>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Date & Time -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Booking Date</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F d, Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Start Time</p>
                                            <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }}
                                            </p>
                                        </div>
                                        <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">End Time</p>
                                            <p class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Duration & Timing Info -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Duration</p>
                                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} minutes
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-4 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Time Status</p>
                                        <div class="mt-2">
                                            @php
                                                $now = now();
                                                $startTime = \Carbon\Carbon::parse($booking->start_time);
                                                $endTime = \Carbon\Carbon::parse($booking->end_time);

                                                if ($now < $startTime) {
                                                    $timeStatus = 'Upcoming';
                                                    $statusColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400';
                                                } elseif ($now >= $startTime && $now <= $endTime) {
                                                    $timeStatus = 'In Progress';
                                                    $statusColor = 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                                                } else {
                                                    $timeStatus = 'Completed';
                                                    $statusColor = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColor }}">
                                                {{ $timeStatus }}
                                            </span>
                                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                                @if($timeStatus === 'Upcoming')
                                                    Starts in {{ $startTime->diffForHumans($now, ['parts' => 2]) }}
                                                @elseif($timeStatus === 'In Progress')
                                                    Ends in {{ $endTime->diffForHumans($now, ['parts' => 2]) }}
                                                @else
                                                    Ended {{ $endTime->diffForHumans($now) }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Purpose Card -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Purpose & Notes</h4>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="prose max-w-none dark:prose-invert">
                                        @if($booking->purpose)
                                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $booking->purpose }}</p>
                                        @else
                                            <p class="text-gray-500 dark:text-gray-400 italic">No purpose specified</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - User & Actions -->
                <div class="space-y-6">
                    <!-- User Card -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Booked By</h4>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center text-center">
                                <div class="flex items-center justify-center w-16 h-16 mb-4 text-2xl font-semibold text-white bg-indigo-600 rounded-full dark:bg-indigo-500">
                                    {{ substr($booking->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $booking->user->name }}</h5>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->email }}</p>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        User ID: {{ str_pad($booking->user->id, 4, '0', STR_PAD_LEFT) }}
                                    </p>
                                </div>
                                <div class="w-full mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Bookings</p>
                                    <p class="text-xl font-semibold text-gray-900 dark:text-white">
                                        {{ $booking->user->bookings->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Quick Actions</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @if(auth()->user()->role === 'admin')
                                    @if($booking->status === 'pending')
                                        <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="w-full">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg hover:bg-green-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve Booking
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}" class="w-full">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to reject this booking?')"
                                                    class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-white transition-colors bg-red-600 rounded-lg hover:bg-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject Booking
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if(auth()->user()->role === 'user' && in_array($booking->status, ['pending', 'approved']))
                                    @if($booking->start_time > now())
                                        <form method="POST" action="{{ route('user.bookings.cancel', $booking) }}" class="w-full">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                                    class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-white transition-colors bg-orange-500 rounded-lg hover:bg-orange-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Cancel Booking
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                <a href="{{ route('calendar') }}?date={{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}"
                                   class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-gray-700 transition-colors bg-gray-100 rounded-lg dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    View in Calendar
                                </a>

                                <a href="{{ route('admin.rooms.edit', $booking->room->id) }}"
                                   class="flex items-center justify-center w-full gap-2 px-4 py-3 text-sm font-medium text-blue-600 transition-colors bg-blue-50 rounded-lg dark:bg-blue-900/20 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Room Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Timeline -->
                    <div class="overflow-hidden bg-white rounded-xl shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white">Booking Timeline</h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Booking Created</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $booking->created_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                </div>

                                @if($booking->status === 'approved')
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/30">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Approved</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $booking->updated_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                @endif

                                @if($booking->status === 'rejected' || $booking->status === 'cancelled')
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30">
                                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ ucfirst($booking->status) }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $booking->updated_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
            .shadow, .shadow-sm {
                box-shadow: none !important;
            }
            .border, .border-t, .border-b {
                border: 1px solid #e5e7eb !important;
            }
            .dark .border, .dark .border-t, .dark .border-b {
                border: 1px solid #374151 !important;
            }
            .print-break {
                page-break-inside: avoid;
            }
            .bg-gray-50, .bg-white, .dark\:bg-gray-800 {
                background-color: white !important;
            }
            .text-gray-900, .text-gray-700, .dark\:text-white, .dark\:text-gray-300 {
                color: black !important;
            }
            .text-gray-500, .text-gray-400, .dark\:text-gray-400 {
                color: #6b7280 !important;
            }
        }
    </style>
</x-app-layout>
