<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#244b70] border border-transparent rounded-md font-semibold text-xs text-white hover:bg-[#1b3c5b] focus:bg-[#1b3c5b] active:bg-[#172b4d] focus:outline-none focus:ring-2 focus:ring-[#244b70] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
