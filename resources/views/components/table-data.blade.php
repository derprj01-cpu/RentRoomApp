@props([
    'headers' => [],
    'sortable' => []
])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-800">
             <tr>
                @foreach ($headers as $key => $label)
                    @php
                        $isSortable = in_array($key, $sortable);
                        $isSorted = request('sort') == $key;
                        $sortDirection = request('direction', 'asc');
                    @endphp

                    <th
                        class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider dark:text-gray-400 {{ $isSortable ? 'cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700' : '' }}"
                        @if($isSortable)
                            data-sort="{{ $key }}"
                        @endif
                    >
                        <div class="flex items-center">
                            {{ $label }}
                            @if($isSorted)
                                <span class="ml-1">
                                    @if($sortDirection === 'asc')
                                        ↑
                                    @else
                                        ↓
                                    @endif
                                </span>
                            @elseif($isSortable)
                                <span class="ml-1 text-gray-400">↕</span>
                            @endif
                        </div>
                    </th>
                @endforeach
            </tr>
        </thead>

        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            {{ $slot }}
        </tbody>
    </table>
</div>
