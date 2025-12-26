<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Rooms Management') }}
            </h2>

            <x-primary-button>
                {{ __('Create Room') }}
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
                                        <td class="px-6 py-4 space-x-2 text-right">
                                            <x-secondary-button>
                                                Edit
                                            </x-secondary-button>

                                            <x-danger-button>
                                                Delete
                                            </x-danger-button>
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
