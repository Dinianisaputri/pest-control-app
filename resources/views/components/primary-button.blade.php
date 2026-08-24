<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#F4A340] border border-transparent rounded-md font-semibold text-xs text-[#0B1F3A] uppercase tracking-widest hover:bg-[#f7b65d] focus:bg-[#f7b65d] active:bg-[#df8f2c] focus:outline-none focus:ring-2 focus:ring-[#F4A340] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
