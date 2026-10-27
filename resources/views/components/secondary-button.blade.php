<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-[#d5dee8] rounded-md font-semibold text-xs text-[#52627a] hover:bg-[#f8fafc] focus:outline-none focus:ring-2 focus:ring-[#244b70] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
