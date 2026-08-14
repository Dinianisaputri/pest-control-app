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
            <th>Catatan Rekomendasi</th>
            <th>Foto Rekomendasi</th>
            <th>Catatan Perbaikan</th>
            <th>Foto Perbaikan</th>
        </tr>
        @foreach ($traps as $trap)
            @php
                $entry = $trap->entries->first();
                $rekom = optional($entry)->rekomendasi;
            @endphp
            <tr>
                <td>{{ $trap->no_trap }}</td>
                <td>{{ $trap->type_detector }}</td>
                <td>{{ $trap->lokasi }}</td>
                <td>{{ optional($entry)->aktivitas ?? '-' }}</td>
                <td>{{ optional($entry)->tindakan ?? '-' }}</td>
                <td>{{ optional($entry)->hasil ?? '-' }}</td>
                <td>{{ optional($rekom)->rekomendasi_catatan ?? '-' }}</td>
                <td>
                    @if (optional($rekom)->rekomendasi_gambar)
                        <a href="{{ asset('storage/' . $rekom->rekomendasi_gambar) }}" target="_blank">Lihat Foto</a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ optional($rekom)->perbaikan_catatan ?? '-' }}</td>
                <td>
                    @if (optional($rekom)->perbaikan_gambar)
                        <a href="{{ asset('storage/' . $rekom->perbaikan_gambar) }}" target="_blank">Lihat Foto</a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>