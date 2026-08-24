@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#F4A340] text-start text-base font-medium text-[#0B1F3A] bg-[#fff0d2] focus:outline-none focus:text-[#0B1F3A] focus:bg-[#ffe1ad] focus:border-[#F4A340] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-[#0B1F3A] hover:bg-[#f5f7fa] hover:border-[#cbd6e2] focus:outline-none focus:text-[#0B1F3A] focus:bg-[#f5f7fa] focus:border-[#cbd6e2] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
