<!DOCTYPE html>
<html>
<head>
    <title>Riwayat</title>
</head>
<body>
    @include('partials.nav')
    <h1>Riwayat Pest Control</h1>

    <form method="GET" action="{{ route('entries.riwayat') }}">
        <label>Pilih Tanggal:</label>
        <select name="tanggal" onchange="this.form.submit()">
            @foreach ($tanggalList as $t)
                <option value="{{ $t }}" {{ $t == $tanggalDipilih ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </form>

    @if ($tanggalDipilih)
        <a href="{{ route('entries.export', ['tanggal' => $tanggalDipilih]) }}">📥 Export Excel Tanggal Ini</a>
        <a href="{{ route('entries.riwayat') }}" style="color: white; margin-right: 15px; text-decoration: none;">Riwayat</a>
    @endif

    <br><br>

    <table border="1" cellpadding="6">
        <tr>
            <th>No. Trap</th>
            <th>Jenis</th>
            <th>Lokasi</th>
            <th>Aktivitas</th>
            <th>Tindakan</th>
            <th>Hasil</th>
            <th>Rekomendasi</th>
            <th>Foto</th>
        </tr>
        @foreach ($traps as $trap)
            @php $entry = $trap->entries->first(); @endphp
            <tr>
                <td>{{ $trap->no_trap }}</td>
                <td>{{ $trap->type_detector }}</td>
                <td>{{ $trap->lokasi }}</td>
                <td>{{ optional($entry)->aktivitas ?? '-' }}</td>
                <td>{{ optional($entry)->tindakan ?? '-' }}</td>
                <td>{{ optional($entry)->hasil ?? '-' }}</td>
                <td>{{ optional(optional($entry)->rekomendasi)->catatan ?? '-' }}</td>
                <td>
                    @if (optional($entry)->rekomendasi && $entry->rekomendasi->gambar)
                        <a href="{{ asset('storage/' . $entry->rekomendasi->gambar) }}" target="_blank">Lihat Foto</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>