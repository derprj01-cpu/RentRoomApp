@props(['href' => '#'])

@if($href == '#')
    <button {{ $attributes->merge(['class' => 'w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors']) }}>
        <div class="flex items-center">
            {{ $slot }}
        </div>
    </button>
@else
    <a {{ $attributes->merge(['class' => 'flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors', 'href' => $href]) }}>
        {{ $slot }}
    </a>
@endif
