<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pest Control</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        .dashboard-hero {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.25rem;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            background: #fff;
            box-shadow: 0 2px 10px rgba(23, 43, 77, .035);
        }
        .dashboard-hero::after {
            display: none;
        }
        .dashboard-hero-content {
            position: relative;
            z-index: 1;
        }
        .dashboard-hero .header-badge {
            border-color: #d8e3ed;
            background: #f1f5f9;
            color: #244b70;
        }
        .dashboard-hero .page-kicker {
            color: #244b70;
        }
        .dashboard-hero .page-title {
            color: #172b4d;
        }
        .dashboard-hero .page-subtitle {
            color: #52627a;
        }
        .dashboard-date {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            flex-shrink: 0;
            padding: .65rem .9rem;
            border: 1px solid #dbe5ee;
            border-radius: 999px;
            background: #fff;
            color: #334155;
            font-size: .875rem;
            font-weight: 600;
        }
        .dashboard-date-dot {
            width: .5rem;
            height: .5rem;
            border-radius: 999px;
            background: #10b981;
        }
        .dashboard-stat {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 12.5rem;
            padding: 1.2rem;
            border: 1px solid #e2e8f0;
            border-radius: 1.1rem;
            background: #fff;
            box-shadow: 0 6px 20px rgba(15, 23, 42, .04);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .dashboard-stat:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
        }
        .dashboard-stat::after {
            position: absolute;
            right: -1.4rem;
            bottom: -2rem;
            width: 6rem;
            height: 6rem;
            border-radius: 999px;
            background: color-mix(in srgb, var(--stat-soft) 55%, white);
            content: "";
        }
        .dashboard-stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .75rem;
        }
        .dashboard-stat-icon {
            display: grid;
            width: 2.75rem;
            height: 2.75rem;
            place-items: center;
            border-radius: .85rem;
            background: var(--stat-soft);
            color: var(--stat-ink);
        }
        .dashboard-stat-icon svg {
            width: 1.3rem;
            height: 1.3rem;
        }
        .dashboard-stat-tag {
            position: relative;
            z-index: 1;
            white-space: nowrap;
            border-radius: 999px;
            padding: .3rem .55rem;
            background: var(--stat-soft);
            color: var(--stat-ink);
            font-size: .7rem;
            font-weight: 700;
        }
        .dashboard-stat-label {
            margin-top: 1rem;
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
        }
        .dashboard-stat-value {
            margin-top: .25rem;
            color: #0f172a;
            font-size: clamp(1.65rem, 2.5vw, 2.1rem);
            font-weight: 750;
            line-height: 1.2;
            letter-spacing: -.04em;
        }
        .dashboard-stat-note {
            margin-top: auto;
            padding-top: .6rem;
            color: #64748b;
            font-size: .75rem;
            line-height: 1.5;
        }
        .dashboard-section {
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 1.15rem;
            background: #fff;
            box-shadow: 0 6px 20px rgba(15, 23, 42, .04);
        }
        .dashboard-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.2rem 1.35rem;
            border-bottom: 1px solid #edf2f7;
        }
        .dashboard-section-title {
            color: #0f172a;
            font-size: 1rem;
            font-weight: 750;
            letter-spacing: -.01em;
        }
        .dashboard-section-subtitle {
            margin-top: .25rem;
            color: #64748b;
            font-size: .78rem;
        }
        .dashboard-section-body {
            padding: 1.25rem;
        }
        .dashboard-chart-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1.35fr);
            gap: 1.25rem;
        }
        .dashboard-chart-card {
            min-width: 0;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: .9rem;
            background: #fff;
        }
        .dashboard-chart-heading {
            margin-bottom: .25rem;
            color: #1e293b;
            font-size: .9rem;
            font-weight: 700;
        }
        .dashboard-chart-description {
            margin-bottom: 1rem;
            color: #64748b;
            font-size: .75rem;
        }
        .dashboard-doughnut-wrap {
            position: relative;
            width: 100%;
            max-width: 290px;
            height: 260px;
            margin: 1rem auto 0;
        }
        .dashboard-line-wrap {
            position: relative;
            width: 100%;
            height: 300px;
        }
        .dashboard-empty {
            display: grid;
            min-height: 150px;
            place-items: center;
            border: 1px dashed #cbd5e1;
            border-radius: .85rem;
            background: #f8fafc;
            padding: 1rem;
            color: #64748b;
            text-align: center;
            font-size: .85rem;
        }
        .dashboard-species-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .8rem;
        }
        .dashboard-species-table th,
        .dashboard-species-table td {
            padding: .65rem .5rem;
            border-bottom: 1px solid #edf2f7;
            text-align: left;
        }
        .dashboard-species-table tbody tr:hover,
        .dashboard-type-table tbody tr:hover {
            background: #f8fafc;
        }
        .dashboard-species-table th {
            color: #64748b;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .dashboard-species-table td:last-child,
        .dashboard-species-table th:last-child {
            text-align: right;
        }
        .dashboard-number-pill {
            display: inline-flex;
            min-width: 2rem;
            justify-content: center;
            padding: .2rem .5rem;
            border-radius: 999px;
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
        }
        .dashboard-activity-legend {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: 1rem;
            color: #64748b;
            font-size: .75rem;
        }
        .dashboard-legend-item {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }
        .dashboard-legend-dot {
            width: .55rem;
            height: .55rem;
            border-radius: 999px;
        }
        .dashboard-activity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(3.25rem, 1fr));
            gap: .5rem;
        }
        .dashboard-activity-item {
            display: flex;
            min-height: 3.25rem;
            align-items: center;
            justify-content: center;
            border-radius: .75rem;
            border: 1px solid #e2e8f0;
            background: var(--activity-bg);
            color: var(--activity-fg);
            font-size: .75rem;
            font-weight: 750;
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .dashboard-activity-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(15, 23, 42, .08);
        }
        .dashboard-table-wrap {
            overflow-x: auto;
        }
        .dashboard-type-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: .875rem;
        }
        .dashboard-type-table th,
        .dashboard-type-table td {
            padding: .85rem 1.25rem;
            border-bottom: 1px solid #edf2f7;
        }
        .dashboard-type-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .dashboard-type-table td:first-child {
            color: #334155;
            font-weight: 600;
        }
        .dashboard-type-table tr:last-child td {
            border-bottom: 0;
        }
        @media (max-width: 900px) {
            .dashboard-chart-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .dashboard-hero {
                align-items: flex-start;
                flex-direction: column;
                padding: 1.15rem;
            }
            .dashboard-section-header {
                align-items: flex-start;
                flex-direction: column;
            }
            .dashboard-section-body { padding: .85rem; }
            .dashboard-chart-card { padding: .85rem; }
            .dashboard-line-wrap { height: 250px; }
            .dashboard-date { font-size: .8rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            .dashboard-stat,
            .dashboard-activity-item {
                transition: none;
            }
            .dashboard-stat:hover,
            .dashboard-activity-item:hover {
                transform: none;
            }
        }
    </style>
</head>
<body class="app-shell">
    @include('partials.nav')

    <main class="page-wrap space-y-6">
        <header class="dashboard-hero">
            <div class="dashboard-hero-content">
                <span class="header-badge">Monitoring aktif</span>
                <p class="page-kicker">OVERVIEW</p>
                <h1 class="page-title">Dashboard Pest Control</h1>
                <p class="page-subtitle mt-2 max-w-2xl">
                    Pantau titik monitoring, tingkat aktivitas, dan tren hama dalam satu tampilan.
                </p>
            </div>
            <div class="dashboard-date">
                <span class="dashboard-date-dot"></span>
                {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}
            </div>
        </header>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="dashboard-stat" style="--stat-soft:#d9eeeb;--stat-ink:#155e63">
                <div class="dashboard-stat-top">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8.5h14M7 8.5V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2.5m-11 0 1.1 10.1A2 2 0 0 0 9.1 20h5.8a2 2 0 0 0 2-1.4L18 8.5M9 12h.01M15 12h.01M10 16h4" />
                        </svg>
                    </span>
                    <span class="dashboard-stat-tag">Semua titik</span>
                </div>
                <p class="dashboard-stat-label">Total Trap</p>
                <p class="dashboard-stat-value">{{ $totalTraps }}</p>
                <p class="dashboard-stat-note">Seluruh titik monitoring terdaftar</p>
            </article>

            <article class="dashboard-stat" style="--stat-soft:#d1fae5;--stat-ink:#047857">
                <div class="dashboard-stat-top">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m5 12.5 4.2 4.2L19 7" />
                            <circle cx="12" cy="12" r="9" stroke-width="1.8" />
                        </svg>
                    </span>
                    <span class="dashboard-stat-tag">
                        {{ $totalTraps > 0 ? round(($filled / $totalTraps) * 100, 1) : 0 }}%
                    </span>
                </div>
                <p class="dashboard-stat-label">Terisi Hari Ini</p>
                <p class="dashboard-stat-value">{{ $filled }}</p>
                <p class="dashboard-stat-note">{{ $filled }} dari {{ $totalTraps }} trap tercatat hari ini</p>
            </article>

            <article class="dashboard-stat" style="--stat-soft:#fff1d6;--stat-ink:#a16207">
                <div class="dashboard-stat-top">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4m0 4h.01" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.3 3.9 2.8 17a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                        </svg>
                    </span>
                    <span class="dashboard-stat-tag">Perlu perhatian</span>
                </div>
                <p class="dashboard-stat-label">Aktivitas Medium / High</p>
                <p class="dashboard-stat-value">{{ $dist['MEDIUM'] + $dist['HIGH'] }}</p>
                <p class="dashboard-stat-note">Jumlah catatan aktivitas MEDIUM dan HIGH hari ini</p>
            </article>

            <article class="dashboard-stat" style="--stat-soft:#fce8e3;--stat-ink:#b4533d">
                <div class="dashboard-stat-top">
                    <span class="dashboard-stat-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3.5" y="5" width="17" height="16" rx="2" stroke-width="1.8" />
                            <path stroke-linecap="round" stroke-width="1.8" d="M7.5 3v4m9-4v4M3.5 10h17" />
                        </svg>
                    </span>
                    <span class="dashboard-stat-tag">Riwayat</span>
                </div>
                <p class="dashboard-stat-label">Hari Tercatat</p>
                <p class="dashboard-stat-value">{{ $totalHariTercatat }}</p>
                <p class="dashboard-stat-note">Jumlah tanggal yang memiliki data inspeksi</p>
            </article>
        </section>

        <section class="dashboard-section">
            <div class="dashboard-section-header">
                <div>
                    <h2 class="dashboard-section-title">Statistik & Tren</h2>
                    <p class="dashboard-section-subtitle">Ringkasan pelaporan spesies dan tingkat aktivitas dari data inspeksi.</p>
                </div>
                <span class="badge badge-neutral">Analitik</span>
            </div>

            <div class="dashboard-section-body">
                <div class="dashboard-chart-grid">
                    <div class="dashboard-chart-card">
                        <h3 class="dashboard-chart-heading">Pelaporan per Spesies</h3>
                        <p class="dashboard-chart-description">Jumlah entri inspeksi yang tercatat untuk setiap spesies.</p>

                        @if (count($speciesCounts) === 0)
                            <div class="dashboard-empty">Belum ada data pelaporan spesies.</div>
                        @else
                            <div class="dashboard-table-wrap">
                                <table class="dashboard-species-table">
                                    <thead>
                                        <tr>
                                            <th>Spesies</th>
                                            <th>Total tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($speciesCounts as $spesies => $total)
                                            <tr>
                                                <td>{{ $spesies ?: 'Tidak diketahui' }}</td>
                                                <td><span class="dashboard-number-pill">{{ $total }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="dashboard-doughnut-wrap">
                                <canvas id="speciesChart" aria-label="Grafik pelaporan per spesies"></canvas>
                            </div>
                        @endif
                    </div>

                    <div class="dashboard-chart-card">
                        <h3 class="dashboard-chart-heading">Statistik Aktivitas per Bulan</h3>
                        <p class="dashboard-chart-description">Perbandingan jumlah aktivitas LOW, MEDIUM, dan HIGH pada setiap bulan.</p>

                        @if (count($monthlyStats) === 0)
                            <div class="dashboard-empty">Belum ada data aktivitas bulanan.</div>
                        @else
                            <div class="dashboard-line-wrap">
                                <canvas id="monthlyChart" aria-label="Grafik tren aktivitas bulanan"></canvas>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="dashboard-section">
            <div class="dashboard-section-header">
                <div>
                    <h2 class="dashboard-section-title">Status Aktivitas Hari Ini</h2>
                    <p class="dashboard-section-subtitle">Setiap kotak mewakili satu entri inspeksi untuk hari ini.</p>
                </div>
                <div class="flex flex-wrap gap-2 text-xs">
                    <span class="dashboard-number-pill">{{ $filled }} entri</span>
                    <span class="dashboard-number-pill">{{ $dist['HIGH'] }} aktivitas HIGH</span>
                </div>
            </div>

            <div class="dashboard-section-body">
                @if ($filled === 0)
                    <div class="dashboard-empty">Belum ada input inspeksi untuk hari ini.</div>
                @else
                    <div class="dashboard-activity-legend">
                        <span class="dashboard-legend-item"><i class="dashboard-legend-dot" style="background:#10b981"></i>LOW</span>
                        <span class="dashboard-legend-item"><i class="dashboard-legend-dot" style="background:#f59e0b"></i>MEDIUM</span>
                        <span class="dashboard-legend-item"><i class="dashboard-legend-dot" style="background:#ef4444"></i>HIGH</span>
                        <span class="dashboard-legend-item"><i class="dashboard-legend-dot" style="background:#94a3b8"></i>Belum ditentukan</span>
                    </div>

                    <div class="dashboard-activity-grid">
                        @foreach ($todayEntries as $entry)
                            @php
                                [$activityBackground, $activityForeground] = match ($entry->aktivitas) {
                                    'LOW' => ['#d1fae5', '#047857'],
                                    'MEDIUM' => ['#fff1d6', '#a16207'],
                                    'HIGH' => ['#ffe4e6', '#be123c'],
                                    default => ['#f1f5f9', '#475569'],
                                };
                            @endphp
                            <div
                                class="dashboard-activity-item"
                                title="Trap ID {{ $entry->trap_id }} — {{ $entry->aktivitas ?: 'Belum ditentukan' }}"
                                style="--activity-bg:{{ $activityBackground }};--activity-fg:{{ $activityForeground }}"
                            >
                                #{{ optional($entry->trap)->no_trap ?? $entry->trap_id }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="dashboard-section">
            <div class="dashboard-section-header">
                <div>
                    <h2 class="dashboard-section-title">Trap per Jenis Detector</h2>
                    <p class="dashboard-section-subtitle">Jumlah titik monitoring berdasarkan jenis detector.</p>
                </div>
                <span class="badge badge-neutral">{{ count($typeCounts) }} jenis</span>
            </div>

            <div class="dashboard-table-wrap">
                <table class="dashboard-type-table">
                    <thead>
                        <tr>
                            <th>Jenis Detector</th>
                            <th>Jumlah Trap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
                            <tr>
                                <td>{{ $type }}</td>
                                <td><span class="dashboard-number-pill">{{ $typeCounts[$type] ?? 0 }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Chart === 'undefined') return;

            @if (count($speciesCounts) > 0)
                const speciesData = @json($speciesCounts);
                const speciesLabels = Object.keys(speciesData).map(label => label || 'Tidak diketahui');
                const speciesValues = Object.values(speciesData);
                const speciesPalette = [
                    '#155e63', '#f07f5f', '#1c7a7b', '#10b981',
                    '#ef4444', '#8b5cf6', '#06b6d4', '#f97316'
                ];

                new Chart(document.getElementById('speciesChart'), {
                    type: 'doughnut',
                    data: {
                        labels: speciesLabels,
                        datasets: [{
                            data: speciesValues,
                            backgroundColor: speciesLabels.map((_, index) => speciesPalette[index % speciesPalette.length]),
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { padding: 14, usePointStyle: true, boxWidth: 8, font: { size: 11 } }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return context.label + ': ' + context.raw + ' kali tercatat';
                                    }
                                }
                            }
                        }
                    }
                });
            @endif

            @if (count($monthlyStats) > 0)
                const monthlyData = @json($monthlyStats);
                const rawLabels = Object.keys(monthlyData).sort();
                const monthNames = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                const chartLabels = rawLabels.map(month => {
                    const parts = month.split('-');
                    return monthNames[parseInt(parts[1], 10)] + ' ' + parts[0];
                });

                const lowData = rawLabels.map(month => Number(monthlyData[month].LOW || 0));
                const mediumData = rawLabels.map(month => Number(monthlyData[month].MEDIUM || 0));
                const highData = rawLabels.map(month => Number(monthlyData[month].HIGH || 0));

                const monthlyCanvas = document.getElementById('monthlyChart');
                if (monthlyCanvas) {
                    new Chart(monthlyCanvas, {
                        type: 'line',
                        data: {
                            labels: chartLabels,
                            datasets: [
                                {
                                    label: 'LOW',
                                    data: lowData,
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16,185,129,.08)',
                                    tension: .35,
                                    fill: false,
                                    pointRadius: 3,
                                    pointHoverRadius: 5,
                                    borderWidth: 2.5
                                },
                                {
                                    label: 'MEDIUM',
                                    data: mediumData,
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245,158,11,.08)',
                                    tension: .35,
                                    fill: false,
                                    pointRadius: 3,
                                    pointHoverRadius: 5,
                                    borderWidth: 2.5
                                },
                                {
                                    label: 'HIGH',
                                    data: highData,
                                    borderColor: '#ef4444',
                                    backgroundColor: 'rgba(239,68,68,.08)',
                                    tension: .35,
                                    fill: false,
                                    pointRadius: 3,
                                    pointHoverRadius: 5,
                                    borderWidth: 2.5
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: { mode: 'index', intersect: false },
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: { padding: 14, usePointStyle: true, boxWidth: 8, font: { size: 11 } }
                                }
                            },
                            scales: {
                                x: { grid: { display: false } },
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 },
                                    grid: { color: '#eef2f7' }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>
</body>
</html>
