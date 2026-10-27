@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-lg bg-[#edf3f8] text-sm font-semibold leading-5 text-[#244b70] focus:outline-none focus:ring-2 focus:ring-[#244b70]/20 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium leading-5 text-gray-600 hover:text-[#172b4d] hover:bg-[#f1f5f9] focus:outline-none focus:ring-2 focus:ring-[#244b70]/20 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
