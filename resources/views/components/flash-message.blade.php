@props(['type' => 'success'])

@php
    $baseClasses = 'flex items-start justify-between p-4 mb-4 rounded-lg border text-sm';

    $variants = [
        'success' => 'bg-green-50 border-green-300 text-green-800 dark:bg-green-900/30 dark:border-green-700 dark:text-green-300',
        'error'   => 'bg-red-50 border-red-300 text-red-800 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300',
        'warning' => 'bg-yellow-50 border-yellow-300 text-yellow-800 dark:bg-yellow-900/30 dark:border-yellow-700 dark:text-yellow-300',
        'info'    => 'bg-blue-50 border-blue-300 text-blue-800 dark:bg-blue-900/30 dark:border-blue-700 dark:text-blue-300',
    ];

    $classes = $variants[$type] ?? $variants['success'];
@endphp 

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    class="{{ $baseClasses }} {{ $classes }}"
>
    <div>
        {{ $slot }}
    </div>

    <button
        type="button"
        @click="show = false"
        class="ml-4 font-bold opacity-60 hover:opacity-100"
        aria-label="Close"
    >
        ×
    </button>
</div>
