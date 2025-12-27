@props([
    'items' => [],
    'name',
    'placeholder' => 'Select option',
    'label' => null,
])

<div
    x-data="{
        open: false,
        search: '',
        selectedId: null,
        selectedLabel: '',
        items: {{ Js::from($items) }},
        filtered() {
            return this.items.filter(i =>
                i.label.toLowerCase().includes(this.search.toLowerCase())
            )
        }
    }"
    class="relative"
>
    @if($label)
        <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <!-- Hidden input -->
    <input type="hidden" name="{{ $name }}" :value="selectedId">

    <!-- Trigger -->
    <button
        type="button"
        @click="open = !open"
        class="w-full px-3 py-2 text-left bg-white border rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700"
    >
        <span x-text="selectedLabel || '{{ $placeholder }}'"></span>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        @click.outside="open = false"
        class="absolute z-50 w-full mt-1 bg-white border rounded-md shadow dark:bg-gray-900 dark:text-gray-300 dark:border-gray-700"
    >
        <!-- Search -->
        <input
            type="text"
            x-model="search"
            placeholder="Search..."
            class="w-full px-3 py-2 text-sm border-b dark:bg-gray-900 dark:border-gray-700"
        >

        <!-- Items -->
        <ul class="overflow-y-auto max-h-60">
            <template x-for="item in filtered()" :key="item.id">
                <li
                    @click="
                        selectedId = item.id;
                        selectedLabel = item.label;
                        open = false;
                        search = '';
                    "
                    class="px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800"
                    x-text="item.label"
                ></li>
            </template>

            <li
                x-show="filtered().length === 0"
                class="px-3 py-2 text-sm text-gray-500"
            >
                No results found
            </li>
        </ul>
    </div>
</div>
