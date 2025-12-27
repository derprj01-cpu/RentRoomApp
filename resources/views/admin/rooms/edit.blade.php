<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">

                    <header class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Room Information
                        </h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Fill the form below to edit a room.
                        </p>
                    </header>

                    <form method="post" action="{{ route('admin.rooms.update',$room->id) }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <!-- Room Name -->
                        <div>
                            <x-input-label for="room_name" value="Room Name" />
                            <x-text-input
                                id="room_name"
                                name="room_name"
                                type="text"
                                class="block w-full mt-1"
                                :value="old('room_name', $room->room_name)"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('room_name')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" value="Location" />
                            <x-text-input
                                id="location"
                                name="location"
                                type="text"
                                class="block w-full mt-1"
                                :value="old('location',$room->location)"
                                required
                            />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Capacity -->
                        <div>
                            <x-input-label for="capacity" value="Capacity" />
                            <x-text-input
                                id="capacity"
                                name="capacity"
                                type="number"
                                min="1"
                                class="block w-full mt-1"
                                :value="old('capacity', $room->capacity)"
                                required
                            />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        <!-- Type -->
                        <div>
                            <x-input-label for="type" value="Room Type" />
                            <select
                                id="type"
                                name="type"
                                class="block w-full mt-1 border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                required
                            >
                                <option value="">-- Select Type --</option>
                                <option value="meeting" @selected(old('type') === 'meeting')>Meeting Room</option>
                                <option value="classroom" @selected(old('type') === 'classroom')>Classroom</option>
                                <option value="ballroom" @selected(old('type') === 'ballroom')>Ballroom</option>
                                <option value="lab" @selected(old('type') === 'lab')>Laboratory</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="status" value="Status" />
                            <select
                                id="status"
                                name="status"
                                class="block w-full mt-1 border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                                required
                            >
                                <option value="available" @selected(old('status') === 'available')>Available</option>
                                <option value="unavailable" @selected(old('status') === 'unavailable')>Unavailable</option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" value="Description (Optional)" />
                            <textarea
                                id="description"
                                name="description"
                                rows="3"
                                class="block w-full mt-1 border-gray-300 rounded-md dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                            >{{ old('description', $room->description) }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.rooms.index') }}"
                               class="text-sm text-gray-600 dark:text-gray-400 hover:underline">
                                Cancel
                            </a>

                            <x-primary-button>
                                Save Room
                            </x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
