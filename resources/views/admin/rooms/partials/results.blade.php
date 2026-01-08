<div>
    <!-- Table Info -->
    <div class="p-3 border-b border-gray-200 dark:border-gray-700 text-sm text-gray-600 dark:text-gray-400">
        {{ $rooms->total() }} rooms • Page {{ $rooms->currentPage() }} of {{ $rooms->lastPage() }}
    </div>

    <!-- Table -->
    <x-table-data
        :headers="[
            'room_name' => 'Room Name',
            'location'  => 'Location',
            'capacity'  => 'Cap',
            'type'      => 'Type',
            'status'    => 'Status',
            'action'    => '',
        ]"
        :sortable="['room_name', 'location', 'capacity', 'status']"
    >
        @forelse ($rooms as $room)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <!-- Room Name -->
                <td class="px-3 py-3">
                    <div class="font-medium text-gray-900 dark:text-gray-100 text-sm">
                        {{ $room->room_name }}
                    </div>
                </td>

                <!-- Location -->
                <td class="px-3 py-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ $room->location }}
                </td>

                <!-- Capacity -->
                <td class="px-3 py-3 text-sm text-gray-700 dark:text-gray-300">
                    {{ $room->capacity }}
                </td>

                <!-- Type -->
                <td class="px-3 py-3 text-sm">
                    <span class="px-2 py-1 text-xs rounded
                        @if($room->type === 'meeting') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                        @elseif($room->type === 'classroom') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                        @elseif($room->type === 'lab') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400
                        @elseif($room->type === 'ballroom') bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                        {{ Str::limit(ucfirst($room->type), 10) }}
                    </span>
                </td>

                <!-- Status -->
                <td class="px-3 py-3">
                    <span class="px-2 py-1 text-xs rounded
                        {{ $room->status === 'available'
                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                            : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                        {{ Str::limit(ucfirst($room->status), 10) }}
                    </span>
                </td>

                <!-- Actions -->
                <td class="px-3 py-3">
                    <x-dropdown align="right" width="40">
                        <x-slot name="trigger">
                            <button class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 p-1.5 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Edit Button -->
                            <x-dropdown-link href="{{ route('admin.rooms.edit', $room->id) }}"
                                        class="flex items-center px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">
                                <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </x-dropdown-link>

                            <!-- Delete Button -->
                            <button
                                type="button"
                                @click.prevent.stop="
                                    window.dispatchEvent(new CustomEvent('open-confirm-modal', {
                                        detail: {
                                            title: 'Delete Room',
                                            message: 'This room will be permanently deleted. Continue?',
                                            confirmText: 'Delete',
                                            type: 'danger',
                                            action: '{{ route('admin.rooms.destroy', $room->id) }}',
                                            method: 'DELETE'
                                        }
                                    }))
                                "
                                class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 border-t border-gray-100 dark:border-gray-700"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </x-slot>
                    </x-dropdown>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-3 py-8 text-center text-gray-500 dark:text-gray-400">
                    <div class="space-y-2">
                        <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <p class="text-sm">No rooms found</p>
                        @if(request('search') || request('status'))
                            <a href="{{ route('admin.rooms.index') }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                Clear filters
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforelse
    </x-table-data>

    <!-- Pagination -->
    @if($rooms->hasPages())
        <div class="px-3 py-3 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $rooms->firstItem() }}-{{ $rooms->lastItem() }} of {{ $rooms->total() }}
                </div>
                <div class="pagination text-sm">
                    {{ $rooms->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
