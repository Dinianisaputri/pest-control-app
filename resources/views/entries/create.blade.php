<!DOCTYPE html>
<html>
<head>
    <title>Input Harian</title>
</head>
<body>
    @include('partials.nav')
    <h1>Input Harian Pest Control</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red; border: 1px solid red; padding: 10px; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('entries.create') }}">
        <label>Pilih Tanggal:</label>
        <input type="date" name="tanggal" value="{{ $tanggal }}" onchange="this.form.submit()">
        <a href="{{ route('entries.export', ['tanggal' => $tanggal]) }}">📥 Export Excel Tanggal Ini</a>
<br><br>
    </form>

    <form method="POST" action="{{ route('entries.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

        <table border="1" cellpadding="6">
            <tr>
                <th>No. Trap</th>
                <th>Jenis</th>
                <th>Lokasi</th>
                <th>Aktivitas</th>
                <th>Tindakan</th>
                <th>Hasil</th>
                <th>Rekomendasi</th>
                <th>Perbaikan</th>
                <th>Status</th>
            </tr>
            @foreach ($traps as $trap)
                @php
                    $existing = $existingEntries->get($trap->id);
                    $rekom = optional($existing)->rekomendasi;
                    $adaRekomendasi = $rekom && ($rekom->rekomendasi_catatan || $rekom->rekomendasi_gambar);
                    $adaPerbaikan = $rekom && ($rekom->perbaikan_catatan || $rekom->perbaikan_gambar);
                @endphp
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
                        <textarea name="entries[{{ $trap->id }}][rekomendasi_catatan]" rows="2" placeholder="Catatan rekomendasi">{{ optional($rekom)->rekomendasi_catatan }}</textarea>
                        <br>
                        <input type="file" name="entries[{{ $trap->id }}][rekomendasi_gambar]" accept="image/*">
                        @if (optional($rekom)->rekomendasi_gambar)
                            <br><a href="{{ asset('storage/' . $rekom->rekomendasi_gambar) }}" target="_blank">Lihat foto lama</a>
                        @endif
                    </td>
                    <td>
                        <textarea name="entries[{{ $trap->id }}][perbaikan_catatan]" rows="2" placeholder="Catatan perbaikan">{{ optional($rekom)->perbaikan_catatan }}</textarea>
                        <br>
                        <input type="file" name="entries[{{ $trap->id }}][perbaikan_gambar]" accept="image/*">
                        @if (optional($rekom)->perbaikan_gambar)
                            <br><a href="{{ asset('storage/' . $rekom->perbaikan_gambar) }}" target="_blank">Lihat foto lama</a>
                        @endif
                    </td>
                    <td style="text-align:center;">
                        <span title="Rekomendasi" style="display:inline-block; width:14px; height:14px; border-radius:50%; background: {{ $adaRekomendasi ? '#4caf50' : '#f44336' }};"></span>
                        <span title="Perbaikan" style="display:inline-block; width:14px; height:14px; border-radius:50%; background: {{ $adaPerbaikan ? '#4caf50' : '#f44336' }};"></span>
                        <br>
                        <small>R &nbsp; P</small>
                    </td>
                </tr>
            @endforeach
        </table>

        <br>
        <button type="submit">Simpan Semua</button>
    </form>
</body>
</html>