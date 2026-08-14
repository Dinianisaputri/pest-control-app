<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-800 bg-slate-950/95 shadow-lg shadow-slate-900/10 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Starfood International" class="h-10 w-auto" />
                </a>
            </div>

            <div class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('traps.index') }}" class="nav-link {{ request()->routeIs('traps.*') ? 'active' : '' }}">
                    Data Master
                </a>
                <a href="{{ route('entries.create') }}" class="nav-link {{ request()->routeIs('entries.create') ? 'active' : '' }}">
                    Input Harian
                </a>
                <a href="{{ route('entries.riwayat') }}" class="nav-link {{ request()->routeIs('entries.riwayat') ? 'active' : '' }}">
                    Riwayat
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden items-center gap-3 rounded-xl border border-slate-800 bg-slate-900/80 px-3 py-2 text-right sm:flex">
                    <div class="h-8 w-8 rounded-full bg-cyan-500/15 text-center text-xs font-bold leading-8 text-cyan-300">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-white">{{ auth()->user()->name ?? 'User' }}</div>
                        <div class="text-[11px] text-slate-400">{{ auth()->user()->role ?? 'User' }}</div>
                    </div>
                </div>

                <button type="button" @click="open = !open" class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900 p-2 text-slate-200 transition hover:border-slate-600 hover:text-white lg:hidden">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-flex">
                    @csrf
                    <button type="submit" class="rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm font-medium text-slate-200 transition hover:border-slate-600 hover:text-white">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-800 bg-slate-950/95 lg:hidden">
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-3 sm:px-6">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }} block w-full justify-start">
                Dashboard
            </a>
            <a href="{{ route('traps.index') }}" class="nav-link {{ request()->routeIs('traps.*') ? 'active' : '' }} block w-full justify-start">
                Data Master
            </a>
            <a href="{{ route('entries.create') }}" class="nav-link {{ request()->routeIs('entries.create') ? 'active' : '' }} block w-full justify-start">
                Input Harian
            </a>
            <a href="{{ route('entries.riwayat') }}" class="nav-link {{ request()->routeIs('entries.riwayat') ? 'active' : '' }} block w-full justify-start">
                Riwayat
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block w-full">
                @csrf
                <button type="submit" class="nav-link block w-full justify-start text-slate-200">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>