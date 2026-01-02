<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Room Booking Calendar') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    View and manage all room bookings visually
                </p>
            </div>

            <div class="flex items-center text-gray-800 dark:text-gray-400 gap-3">
                <!-- Filter Options -->
                <div class="flex items-center gap-2">
                    <select id="status-filter"
                            class="px-3 py-2 text-sm border border-gray-300 rounded-lg dark:border-gray-700 dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                    <select id="room-filter"
                            class="px-3 py-2 text-sm border border-gray-300 rounded-lg dark:border-gray-700 dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Rooms</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>

                    <button id="clear-filters"
                            class="px-3 py-2 text-sm text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                        Clear
                    </button>
                </div>

                <!-- Quick Add Button -->
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('user.bookings.create') }}"
                       class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        + New Booking
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">
            <!-- Calendar Container -->
            <div class="overflow-hidden text-gray-800 dark:text-gray-400 bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
                <!-- Calendar Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <!-- Legend -->
                        <div class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-yellow-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Pending</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-green-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Approved</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-red-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Rejected/Cancelled</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 mr-2 bg-blue-500 rounded"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400">Current Date</span>
                            </div>
                        </div>

                        <!-- View Toggle -->
                        <div class="flex items-center gap-2">
                            <button id="today-btn"
                                    class="px-3 py-1.5 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                                Today
                            </button>
                            <div class="flex overflow-hidden border border-gray-300 rounded-lg dark:border-gray-700">
                                <button data-view="dayGridMonth"
                                        class="px-3 py-1.5 text-sm text-gray-700 bg-white border-r border-gray-300 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 view-toggle active">
                                    Month
                                </button>
                                <button data-view="timeGridWeek"
                                        class="px-3 py-1.5 text-sm text-gray-700 bg-white border-r border-gray-300 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-700 view-toggle">
                                    Week
                                </button>
                                <button data-view="timeGridDay"
                                        class="px-3 py-1.5 text-sm text-gray-700 bg-white dark:text-gray-300 dark:bg-gray-800 view-toggle">
                                    Day
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="p-6">
                    <div id="calendar"></div>
                </div>
            </div>

            <!-- Upcoming Bookings Sidebar -->
            <div class="mt-6">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Upcoming Bookings (Next 7 Days)
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($upcomingBookings->count() > 0)
                            <div class="space-y-3">
                                @foreach($upcomingBookings as $booking)
                                <div class="flex items-center justify-between p-3 transition-colors duration-200 bg-gray-50 rounded-lg dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <div class="flex-shrink-0 p-2 mr-3 rounded-lg
                                            @if($booking->status === 'pending') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400
                                            @elseif($booking->status === 'approved') bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400
                                            @else bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 @endif">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                {{ $booking->room->room_name }}
                                            </p>
                                            <div class="flex items-center mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('D, M j - h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center ml-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                            @elseif($booking->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.bookings.index') : route('user.bookings.index') }}"
                               class="block mt-4 text-sm text-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                View all bookings →
                            </a>
                        @else
                            <div class="py-8 text-center text-gray-500 dark:text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>No upcoming bookings in the next 7 days</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Details Modal -->
    <div id="booking-modal"
         class="fixed inset-0 z-50 hidden overflow-y-auto"
         aria-labelledby="modal-title"
         role="dialog"
         aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <!-- Modal panel -->
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="modal-title" class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
                                Booking Details
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Room</p>
                                        <p id="modal-room" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">User</p>
                                        <p id="modal-user" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</p>
                                        <span id="modal-status" class="inline-block mt-1 text-xs font-medium px-2.5 py-0.5 rounded-full"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</p>
                                        <p id="modal-date" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Time</p>
                                    <p id="modal-time" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Purpose</p>
                                    <p id="modal-purpose" class="mt-1 text-sm text-gray-900 dark:text-white"></p>
                                </div>
                                @if(auth()->user()->role === 'admin')
                                <div id="modal-actions" class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                                    <!-- Actions will be inserted here -->
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                            id="close-modal"
                            class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-700 sm:ml-3 sm:w-auto">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        #calendar {
            min-height: 650px;
            font-size: 0.875rem;
            background: #1f293781 ;
            padding:1.5rem;
            border-radius: 1rem;
        }

        .fc-event {
            cursor: pointer;
            border: none;
            border-radius: 4px;
            padding: 2px 6px;
            margin: 1px;
            font-weight: 500;
        }

        .fc-event:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            transition: all 0.2s;
        }

        .fc-day-today {
            background-color: rgba(59, 130, 246, 0.5) !important;
        }

        .fc-toolbar-title {
            font-size: 1.25rem !important;
            font-weight: 600;
        }

        .fc-button {
            font-size: 0.875rem !important;
            padding: 6px 12px !important;
            border-radius: 6px !important;
            border: 1px solid #e5e7eb !important;
            background-color: white !important;
            color: #374151 !important;
        }

        .fc-button:hover {
            background-color: #f9fafb !important;
        }

        .fc-button-active {
            background-color: #3b82f6 !important;
            color: white !important;
            border-color: #3b82f6 !important;
        }

        /* Dark mode styles */
        .dark #calendar .fc {
            --fc-border-color: #374151;
            --fc-page-bg-color: #111827;
            --fc-neutral-bg-color: #111827;
            --fc-neutral-text-color: #d1d5db;
            --fc-today-bg-color: rgba(59, 130, 246, 0.2);
        }

        .dark #calendar .fc-button {
            background-color: #1f2937 !important;
            border-color: #374151 !important;
            color: #d1d5db !important;
        }

        .dark #calendar .fc-button:hover {
            background-color: #374151 !important;
        }

        .dark #calendar .fc-button-active {
            background-color: #3b82f6 !important;
        }

        .dark #calendar .fc-col-header-cell {
            background-color: #1f2937;
        }

        .dark #calendar .fc-daygrid-day {
            background-color: #111827;
        }

        .view-toggle.active {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        .dark .view-toggle.active {
            background-color: #3b82f6 !important;
            color: white !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendar;
            let currentStatusFilter = '';
            let currentRoomFilter = '';
            let currentView = 'dayGridMonth';

            // Initialize calendar
            function initCalendar(events) {
                const calendarEl = document.getElementById('calendar');

                if (calendar) {
                    calendar.destroy();
                }

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: currentView,
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: ''
                    },
                    initialDate: new Date(),
                    navLinks: false,
                    editable: false,
                    dayMaxEvents: 3,
                    events: events,
                    eventDidMount: function(info) {
                        // Color coding based on status
                        const status = info.event.extendedProps.status.toLowerCase();
                        let color = '';

                        if (status === 'pending') {
                            color = '#f59e0b'; // yellow
                        } else if (status === 'approved') {
                            color = '#10b981'; // green
                        } else if (status === 'rejected' || status === 'cancelled') {
                            color = '#ef4444'; // red
                        }

                        if (color) {
                            info.el.style.backgroundColor = color;
                            info.el.style.borderColor = color;
                            info.el.style.color = 'white';
                        }

                        // Tooltip
                        const title = info.event.title;
                        const room = info.event.extendedProps.room;
                        const user = info.event.extendedProps.user;
                        const time = info.event.extendedProps.time;
                        const purpose = info.event.extendedProps.purpose;

                        info.el.title = `${title}\nUser: ${user}\nTime: ${time}\nPurpose: ${purpose}`;
                    },
                    eventClick: function(info) {
                        showBookingDetails(info.event);
                    },
                    datesSet: function(info) {
                        // Update title format
                        const titleEl = document.querySelector('.fc-toolbar-title');
                        if (titleEl) {
                            const start = info.view.currentStart;
                            const end = info.view.currentEnd;
                            const viewType = info.view.type;

                            if (viewType === 'dayGridMonth') {
                                titleEl.textContent = start.toLocaleDateString('en-US', {
                                    month: 'long',
                                    year: 'numeric'
                                });
                            } else if (viewType === 'timeGridWeek') {
                                const startStr = start.toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                                const endStr = end.toLocaleDateString('en-US', {
                                    month: 'short',
                                    day: 'numeric'
                                });
                                titleEl.textContent = `${startStr} - ${endStr}`;
                            } else if (viewType === 'timeGridDay') {
                                titleEl.textContent = start.toLocaleDateString('en-US', {
                                    weekday: 'long',
                                    month: 'long',
                                    day: 'numeric',
                                    year: 'numeric'
                                });
                            }
                        }
                    }
                });

                calendar.render();

                // Update view toggle buttons
                updateViewToggle();
            }

            // Show booking details in modal
            function showBookingDetails(event) {
                const modal = document.getElementById('booking-modal');
                const extProps = event.extendedProps;

                // Set modal content
                document.getElementById('modal-room').textContent = extProps.room || 'N/A';
                document.getElementById('modal-user').textContent = extProps.user || 'N/A';
                document.getElementById('modal-date').textContent = extProps.date || 'N/A';
                document.getElementById('modal-time').textContent = extProps.time || 'N/A';
                document.getElementById('modal-purpose').textContent = extProps.purpose || 'N/A';

                // Set status badge
                const statusEl = document.getElementById('modal-status');
                const status = extProps.status || 'N/A';
                statusEl.textContent = status.charAt(0).toUpperCase() + status.slice(1);

                // Set status color
                statusEl.className = 'inline-block mt-1 text-xs font-medium px-2.5 py-0.5 rounded-full ';
                if (status === 'pending') {
                    statusEl.className += 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
                } else if (status === 'approved') {
                    statusEl.className += 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
                } else if (status === 'rejected' || status === 'cancelled') {
                    statusEl.className += 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
                } else {
                    statusEl.className += 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                }

                // Set admin actions if applicable
                const actionsEl = document.getElementById('modal-actions');
                if (actionsEl && extProps.bookingId) {
                    let actionsHTML = '';
                    if (status === 'pending') {
                        actionsHTML = `
                            <div class="flex space-x-2">
                                <button onclick="approveBooking(${extProps.bookingId})"
                                        class="px-3 py-1.5 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700">
                                    Approve
                                </button>
                                <button onclick="rejectBooking(${extProps.bookingId})"
                                        class="px-3 py-1.5 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">
                                    Reject
                                </button>
                            </div>
                        `;
                    } else if (status === 'approved') {
                        actionsHTML = `
                            <button onclick="cancelBooking(${extProps.bookingId})"
                                    class="px-3 py-1.5 text-sm text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                                Cancel
                            </button>
                        `;
                    }
                    actionsEl.innerHTML = actionsHTML;
                }

                // Show modal
                modal.classList.remove('hidden');
            }

            // Update view toggle buttons
            function updateViewToggle() {
                document.querySelectorAll('.view-toggle').forEach(btn => {
                    btn.classList.remove('active');
                    if (btn.dataset.view === currentView) {
                        btn.classList.add('active');
                    }
                });
            }

            // Load events with filters
            function loadEvents() {
                const params = new URLSearchParams();
                if (currentStatusFilter) params.set('status', currentStatusFilter);
                if (currentRoomFilter) params.set('room_id', currentRoomFilter);

                fetch(`{{ route('calendar.events') }}?${params.toString()}`)
                    .then(response => response.json())
                    .then(events => {
                        initCalendar(events);
                    })
                    .catch(error => {
                        console.error('Error loading events:', error);
                    });
            }

            // Event Listeners
            document.getElementById('status-filter').addEventListener('change', function(e) {
                currentStatusFilter = e.target.value;
                loadEvents();
            });

            document.getElementById('room-filter').addEventListener('change', function(e) {
                currentRoomFilter = e.target.value;
                loadEvents();
            });

            document.getElementById('clear-filters').addEventListener('click', function() {
                document.getElementById('status-filter').value = '';
                document.getElementById('room-filter').value = '';
                currentStatusFilter = '';
                currentRoomFilter = '';
                loadEvents();
            });

            document.getElementById('today-btn').addEventListener('click', function() {
                if (calendar) {
                    calendar.today();
                }
            });

            document.querySelectorAll('.view-toggle').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentView = this.dataset.view;
                    if (calendar) {
                        calendar.changeView(currentView);
                        updateViewToggle();
                    }
                });
            });

            document.getElementById('close-modal').addEventListener('click', function() {
                document.getElementById('booking-modal').classList.add('hidden');
            });

            // Close modal when clicking outside
            document.getElementById('booking-modal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Escape key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.getElementById('booking-modal').classList.add('hidden');
                }
            });

            // Initialize with default events
            initCalendar(@json($events));
        });

        // Booking action functions
        function approveBooking(bookingId) {
            if (confirm('Are you sure you want to approve this booking?')) {
                submitAction(bookingId, 'approve');
            }
        }

        function rejectBooking(bookingId) {
            if (confirm('Are you sure you want to reject this booking?')) {
                submitAction(bookingId, 'reject');
            }
        }

        function cancelBooking(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                submitAction(bookingId, 'cancel');
            }
        }

        function submitAction(bookingId, action) {
            let url, method;

            if (action === 'approve') {
                url = `/admin/bookings/${bookingId}/approve`;
                method = 'PATCH';
            } else if (action === 'reject') {
                url = `/admin/bookings/${bookingId}/reject`;
                method = 'PATCH';
            } else if (action === 'cancel') {
                url = `/user/bookings/cancel/${bookingId}`;
                method = 'PATCH';
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = method;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;

            form.appendChild(methodInput);
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
    @endpush
</x-app-layout>
