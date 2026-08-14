<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    @include('partials.nav')

    <h1>Dashboard Pest Control</h1>
    <p>{{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}</p>

    <table border="1" cellpadding="10">
        <tr>
            <td><strong>Total Trap</strong><br>{{ $totalTraps }}</td>
            <td><strong>Terisi Hari Ini</strong><br>{{ $filled }} / {{ $totalTraps }}</td>
            <td><strong>Medium/High Hari Ini</strong><br>{{ $dist['MEDIUM'] + $dist['HIGH'] }}</td>
            <td><strong>Hari Tercatat</strong><br>{{ $totalHariTercatat }}</td>
        </tr>
    </table>

    <br>

    <h3>Trap per Jenis Detector</h3>
    <table border="1" cellpadding="6">
        <tr><th>Jenis</th><th>Jumlah</th></tr>
        @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
            <tr>
                <td>{{ $type }}</td>
                <td>{{ $typeCounts[$type] ?? 0 }}</td>
            </tr>
        @endforeach
    </table>

    <br>

    <h3>Status Board Hari Ini</h3>
    @if ($filled === 0)
        <p>Belum ada input untuk hari ini.</p>
    @else
        <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 500px;">
            @foreach ($todayEntries as $entry)
                @php
                    $color = match($entry->aktivitas) {
                        'LOW' => '#4caf50',
                        'MEDIUM' => '#ff9800',
                        'HIGH' => '#f44336',
                        default => '#ccc',
                    };
                @endphp
                <div title="Trap #{{ $entry->trap_id }} - {{ $entry->aktivitas }}" style="width: 16px; height: 16px; background: {{ $color }};"></div>
            @endforeach
        </div>
        <p style="margin-top: 10px;">
            <span style="color: #4caf50;">■</span> LOW &nbsp;
            <span style="color: #ff9800;">■</span> MEDIUM &nbsp;
            <span style="color: #f44336;">■</span> HIGH
        </p>
    @endif
</body>
</html>