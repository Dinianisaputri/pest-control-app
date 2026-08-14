<nav style="background: #1e3a5f; padding: 12px 20px; margin-bottom: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
        <div>
            <a href="{{ route('dashboard') }}" style="color: white; margin-right: 15px; text-decoration: none;">Dashboard</a>
            <a href="{{ route('traps.index') }}" style="color: white; margin-right: 15px; text-decoration: none;">Data Master</a>
            <a href="{{ route('entries.create') }}" style="color: white; margin-right: 15px; text-decoration: none;">Input Harian</a>
            <a href="{{ route('entries.riwayat') }}" style="color: white; margin-right: 15px; text-decoration: none;">Riwayat</a>
        </div>
        <div style="color: white;">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #ffcccc; cursor: pointer; margin-left: 10px;">Logout</button>
            </form>
        </div>
    </div>
</nav>