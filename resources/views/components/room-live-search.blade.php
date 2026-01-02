@props([
    'placeholder' => 'Search rooms...',
    'value' => '',
    'searchUrl' => '', // This will be the main index route
])

<div
    x-data="{
        query: '{{ addslashes($value) }}',
        results: [],
        loading: false,
        searchTimer: null,
        isOpen: false,

        searchRooms() {
            clearTimeout(this.searchTimer);

            if (this.query.length === 0) {
                this.results = [];
                this.isOpen = false;
                return;
            }

            if (this.query.length < 2) {
                this.isOpen = false;
                return;
            }

            this.loading = true;
            this.isOpen = true;

            this.searchTimer = setTimeout(() => {
                fetch('{{ $searchUrl }}?search=' + encodeURIComponent(this.query), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.results = data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Search error:', error);
                    this.results = [];
                    this.loading = false;
                });
            }, 300);
        },

        resetSearch() {
            this.query = '';
            this.results = [];
            this.isOpen = false;
            updateResults(''); // Update main results with empty search
        },

        submitForm() {
            if (this.query.trim()) {
                updateResults(this.query);
                this.isOpen = false;
            }
        }
    }"
    x-init="if (query && query.length >= 2) searchRooms()"
    {{ $attributes->merge(['class' => 'relative room-live-search']) }}
    @click.away="isOpen = false"
>
    <!-- Search Form -->
    <div class="relative">
        <!-- Search Icon -->
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        <!-- Search Input -->
        <input
            x-ref="searchInput"
            type="search"
            x-model="query"
            @input.debounce.300ms="searchRooms()"
            @keyup.enter="submitForm()"
            @focus="if (query.length >= 2) searchRooms()"
            class="w-full py-2 pl-10 pr-10 text-sm border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
        >

        <!-- Loading Spinner -->
        <div x-show="loading" class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="w-4 h-4 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <!-- Clear Button -->
        <button
            x-show="query && !loading"
            @click="resetSearch()"
            type="button"
            class="absolute inset-y-0 right-0 flex items-center pr-3"
        >
            <svg class="w-4 h-4 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Results Dropdown -->
    <div
        x-show="isOpen && results.length > 0"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700"
        style="max-height: 400px; overflow-y: auto;"
    >
        <div class="py-2">
            <template x-for="room in results" :key="room.id">
                <a
                    :href="room.show_url"
                    @click.prevent="window.location.href = room.show_url"
                    class="flex items-center px-4 py-3 border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700 last:border-b-0"
                >
                    <div class="flex-shrink-0 mr-3">
                        <div class="flex items-center justify-center w-10 h-10 text-white bg-blue-500 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h4 class="font-medium text-gray-900 dark:text-white" x-text="room.room_name"></h4>
                            <span class="px-2 py-1 text-xs rounded-full"
                                  :class="{
                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': room.status === 'available',
                                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': room.status !== 'available'
                                  }"
                                  x-text="room.status ? room.status.charAt(0).toUpperCase() + room.status.slice(1) : ''">
                            </span>
                        </div>
                        <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span x-text="room.location || 'Unknown'"></span>
                            <span class="mx-2">•</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span x-text="room.capacity || 'N/A'"></span>
                        </div>
                    </div>
                </a>
            </template>

            <!-- View All Results Link -->
            <div x-show="results.length > 0" class="p-3 border-t border-gray-100 dark:border-gray-700">
                <a
                    @click.prevent="submitForm()"
                    class="block w-full py-2 text-sm font-medium text-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 cursor-pointer"
                >
                    View all results for "<span x-text="query"></span>"
                </a>
            </div>
        </div>
    </div>
</div>
