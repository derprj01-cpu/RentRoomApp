<div>
    <!-- Table Info -->
    <div class="p-3 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
        {{ $bookings->total() }} bookings • Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
    </div>

    <!-- Table -->
    <x-table-data
        :headers="[
            'user_name' => 'User',
            'room_name' => 'Room',
            'location' => 'Location',
            'schedule' => 'Schedule',
            'type' => 'Type',
            'purpose' => 'Purpose',
            'status' => 'Status',
            'action' => '',
        ]"
        :sortable="['user_name', 'room_name']"
    >
        @forelse ($bookings as $booking)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <!-- User -->
                <td class="px-3 py-3">
                    <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                        {{ $booking->user->name }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $booking->user->email }}
                    </div>
                </td>

                <!-- Room -->
                <td class="px-3 py-3">
                    <div class="text-sm text-gray-900 dark:text-gray-100">
                        {{ $booking->room->room_name }}
                    </div>
                </td>

                <!-- Location -->
                <td class="px-3 py-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ $booking->room->location }}
                </td>

                <!-- Schedule -->
                <td class="px-3 py-3">
                    <div class="text-sm text-gray-900 dark:text-gray-100">
                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} -
                        {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} mins
                    </div>
                </td>

                <!-- Type -->
                <td class="px-3 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded
                        @if($booking->room->type === 'meeting') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                        @elseif($booking->room->type === 'classroom') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @elseif($booking->room->type === 'lab') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                        @elseif($booking->room->type === 'ballroom') bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                        {{ ucfirst($booking->room->type) }}
                    </span>
                </td>

                <!-- Purpose -->
                <td class="px-3 py-3">
                    <div class="text-sm text-gray-700 dark:text-gray-300 max-w-xs truncate" title="{{ $booking->purpose }}">
                        {{ $booking->purpose }}
                    </div>
                </td>

                <!-- Status -->
                <td class="px-3 py-3">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                            'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                            'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                        ];
                        $statusColor = $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 text-xs rounded {{ $statusColor }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="px-3 py-3">
                    @if(auth()->user()->role === 'admin')
                        <x-dropdown align="right" width="40">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if($booking->status === 'pending')
                                    <!-- Approve Button -->
                                    <button
                                        onclick="confirmAction('Approve', '{{ route('admin.bookings.approve', $booking->id) }}', 'PATCH', 'Approve this booking?')"
                                        class="flex items-center w-full px-3 py-2 text-sm text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-900/20">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Approve
                                    </button>

                                    <!-- Reject Button -->
                                    <button
                                        onclick="confirmAction('Reject', '{{ route('admin.bookings.reject', $booking->id) }}', 'PATCH', 'Reject this booking?')"
                                        class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 border-t border-gray-100 dark:border-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                @endif

                                @if(in_array($booking->status, ['approved', 'pending']))
                                    <!-- Cancel Button -->
                                    <button
                                        onclick="confirmAction('Cancel', '{{ route('user.bookings.cancel', $booking->id) }}', 'PATCH', 'Cancel this booking?')"
                                        class="flex items-center w-full px-3 py-2 text-sm text-orange-600 hover:bg-orange-50 dark:text-orange-400 dark:hover:bg-orange-900/20 border-t border-gray-100 dark:border-gray-700">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </button>
                                @endif

                                <!-- View Details -->
                                <a href="{{ route('user.bookings.show', $booking->id) }}"
                                   class="flex items-center px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 border-t border-gray-100 dark:border-gray-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View
                                </a>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <!-- User Actions -->
                        <x-dropdown align="right" width="32">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                    ⋮
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if(in_array($booking->status, ['approved', 'pending']))
                                    <button
                                        onclick="confirmAction('Cancel', '{{ route('admin.bookings.reject', $booking->id) }}', 'PATCH', 'Cancel this booking?')"
                                        class="flex items-center w-full px-3 py-2 text-sm text-orange-600 hover:bg-orange-50 dark:text-orange-400 dark:hover:bg-orange-900/20">
                                        Cancel
                                    </button>
                                @endif
                                <a href="{{ route('admin.bookings.approve', $booking->id) }}"
                                   class="flex items-center px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 {{ in_array($booking->status, ['approved', 'pending']) ? 'border-t border-gray-100 dark:border-gray-700' : '' }}">
                                    View Details
                                </a>
                            </x-slot>
                        </x-dropdown>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-3 py-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="space-y-2">
                        <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-sm">No bookings found</p>
                        @if(request('search') || request('status') || request('date'))
                            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                Clear filters
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforelse
    </x-table-data>

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="px-3 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $bookings->firstItem() }}-{{ $bookings->lastItem() }} of {{ $bookings->total() }}
                </div>
                <div class="pagination text-sm">
                    {{ $bookings->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function confirmAction(action, url, method, message) {
    if (confirm(message)) {
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
}
</script>
