@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#cbd6e2] focus:border-[#F4A340] focus:ring-[#F4A340] rounded-md shadow-sm']) }}>
