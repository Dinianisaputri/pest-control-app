<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-[#cbd6e2] rounded-md font-semibold text-xs text-[#0B1F3A] uppercase tracking-widest shadow-sm hover:bg-[#f5f7fa] focus:outline-none focus:ring-2 focus:ring-[#F4A340] focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
