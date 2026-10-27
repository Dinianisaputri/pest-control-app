@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg px-3 py-2 text-start text-sm font-semibold text-[#244b70] bg-[#edf3f8] focus:outline-none focus:ring-2 focus:ring-[#244b70]/20 transition duration-150 ease-in-out'
            : 'block w-full rounded-lg px-3 py-2 text-start text-sm font-medium text-gray-600 hover:text-[#172b4d] hover:bg-[#f1f5f9] focus:outline-none focus:ring-2 focus:ring-[#244b70]/20 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
