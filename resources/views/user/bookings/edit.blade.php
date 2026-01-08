<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Edit Booking') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update your booking details
                </p>
            </div>

            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 text-xs font-medium rounded-full
                    @if($booking->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                    @elseif($booking->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                    @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300 @endif">
                    {{ ucfirst($booking->status) }}
                </span>

                <span class="px-3 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    {{ $booking->room->room_name }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Booking Summary -->
            <div class="p-6 mb-6 bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <!-- Room Info -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Room</h4>
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gray-100 rounded-lg dark:bg-gray-700">
                                @if($booking->room->type === 'meeting')
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @elseif($booking->room->type === 'classroom')
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                                @elseif($booking->room->type === 'lab')
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                @else
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $booking->room->room_name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->room->location }}</p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Capacity: {{ $booking->room->capacity }} people
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Date & Time -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Schedule</h4>
                        <div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F d, Y') }}</span>
                            </div>
                            <div class="flex items-center mt-1 space-x-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Details</h4>
                        <div class="space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Duration:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours($booking->end_time) }} hours
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Type:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ ucfirst(str_replace('_', ' ', $booking->duration_type)) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Created:</span>
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Alert -->
            @if($booking->status !== 'pending')
                <div class="p-4 mb-6 border border-yellow-200 rounded-lg bg-yellow-50 dark:bg-yellow-900/20 dark:border-yellow-800">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                Booking Status: {{ ucfirst($booking->status) }}
                            </h3>
                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                <p>
                                    @if($booking->status === 'approved')
                                        Your booking has been approved. You can only update the purpose at this time.
                                    @elseif($booking->status === 'rejected')
                                        Your booking has been rejected. You can create a new booking with different details.
                                    @elseif($booking->status === 'cancelled')
                                        Your booking has been cancelled. You can create a new booking.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Edit Form -->
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <form method="post" action="{{ route('user.bookings.update', $booking->id) }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <!-- Purpose (Always Editable) -->
                        <div>
                            <x-input-label for="purpose" value="Purpose of Booking *" />
                            <textarea
                                id="purpose"
                                name="purpose"
                                rows="3"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                placeholder="Describe the purpose of your booking..."
                                required
                            >{{ old('purpose', $booking->purpose) }}</textarea>
                            <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Please provide a clear description of what the room will be used for.
                            </p>
                        </div>

                        <!-- For PENDING Status: Show All Fields -->
                        @if($booking->status === 'pending')
                            <!-- Room Selection -->
                            <div>
                                <x-input-label for="room_id" value="Select Room *" />
                                <select
                                    id="room_id"
                                    name="room_id"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                    required
                                >
                                    <option value="">-- Select a Room --</option>
                                    @foreach(\App\Models\Room::where('status', 'available')->orderBy('room_name')->get() as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>
                                            {{ $room->room_name }} ({{ $room->location }}) - Capacity: {{ $room->capacity }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('room_id')" class="mt-2" />
                            </div>

                            <!-- Booking Date -->
                            <div>
                                <x-input-label for="booking_date" value="Booking Date *" />
                                <x-text-input
                                    id="booking_date"
                                    name="booking_date"
                                    type="date"
                                    class="block w-full mt-1"
                                    :value="old('booking_date', \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d'))"
                                    required
                                />
                                <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                            </div>

                            <!-- Start Time -->
                            <div>
                                <x-input-label for="start_time" value="Start Time *" />
                                <x-text-input
                                    id="start_time"
                                    name="start_time"
                                    type="time"
                                    class="block w-full mt-1"
                                    :value="old('start_time', \Carbon\Carbon::parse($booking->start_time)->format('H:i'))"
                                    required
                                />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <!-- Duration Type -->
                            <div>
                                <x-input-label for="duration_type" value="Duration Type *" />
                                <select
                                    id="duration_type"
                                    name="duration_type"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                    required
                                >
                                    <option value="">-- Select Duration --</option>
                                    <option value="6_hours" {{ old('duration_type', $booking->duration_type) == '6_hours' ? 'selected' : '' }}>
                                        6 Hours
                                    </option>
                                    <option value="12_hours" {{ old('duration_type', $booking->duration_type) == '12_hours' ? 'selected' : '' }}>
                                        12 Hours
                                    </option>
                                    <option value="daily" {{ old('duration_type', $booking->duration_type) == 'daily' ? 'selected' : '' }}>
                                        Daily (Until End of Day)
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('duration_type')" class="mt-2" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Note: End time will be calculated automatically based on your selection.
                                </p>
                            </div>

                            <!-- Hidden End Time (Will be calculated by controller) -->
                            <input type="hidden" name="end_time" value="{{ $booking->end_time }}">

                        @endif

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div>
                                @if($booking->status === 'pending')
                                    <button
                                        type="button"
                                        onclick="confirmCancel()"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 border border-red-200 rounded-lg bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800 dark:hover:bg-red-900/50"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel Booking
                                    </button>
                                @endif
                            </div>

                            <div class="flex items-center space-x-3">
                                <a href="{{ route('user.bookings.index') }}"
                                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                    Back to List
                                </a>

                                <x-primary-button type="submit">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    @if($booking->status === 'pending')
                                        Update Booking
                                    @else
                                        Update Purpose
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </form>

                    <!-- Cancel Booking Form (Hidden) -->
                    @if($booking->status === 'pending')
                    <form id="cancel-booking-form" method="post" action="{{ route('user.bookings.cancel', $booking->id) }}" class="hidden">
                        @csrf
                        @method('patch')
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function confirmCancel() {
        if (confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
            document.getElementById('cancel-booking-form').submit();
        }
    }

    // JavaScript untuk menghitung end_time berdasarkan duration_type
    document.addEventListener('DOMContentLoaded', function() {
        const bookingDateInput = document.getElementById('booking_date');
        const startTimeInput = document.getElementById('start_time');
        const durationTypeSelect = document.getElementById('duration_type');
        const hiddenEndTime = document.querySelector('input[name="end_time"]');

        // Set min date to today
        if (bookingDateInput) {
            const today = new Date().toISOString().split('T')[0];
        }

        // Function to calculate end time
        function calculateEndTime() {
            if (!startTimeInput || !durationTypeSelect || !hiddenEndTime) return;

            const startTime = startTimeInput.value;
            const durationType = durationTypeSelect.value;

            if (!startTime || !durationType) return;

            // Parse start time
            const [startHours, startMinutes] = startTime.split(':').map(Number);

            // Calculate end time based on duration type
            let endHours = startHours;
            let endMinutes = startMinutes;

            switch(durationType) {
                case '6_hours':
                    endHours = startHours + 6;
                    break;
                case '12_hours':
                    endHours = startHours + 12;
                    break;
                case 'daily':
                    // For daily, set to 23:59 (end of day)
                    endHours = 23;
                    endMinutes = 59;
                    break;
            }

            // Handle overflow to next day
            if (endHours >= 24) {
                endHours -= 24;
            }

            // Format to HH:MM
            const formattedEndTime =
                endHours.toString().padStart(2, '0') + ':' +
                endMinutes.toString().padStart(2, '0');

            // Update hidden field
            hiddenEndTime.value = formattedEndTime;

            // Optional: Show end time to user (if you have a display element)
            const endTimeDisplay = document.getElementById('end_time_display');
            if (endTimeDisplay) {
                endTimeDisplay.textContent = formattedEndTime;
            }
        }

        // Add event listeners for calculation
        if (startTimeInput && durationTypeSelect) {
            startTimeInput.addEventListener('change', calculateEndTime);
            durationTypeSelect.addEventListener('change', calculateEndTime);

            // Calculate on page load
            calculateEndTime();
        }

        // Time validation
        if (startTimeInput) {
            startTimeInput.addEventListener('change', function() {
                if (durationTypeSelect && durationTypeSelect.value === 'daily') {
                    // For daily, no need to check end time
                    return;
                }

                // You could add additional validation here if needed
            });
        }
    });
    </script>
    @endpush
</x-app-layout>
