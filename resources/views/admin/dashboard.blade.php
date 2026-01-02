<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Welcome back, ') . Auth::user()->name }}
                </p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Rooms -->
                <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-2 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rooms</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalRooms }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <span class="text-green-600 dark:text-green-400">{{ $availableRooms }} available</span>
                    </div>
                </div>

                <!-- Today's Bookings -->
                <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-2 bg-purple-100 rounded-lg dark:bg-purple-900/30">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Today's Bookings</p>
                            <p class="text-2xl font-semibold text-purple-600 dark:text-purple-400">{{ $todayBookings }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        {{ \Carbon\Carbon::now()->format('M d, Y') }}
                    </div>
                </div>

                <!-- Pending Approvals -->
                <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-2 bg-yellow-100 rounded-lg dark:bg-yellow-900/30">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Approvals</p>
                            <p class="text-2xl font-semibold text-yellow-600 dark:text-yellow-400">{{ $pendingBookings }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Need your review
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="p-2 bg-green-100 rounded-lg dark:bg-green-900/30">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Bookings</p>
                            <p class="text-2xl font-semibold text-green-600 dark:text-green-400">{{ $activeBookings }}</p>
                        </div>
                    </div>
                    <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                        Approved & upcoming
                    </div>
                </div>
            </div>

            <!-- Main Content with Calendar -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Quick Actions -->
                <div>
                    <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>

                        <div class="space-y-3">
                            <a href="{{ route('admin.rooms.create') }}"
                               class="flex items-center p-3 text-gray-700 transition-colors bg-gray-50 rounded-lg dark:bg-gray-700/50 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="p-2 mr-3 bg-blue-100 rounded dark:bg-blue-900/30">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>
                                <span>Add New Room</span>
                            </a>

                            <a href="{{ route('admin.bookings.index') }}?status=pending"
                               class="flex items-center p-3 text-gray-700 transition-colors bg-gray-50 rounded-lg dark:bg-gray-700/50 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="p-2 mr-3 bg-yellow-100 rounded dark:bg-yellow-900/30">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span>Review Pending Bookings</span>
                            </a>

                            <a href="{{ route('admin.rooms.index') }}"
                               class="flex items-center p-3 text-gray-700 transition-colors bg-gray-50 rounded-lg dark:bg-gray-700/50 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="p-2 mr-3 bg-gray-100 rounded dark:bg-gray-700">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </div>
                                <span>Manage Rooms</span>
                            </a>

                            <a href="{{ route('calendar') }}"
                               class="flex items-center p-3 text-gray-700 transition-colors bg-gray-50 rounded-lg dark:bg-gray-700/50 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <div class="p-2 mr-3 bg-purple-100 rounded dark:bg-purple-900/30">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span>View Full Calendar</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                    <div class="mt-6 p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>

                        <div class="space-y-3">
                            @foreach($recentBookings as $booking)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->room->room_name }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $booking->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                                           'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Calendar Section -->
                <div class="lg:col-span-2">
                    <div class="p-6 bg-white rounded-lg shadow-sm dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Booking Calendar</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Quick overview of room bookings</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button id="prev-month" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="next-month" class="p-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Mini Calendar -->
                        <div id="mini-calendar" class="mb-6"></div>

                        <!-- Legend -->
                        <div class="flex flex-wrap items-center gap-4 mb-6">
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-blue-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Meeting Rooms</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-green-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Classrooms</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-purple-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Labs</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-yellow-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Ballrooms</span>
                            </div>
                        </div>

                        <!-- Today's Schedule -->
                        <div>
                            <h4 class="mb-3 text-sm font-semibold text-gray-900 dark:text-white">Today's Schedule</h4>
                            @if($todayBookingsList->count() > 0)
                                <div class="space-y-2">
                                    @foreach($todayBookingsList->take(3) as $booking)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-gray-700/50">
                                        <div class="flex items-center">
                                            <div class="p-2 mr-3 rounded-lg
                                                @if($booking->room->type === 'meeting') bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                                                @elseif($booking->room->type === 'classroom') bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                                                @elseif($booking->room->type === 'lab') bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400
                                                @else bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400 @endif">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->room->room_name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} -
                                                    {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            {{ $booking->user->name }}
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                @if($todayBookingsList->count() > 3)
                                <a href="{{ route('calendar') }}" class="block mt-3 text-sm text-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    View all {{ $todayBookingsList->count() }} bookings today →
                                </a>
                                @endif
                            @else
                                <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-lg dark:bg-gray-700/50 dark:text-gray-400">
                                    <p>No bookings scheduled for today</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize mini calendar
            const calendarEl = document.getElementById('mini-calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: false,
                height: 'auto',
                aspectRatio: 1.5,
                dayMaxEventRows: 2,
                events: '{{ route("calendar.events") }}',
                eventDisplay: 'block',
                eventTimeFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short'
                },
                eventDidMount: function(info) {
                    // Color coding based on room type
                    const type = info.event.extendedProps.type;
                    if (type === 'meeting') {
                        info.el.style.backgroundColor = '#3b82f6';
                        info.el.style.borderColor = '#3b82f6';
                    } else if (type === 'classroom') {
                        info.el.style.backgroundColor = '#10b981';
                        info.el.style.borderColor = '#10b981';
                    } else if (type === 'lab') {
                        info.el.style.backgroundColor = '#8b5cf6';
                        info.el.style.borderColor = '#8b5cf6';
                    } else if (type === 'ballroom') {
                        info.el.style.backgroundColor = '#f59e0b';
                        info.el.style.borderColor = '#f59e0b';
                    }

                    // Tooltip
                    const title = info.event.title;
                    const room = info.event.extendedProps.room;
                    const time = info.event.extendedProps.time;
                    info.el.title = `${title}\n${room}\n${time}`;
                },
                dateClick: function(info) {
                    // Redirect to full calendar view for that date
                    window.location.href = '{{ route("calendar") }}?date=' + info.dateStr;
                }
            });

            calendar.render();

            // Navigation buttons
            document.getElementById('prev-month').addEventListener('click', function() {
                calendar.prev();
            });

            document.getElementById('next-month').addEventListener('click', function() {
                calendar.next();
            });
        });
    </script>

    <style>
        /* Custom calendar styling */
        #mini-calendar .fc {
            font-size: 0.875rem;
        }

        #mini-calendar .fc-daygrid-day-number {
            font-size: 0.75rem;
            padding: 2px;
        }

        #mini-calendar .fc-daygrid-day-frame {
            min-height: 50px;
        }

        #mini-calendar .fc-event {
            font-size: 0.7rem;
            padding: 1px 3px;
            margin: 1px;
            border-radius: 2px;
            cursor: pointer;
        }

        #mini-calendar .fc-col-header-cell {
            font-size: 0.75rem;
            padding: 4px 2px;
        }

        .dark #mini-calendar .fc {
            --fc-border-color: #374151;
            --fc-page-bg-color: #1f2937;
            --fc-neutral-bg-color: #1f2937;
            --fc-neutral-text-color: #d1d5db;
            --fc-today-bg-color: rgba(59, 130, 246, 0.1);
        }

        .dark #mini-calendar .fc-daygrid-day {
            background-color: #1f2937;
        }

        .dark #mini-calendar .fc-daygrid-day.fc-day-today {
            background-color: rgba(59, 130, 246, 0.1);
        }
    </style>
    @endpush
</x-app-layout>
