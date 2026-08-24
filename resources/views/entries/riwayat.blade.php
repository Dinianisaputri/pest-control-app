<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div>
                <p class="page-kicker">History</p>
                <h1 class="page-title">Riwayat Pest Control</h1>
            </div>
            @if ($tanggalDipilih)
                <a href="{{ route('entries.export', ['tanggal' => $tanggalDipilih]) }}" class="btn-secondary">
                    Export Excel
                </a>
            @endif
        </header>

        <section class="form-card mb-6">
            <form method="GET" action="{{ route('entries.riwayat') }}" class="flex flex-col gap-3 md:flex-row md:items-end">
                <div class="w-full md:max-w-xs">
                    <label for="tanggal" class="field-label">Pilih Tanggal</label>
                    <select id="tanggal" name="tanggal" class="select" onchange="this.form.submit()">
                        @foreach ($tanggalList as $t)
                            <option value="{{ $t }}" {{ $t == $tanggalDipilih ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h2 class="panel-title">Data hasil inspeksi</h2>
                <span class="badge badge-neutral">{{ $tanggalDipilih }}</span>
            </div>

            <div class="table-wrapper p-3 sm:p-5">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Trap</th>
                            <th>Jenis</th>
                            <th>Lokasi</th>
                            <th>Aktivitas</th>
                            <th>Tindakan</th>
                            <th>Hasil</th>
                            <th>Rekomendasi</th>
                            <th>Foto Rekomendasi</th>
                            <th>Perbaikan</th>
                            <th>Foto Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($traps as $trap)
                            @php
                                $entry = $trap->entries->first();
                                $rekom = optional($entry)->rekomendasi;
                            @endphp
                            <tr>
                                <td><span class="font-semibold text-slate-700">{{ $trap->no_trap }}</span></td>
                                <td>{{ $trap->type_detector }}</td>
                                <td>{{ $trap->lokasi }}</td>
                                <td>
                                    @php
                                        $activity = optional($entry)->aktivitas ?? '-';
                                        $activityClass = match($activity) {
                                            'LOW' => 'success',
                                            'MEDIUM' => 'warning',
                                            'HIGH' => 'danger',
                                            default => 'neutral',
                                        };
                                    @endphp
                                    <span class="status-pill {{ $activityClass }}">{{ $activity }}</span>
                                </td>
                                <td>{{ optional($entry)->tindakan ?? '-' }}</td>
                                <td>{{ optional($entry)->hasil ?? '-' }}</td>
                                <td>{{ optional($rekom)->rekomendasi_catatan ?? '-' }}</td>
                                <td>
                                    @if (optional($rekom)->rekomendasi_gambar)
                                        <a href="{{ route('photo.file', ['path' => $rekom->rekomendasi_gambar]) }}" target="_blank" class="text-[#1d527d] hover:underline">Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ optional($rekom)->perbaikan_catatan ?? '-' }}</td>
                                <td>
                                    @if (optional($rekom)->perbaikan_gambar)
                                        <a href="{{ route('photo.file', ['path' => $rekom->perbaikan_gambar]) }}" target="_blank" class="text-[#1d527d] hover:underline">Lihat Foto</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>