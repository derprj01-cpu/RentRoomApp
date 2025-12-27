<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Rooms Management') }}
            </h2>

            <x-primary-button>
                <a href="{{ route('admin.rooms.create') }}">Create Room</a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <!-- Card -->
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6">

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-4">Room Name</th>
                                    <th class="px-6 py-4">Location</th>
                                    <th class="px-6 py-4">Capacity</th>
                                    <th class="px-6 py-4">Type</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($rooms as $room)
                                    <tr class="transition border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $room->room_name }}
                                        </td>
                                        <td class="px-6 py-4">{{ $room->location }}</td>
                                        <td class="px-6 py-4">{{ $room->capacity }}</td>
                                        <td class="px-6 py-4">{{ $room->type }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded-full
                                                {{ $room->status === 'available'
                                                    ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                                    : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </td>
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
                                                    <x-dropdown-link :href="route('admin.rooms.edit', $room->id)">
                                                        {{ __('Edit') }}
                                                    </x-dropdown-link>

                                                    <button
                                                        @click="$dispatch('open-confirm-modal', {
                                                            title: 'Delete Room',
                                                            message: 'Are you sure you want to delete {{ $room->room_name }}?',
                                                            confirmText: 'Delete',
                                                            confirmColor: 'bg-red-600 hover:bg-red-700',
                                                            action: '{{ route('admin.rooms.destroy', $room->id) }}',
                                                            method: 'DELETE'
                                                        })"
                                                        class="block w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out text-start dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-red-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                                        Delete
                                                    </button>

                                                </x-slot>
                                            </x-dropdown>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No rooms available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $rooms->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
