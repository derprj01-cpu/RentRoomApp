<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                    Bookings Management
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Manage all bookings in the system
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Bar -->
            <div class="mb-4 p-4 bg-white text-gray-900 dark:text-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex flex-col md:flex-row md:items-center gap-3">
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
                                id="booking-search"
                                placeholder="Search by user, room, purpose..."
                                value="{{ request('search') }}"
                                class="pl-10 w-full p-2.5 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-600"
                            >
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <!-- Status Filter -->
                        <select id="status-filter"
                            class="p-2.5 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-600">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <!-- Type Filter -->
                        <select id="type-filter"
                            class="p-2.5 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-600">
                            <option value="">All Types</option>
                            <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>Meeting</option>
                            <option value="classroom" {{ request('type') == 'classroom' ? 'selected' : '' }}>Classroom</option>
                            <option value="lab" {{ request('type') == 'lab' ? 'selected' : '' }}>Lab</option>
                            <option value="ballroom" {{ request('type') == 'ballroom' ? 'selected' : '' }}>Ballroom</option>
                        </select>

                        <!-- Date Filter -->
                        <input
                            type="date"
                            id="date-filter"
                            value="{{ request('date') }}"
                            class="p-2.5 border border-gray-300 dark:border-gray-700 rounded bg-white dark:bg-gray-900 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-600"
                        >

                        <!-- Clear Filters -->
                        <button onclick="clearFilters()"
                                class="px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- RESULTS -->
            <div id="bookings-results" class="bg-white dark:bg-gray-800 rounded border border-gray-200 dark:border-gray-700">
                @include('admin.bookings.partials.results', ['bookings' => $bookings])
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        let debounceTimer = null;
        let currentSort = '{{ request("sort", "created_at") }}';
        let currentDirection = '{{ request("direction", "desc") }}';

        const searchInput = document.getElementById('booking-search');
        const statusFilter = document.getElementById('status-filter');
        const typeFilter = document.getElementById('type-filter');
        const dateFilter = document.getElementById('date-filter');
        const resultsDiv = document.getElementById('bookings-results');

        // Event listeners
        searchInput.addEventListener('input', reloadBookings);
        statusFilter.addEventListener('change', reloadBookings);
        typeFilter.addEventListener('change', reloadBookings);
        dateFilter.addEventListener('change', reloadBookings);

        function reloadBookings() {
            clearTimeout(debounceTimer);

            // Show loading
            resultsDiv.innerHTML = `
                <div class="p-8 text-center text-gray-500">
                    <div class="inline-block animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent mb-2"></div>
                    <p class="text-sm">Loading bookings...</p>
                </div>
            `;

            debounceTimer = setTimeout(() => {
                fetchBookings(
                    searchInput.value,
                    statusFilter.value,
                    typeFilter.value,
                    dateFilter.value,
                    currentSort,
                    currentDirection
                );
            }, 400);
        }

        function clearFilters() {
            searchInput.value = '';
            statusFilter.value = '';
            typeFilter.value = '';
            dateFilter.value = '';
            currentSort = 'created_at';
            currentDirection = 'desc';
            reloadBookings();

            // Clear URL params
            const url = new URL(window.location.href);
            url.search = '';
            window.history.pushState({}, '', url);
        }

        function fetchBookings(search = '', status = '', type = '', date = '', sort = '', direction = '') {
            const url = new URL("{{ route('admin.bookings.index') }}");

            if (search) url.searchParams.set('search', search);
            if (status) url.searchParams.set('status', status);
            if (type) url.searchParams.set('type', type);
            if (date) url.searchParams.set('date', date);
            if (sort) url.searchParams.set('sort', sort);
            if (direction) url.searchParams.set('direction', direction);

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                resultsDiv.innerHTML = data.html;

                // Update URL without reloading
                const newUrl = new URL(window.location.href);
                newUrl.search = url.searchParams.toString();
                window.history.pushState({}, '', newUrl);

                // Update current sort and direction
                const urlParams = new URLSearchParams(newUrl.search);
                currentSort = urlParams.get('sort') || 'created_at';
                currentDirection = urlParams.get('direction') || 'desc';
            })
            .catch(error => {
                console.error('Error:', error);
                resultsDiv.innerHTML = `
                    <div class="p-8 text-center text-red-500 text-sm">
                        Error loading bookings
                    </div>
                `;
            });
        }

        // Sort functionality
        document.addEventListener('click', function (e) {
            const th = e.target.closest('th[data-sort]');
            if (!th) return;

            e.preventDefault();
            const sort = th.dataset.sort;

            // Toggle direction if same column
            if (currentSort === sort) {
                currentDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            } else {
                currentDirection = 'asc';
            }

            currentSort = sort;

            fetchBookings(
                searchInput.value,
                statusFilter.value,
                typeFilter.value,
                dateFilter.value,
                currentSort,
                currentDirection
            );
        });

        // Pagination with AJAX
        resultsDiv.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link || !link.href.includes('page=')) return;

            e.preventDefault();

            // Get page number from URL
            const url = new URL(link.href);
            const page = url.searchParams.get('page');

            if (!page) return;

            // Build new URL with current filters
            const fetchUrl = new URL("{{ route('admin.bookings.index') }}");
            fetchUrl.searchParams.set('page', page);

            if (searchInput.value) fetchUrl.searchParams.set('search', searchInput.value);
            if (statusFilter.value) fetchUrl.searchParams.set('status', statusFilter.value);
            if (typeFilter.value) fetchUrl.searchParams.set('type', typeFilter.value);
            if (dateFilter.value) fetchUrl.searchParams.set('date', dateFilter.value);
            if (currentSort) {
                fetchUrl.searchParams.set('sort', currentSort);
                fetchUrl.searchParams.set('direction', currentDirection);
            }

            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => resultsDiv.innerHTML = data.html);
        });

        // Initialize with current filters
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) searchInput.value = urlParams.get('search');
            if (urlParams.has('status')) statusFilter.value = urlParams.get('status');
            if (urlParams.has('type')) typeFilter.value = urlParams.get('type');
            if (urlParams.has('date')) dateFilter.value = urlParams.get('date');
            if (urlParams.has('sort')) currentSort = urlParams.get('sort');
            if (urlParams.has('direction')) currentDirection = urlParams.get('direction');
        });
    </script>
    @endpush
</x-app-layout>
