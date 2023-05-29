@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-100 text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md transition duration-150 ease-in-out'
            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-base font-medium rounded-md transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
