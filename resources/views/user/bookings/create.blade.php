<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Create Booking
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded shadow dark:bg-gray-900">

                <form method="POST" action="{{ route('user.bookings.store') }}" class="space-y-6">
                    @csrf

                    <!-- Room -->
                    <div>
                        <x-input-label value="Room" />
                        <x-searchable-select
                            name="room_id"
                            placeholder="Select room"
                            :items="$rooms->map(fn($r) => [
                                'id' => $r->id,
                                'label' => $r->room_name . ' (' . $r->location . ')'
                            ])"
                        />
                        <x-input-error :messages="$errors->get('room_id')" />
                    </div>

                    <!-- Booking Date -->
                    <div>
                        <x-input-label for="booking_date" value="Booking Date" />
                        <x-text-input
                            id="booking_date"
                            name="booking_date"
                            type="date"
                            class="w-full"
                            :value="old('booking_date')"
                            required
                        />
                        <x-input-error :messages="$errors->get('booking_date')" />
                    </div>

                    <!-- Start Time -->
                    <div>
                        <x-input-label for="start_time" value="Start Time" />
                        <x-text-input
                            id="start_time"
                            name="start_time"
                            type="time"
                            class="w-full"
                            :value="old('start_time')"
                            required
                        />
                        <x-input-error :messages="$errors->get('start_time')" />
                    </div>

                    <!-- Duration Type -->
                    <div>
                        <x-input-label for="duration_type" value="Duration" />
                        <select
                            id="duration_type"
                            name="duration_type"
                            class="w-full border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required
                        >
                            <option value="">Select duration</option>
                            <option value="6_hours">6 Hours</option>
                            <option value="12_hours">12 Hours</option>
                            <option value="daily">Daily</option>
                        </select>
                        <x-input-error :messages="$errors->get('duration_type')" />
                    </div>

                    <!-- Purpose -->
                    <div>
                        <x-input-label for="purpose" value="Purpose" />
                        <textarea
                            id="purpose"
                            name="purpose"
                            rows="3"
                            class="w-full border-gray-300 rounded dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            required
                        >{{ old('purpose') }}</textarea>
                        <x-input-error :messages="$errors->get('purpose')" />
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end">
                        <x-primary-button>
                            Submit Booking
                        </x-primary-button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
