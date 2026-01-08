<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Rooms Management
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage all rooms in the system
                </p>
            </div>

            <x-primary-button class="text-sm py-2">
                <a href="{{ route('admin.rooms.create') }}" class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Room
                </a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Simple Filter Bar -->
            <div class="mb-4 space-y-3">
                <!-- Search -->
                <div class="relative">
                    <!-- Search and Filter Bar -->
                    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center gap-4">
                            <!-- Search -->
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input
                                        type="search"
                                        id="room-search"
                                        placeholder="Search rooms..."
                                        value="{{ request('search') }}"
                                        class="pl-10 w-full p-2.5 borde text-gray-600 dark:text-gray-400 border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600"
                                    >
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="flex items-center gap-3">
                                <select id="status-filter"  
                                    class="p-2.5 pr-7 border border-gray-300 text-gray-600 dark:text-gray-400 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600">
                                    <option value="">All Status</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                                </select>

                                <!-- Clear Filters Button -->
                                <button onclick="clearFilters()" class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300">
                                    Clear
                                </button>
                            </div>
                        </div>
                </div>


            </div>

            <!-- RESULTS -->
            <div id="rooms-results" class="bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700">
                @include('admin.rooms.partials.results', ['rooms' => $rooms])
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        let debounceTimer = null;
        let currentSort = '';
        let currentDirection = 'asc';

        const searchInput = document.getElementById('room-search');
        const statusFilter = document.getElementById('status-filter');
        const resultsDiv = document.getElementById('rooms-results');

        searchInput.addEventListener('input', reloadRooms);
        statusFilter.addEventListener('change', reloadRooms);

        function reloadRooms() {
            clearTimeout(debounceTimer);

            // Show loading
            resultsDiv.innerHTML = `
                <div class="p-8 text-center text-gray-500">
                    <div class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent mb-2"></div>
                    <p class="text-sm">Loading...</p>
                </div>
            `;

            debounceTimer = setTimeout(() => {
                fetchRooms(
                    searchInput.value,
                    statusFilter.value,
                    currentSort,
                    currentDirection
                );
            }, 400);
        }

        function clearFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            reloadRooms();
            window.history.pushState({}, '', '{{ route('admin.rooms.index') }}');
        }

        function fetchRooms(search = '', status = '', sort = '', direction = '') {
            const url = new URL("{{ route('admin.rooms.index') }}");

            if (search) url.searchParams.set('search', search);
            if (status) url.searchParams.set('status', status);
            if (sort) url.searchParams.set('sort', sort);
            if (direction) url.searchParams.set('direction', direction);

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                resultsDiv.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                resultsDiv.innerHTML = `
                    <div class="p-8 text-center text-red-500 text-sm">
                        Error loading data
                    </div>
                `;
            });
        }

        // Sort functionality
        document.addEventListener('click', function (e) {
            const th = e.target.closest('th[data-sort]');
            if (!th) return;

            const sort = th.dataset.sort;
            currentDirection = (currentSort === sort && currentDirection === 'asc') ? 'desc' : 'asc';
            currentSort = sort;

            fetchRooms(searchInput.value, statusFilter.value, currentSort, currentDirection);
        });

        // Pagination
        document.addEventListener('click', function (e) {
            const link = e.target.closest('.pagination a');
            if (!link) return;

            e.preventDefault();
            const url = new URL(link.href);

            url.searchParams.set('search', searchInput.value);
            url.searchParams.set('status', statusFilter.value);
            url.searchParams.set('sort', currentSort);
            url.searchParams.set('direction', currentDirection);

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => resultsDiv.innerHTML = html);
        });

        // Initialize with current filters
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) searchInput.value = urlParams.get('search');
        if (urlParams.has('status')) statusFilter.value = urlParams.get('status');
    </script>
    @endpush
</x-app-layout>
