<div>
    <!-- Table Info -->
    <div class="px-4 py-3 text-sm text-gray-600 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        {{ $bookings->total() }} bookings • Page {{ $bookings->currentPage() }} of {{ $bookings->lastPage() }}
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Room</th>
                    <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Schedule</th>
                    <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Purpose</th>
                    <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Status</th>
                    <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse ($bookings as $booking)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <!-- Room -->
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $booking->room->room_name }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $booking->room->location }}
                        </div>
                    </td>

                    <!-- Schedule -->
                    <td class="px-4 py-3">
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('h:i A') }} -
                            {{ \Carbon\Carbon::parse($booking->end_time)->format('h:i A') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes($booking->end_time) }} minutes
                        </div>
                    </td>

                    <!-- Purpose -->
                    <td class="px-4 py-3">
                        <div class="max-w-xs text-sm text-gray-700 dark:text-gray-300 truncate" title="{{ $booking->purpose }}">
                            {{ $booking->purpose }}
                        </div>
                    </td>

                    <!-- Status -->
                    <td class="px-4 py-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                            ];
                        @endphp
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="px-4 py-3">
                        <!-- Admin Actions -->
                        <x-dropdown align="right" width="32">
                            <x-slot name="trigger">
                                <button class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                    ⋮
                                </button>
                            </x-slot>

                            <x-slot name="content">

                                @if(in_array($booking->status, ['approved', 'pending']))
                                    <!-- Cancel Button (for admin to cancel approved/pending bookings) -->
                                    <button
                                        onclick="confirmAction('Cancel', '{{ route('admin.bookings.reject', $booking->id) }}', 'PATCH', 'Cancel this booking?')"
                                        class="flex items-center w-full px-3 py-2 text-sm text-orange-600 hover:bg-orange-50 dark:text-orange-400 dark:hover:bg-orange-900/20 {{ $booking->status === 'pending' ? 'border-t border-gray-100 dark:border-gray-700' : '' }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </button>
                                @endif

                                <!-- View Details Link -->
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                class="flex items-center px-3 py-2 text-sm text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-900/20 border-t border-gray-100 dark:border-gray-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </a>
                            </x-slot>
                        </x-dropdown>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="space-y-2">
                            <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">No bookings found</p>
                            @if(request('search') || request('status') || request('date'))
                                <a href="{{ route('user.bookings.index') }}"
                                   class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    Clear filters
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} results
                </div>
                <div class="text-sm">
                    {{ $bookings->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function confirmCancel(url) {
    if (confirm('Are you sure you want to cancel this booking?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = url;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';

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
