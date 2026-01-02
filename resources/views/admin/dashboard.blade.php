<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in! as Admin") }}
                </div>
            </div>

            <div class="py-8">
                <div class="mx-auto space-y-6 max-w-7xl">
                    {{-- Stats --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="p-5 bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-400">Total Rooms</p>
                            <p class="text-3xl font-bold text-white">{{ $totalRooms }}</p>
                        </div>

                        <div class="p-5 bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-400">Available</p>
                            <p class="text-3xl font-bold text-green-400">{{ $availableRooms }}</p>
                        </div>

                        <div class="p-5 bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-400">Bookings Today</p>
                            <p class="text-3xl font-bold text-blue-400">{{ $todayBookings }}</p>
                        </div>

                        <div class="p-5 bg-gray-800 rounded-lg">
                            <p class="text-sm text-gray-400">Active Bookings</p>
                            <p class="text-3xl font-bold text-yellow-400">{{ $activeBookings }}</p>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="flex gap-4">
                        <a href="{{ route('admin.rooms.create') }}"
                        class="px-4 py-2 bg-indigo-600 rounded hover:bg-indigo-700">
                            + Add Room
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
