@php
    $role = auth()->user()?->role;
    $isAdmin = $role === 'admin';
    $isPetugas = in_array($role, ['pengelola', 'operatorpc'], true);
@endphp

<nav x-data="{ open: false, desktopInspectionsOpen: false, mobileInspectionsOpen: false }" class="main-nav">
    <div class="main-nav__inner">
        <a href="{{ route('dashboard') }}" class="main-nav__brand" aria-label="Dashboard Pest Control">
            <img src="{{ asset('images/logo.png') }}" alt="Starfood International">
        </a>

        <div class="main-nav__links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @if ($isAdmin)
                <a href="{{ route('traps.index') }}" class="nav-link {{ request()->routeIs('traps.*') ? 'active' : '' }}">Data Master Perangkap</a>
            @endif
            @if ($isPetugas)
                <a href="{{ route('entries.create') }}" class="nav-link {{ request()->routeIs('entries.create') ? 'active' : '' }}">Input Harian</a>
            @endif
            <div class="main-nav__dropdown" @click.outside="desktopInspectionsOpen = false" @keydown.escape.window="desktopInspectionsOpen = false">
                <button
                    type="button"
                    class="nav-link main-nav__dropdown-trigger {{ request()->routeIs('entries.kalender', 'entries.riwayat') ? 'active' : '' }}"
                    @click="desktopInspectionsOpen = !desktopInspectionsOpen"
                    :aria-expanded="desktopInspectionsOpen.toString()"
                    aria-haspopup="true"
                >
                    Inspeksi
                    <svg class="main-nav__chevron" :class="{ 'is-open': desktopInspectionsOpen }" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="main-nav__dropdown-menu" x-show="desktopInspectionsOpen" x-transition.origin.top.left x-cloak>
                    <a href="{{ route('entries.kalender') }}" class="main-nav__dropdown-link {{ request()->routeIs('entries.kalender') ? 'active' : '' }}">Kalender Inspeksi</a>
                    <a href="{{ route('entries.riwayat') }}" class="main-nav__dropdown-link {{ request()->routeIs('entries.riwayat') ? 'active' : '' }}">Riwayat Bulanan</a>
                </div>
            </div>
        </div>

        <div class="main-nav__actions">
            <div class="main-nav__user">
                <span class="main-nav__avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                <span>
                    <span class="main-nav__user-name">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="main-nav__user-role">{{ auth()->user()->role ?? 'User' }}</span>
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="main-nav__logout-form">
                @csrf
                <button type="submit" class="main-nav__logout">Keluar</button>
            </form>

            <button
                type="button"
                class="main-nav__toggle"
                @click="open = !open"
                :aria-expanded="open.toString()"
                :aria-label="open ? 'Tutup navigasi' : 'Buka navigasi'"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path :class="{ 'hidden': open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
    </div>

    <div class="main-nav__mobile" :class="{ 'is-open': open }" x-cloak>
        <div class="main-nav__mobile-links">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            @if ($isAdmin)
                <a href="{{ route('traps.index') }}" class="nav-link {{ request()->routeIs('traps.*') ? 'active' : '' }}">Data Master Perangkap</a>
            @endif
            @if ($isPetugas)
                <a href="{{ route('entries.create') }}" class="nav-link {{ request()->routeIs('entries.create') ? 'active' : '' }}">Input Harian</a>
            @endif
            <div class="main-nav__mobile-group">
                <button
                    type="button"
                    class="nav-link main-nav__mobile-disclosure {{ request()->routeIs('entries.kalender', 'entries.riwayat') ? 'active' : '' }}"
                    @click="mobileInspectionsOpen = !mobileInspectionsOpen"
                    :aria-expanded="mobileInspectionsOpen.toString()"
                >
                    Inspeksi
                    <svg class="main-nav__chevron" :class="{ 'is-open': mobileInspectionsOpen }" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <div class="main-nav__mobile-submenu" x-show="mobileInspectionsOpen" x-cloak>
                    <a href="{{ route('entries.kalender') }}" class="nav-link {{ request()->routeIs('entries.kalender') ? 'active' : '' }}">Kalender Inspeksi</a>
                    <a href="{{ route('entries.riwayat') }}" class="nav-link {{ request()->routeIs('entries.riwayat') ? 'active' : '' }}">Riwayat Bulanan</a>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="main-nav__logout">Keluar dari akun</button>
            </form>
        </div>
    </div>
</nav>
