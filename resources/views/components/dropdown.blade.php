@props(['align' => 'right', 'width' => '40', 'contentClasses' => 'bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm'])

@php
$alignmentClasses = match ($align) {
    'left' => 'left-0',
    'top' => 'top-0 transform -translate-y-full',
    default => 'right-0',
};

$width = match ($width) {
    '25' => 'w-25',
    '35' => 'w-35',
    '42' => 'w-42',
    default => $width,
};
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = !open" class="inline-block">
        {{ $trigger }}
    </div>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-1 {{ $width }} {{ $alignmentClasses }}"
         style="display: none;">
        <div class="{{ $contentClasses }} py-1">
            {{ $content }}
        </div>
    </div>
</div>
