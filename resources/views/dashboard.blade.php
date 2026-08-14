<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div>
                <p class="page-kicker">Overview</p>
                <h1 class="page-title">Dashboard Pest Control</h1>
            </div>
            <div class="inline-flex items-center rounded-full border border-cyan-200 bg-cyan-50 px-3 py-2 text-sm font-medium text-cyan-700">
                {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}
            </div>
        </header>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="stat-card">
                <div class="stat-label">Total Trap</div>
                <div class="stat-value">{{ $totalTraps }}</div>
                <div class="stat-meta">Seluruh titik monitoring</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Terisi Hari Ini</div>
                <div class="stat-value">{{ $filled }}</div>
                <div class="stat-meta">{{ $filled }} / {{ $totalTraps }} trap</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Medium / High</div>
                <div class="stat-value">{{ $dist['MEDIUM'] + $dist['HIGH'] }}</div>
                <div class="stat-meta">Kebutuhan perhatian</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Hari Tercatat</div>
                <div class="stat-value">{{ $totalHariTercatat }}</div>
                <div class="stat-meta">Data aktif tersedia</div>
            </div>
        </section>

        <div class="mt-8 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <section class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Trap per Jenis Detector</h2>
                    <span class="badge badge-neutral">{{ count($typeCounts) }} jenis</span>
                </div>
                <div class="table-wrapper p-3 sm:p-5">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Jenis</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
                                <tr>
                                    <td>{{ $type }}</td>
                                    <td>
                                        <span class="badge badge-neutral">{{ $typeCounts[$type] ?? 0 }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Status Board Hari Ini</h2>
                </div>
                <div class="p-5">
                    @if ($filled === 0)
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                            Belum ada input untuk hari ini.
                        </div>
                    @else
                        <div class="flex flex-wrap gap-2 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            @foreach ($todayEntries as $entry)
                                @php
                                    $color = match($entry->aktivitas) {
                                        'LOW' => '#10b981',
                                        'MEDIUM' => '#f59e0b',
                                        'HIGH' => '#ef4444',
                                        default => '#94a3b8',
                                    };
                                @endphp
                                <div title="Trap #{{ $entry->trap_id }} - {{ $entry->aktivitas }}" class="h-5 w-5 rounded-md border border-white shadow-sm" style="background: {{ $color }};"></div>
                            @endforeach
                        </div>
                        <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-slate-600">
                            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-full bg-emerald-500"></span> LOW</span>
                            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-full bg-amber-500"></span> MEDIUM</span>
                            <span class="inline-flex items-center gap-2"><span class="h-3 w-3 rounded-full bg-red-500"></span> HIGH</span>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</body>
</html>