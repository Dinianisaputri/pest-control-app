<!DOCTYPE html>
<html>
<head>
    <title>Data Master Trap</title>
</head>
<body>
    @include('partials.nav')
    <h1>Data Master Trap</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (auth()->user()->role === 'admin')
        <a href="{{ route('traps.create') }}">+ Tambah Trap Baru</a>
    @endif

    @foreach ($grouped as $type => $traps)
        <h2>{{ $type }} ({{ $traps->count() }})</h2>
        <table border="1" cellpadding="6">
            <tr>
                <th>No. Trap</th>
                <th>Spesies</th>
                <th>Lokasi</th>
                @if (auth()->user()->role === 'admin')
                    <th>Aksi</th>
                @endif
            </tr>

            @foreach ($traps as $trap)
                <tr>
                    <td>{{ $trap->no_trap }}</td>
                    <td>{{ $trap->spesies_hama }}</td>
                    <td>{{ $trap->lokasi }}</td>
                    @if (auth()->user()->role === 'admin')
                        <td>
                            <a href="{{ route('traps.edit', $trap) }}">Edit</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
        <br>
    @endforeach
</body>
</html>