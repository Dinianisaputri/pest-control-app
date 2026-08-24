@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#F4A340] text-sm font-medium leading-5 text-[#0B1F3A] focus:outline-none focus:border-[#F4A340] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-[#0B1F3A] hover:border-[#cbd6e2] focus:outline-none focus:text-[#0B1F3A] focus:border-[#cbd6e2] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
