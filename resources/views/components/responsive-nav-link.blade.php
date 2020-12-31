@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-white text-base font-medium text-white focus:outline-none focus:text-white focus:bg-gray-600 focus:border-gray-600 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:text-white hover:bg-gray-600 hover:border-white focus:outline-none focus:text-white focus:bg-gray-600 focus:border-white transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
