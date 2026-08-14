<!DOCTYPE html>
<html>
<head>
    <title>Input Harian</title>
</head>
<body>
     @include('partials.nav')
    <h1>Input Harian Pest Control</h1>
    @if ($errors->any())
    <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form method="GET" action="{{ route('entries.create') }}">
        <label>Pilih Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
    </form>
        <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">
        <a href="{{ route('entries.export', ['tanggal' => $tanggal]) }}">📥 Export Excel Tanggal Ini</a>
        <table border="1" cellpadding="6">
            <tr>
                <th>No. Trap</th>
                <th>Jenis</th>
                <th>Lokasi</th>
                <th>Aktivitas</th>
                <th>Tindakan</th>
                <th>Hasil</th>
                <th>Rekomendasi Perbaikan</th>
            </tr>
            @foreach ($traps as $trap)
                @php $existing = $existingEntries->get($trap->id); @endphp
                <tr>
                    <td>{{ $trap->no_trap }}</td>
                    <td>{{ $trap->type_detector }}</td>
                    <td>{{ $trap->lokasi }}</td>
                    <td>
                        <select name="entries[{{ $trap->id }}][aktivitas]">
                            <option value="LOW" {{ optional($existing)->aktivitas == 'LOW' ? 'selected' : '' }}>LOW</option>
                            <option value="MEDIUM" {{ optional($existing)->aktivitas == 'MEDIUM' ? 'selected' : '' }}>MEDIUM</option>
                            <option value="HIGH" {{ optional($existing)->aktivitas == 'HIGH' ? 'selected' : '' }}>HIGH</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="entries[{{ $trap->id }}][tindakan]" value="{{ optional($existing)->tindakan }}">
                    </td>
                    <td>
                        <input type="text" name="entries[{{ $trap->id }}][hasil]" value="{{ optional($existing)->hasil }}">
                    </td>
                    <td>
                    <input type="text" name="entries[{{ $trap->id }}][catatan]" value="{{ optional(optional($existing)->rekomendasi)->catatan }}" placeholder="Catatan perbaikan">
                     <br>
                    <input type="file" name="entries[{{ $trap->id }}][gambar]" accept="image/*">
                    </td>
                </tr>
            @endforeach
        </table>

        <br>
        <button type="submit">Simpan Semua</button>
    </form>
</body>
</html>