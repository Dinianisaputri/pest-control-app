<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media (max-width: 768px) {
            .chart-grid-responsive {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div class="header-content">
                <span class="header-badge">Monitoring aktif</span>
                <p class="page-kicker">Overview</p>
                <h1 class="page-title">Dashboard Pest Control</h1>
                <p class="page-subtitle">Pantau titik monitor, tingkat aktivitas, dan tren hama dalam satu tampilan yang lebih informatif.</p>
            </div>
            <div class="header-pill">
                <span class="header-pill__dot"></span>
                {{ \Carbon\Carbon::parse($today)->translatedFormat('d F Y') }}
            </div>
        </header>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="stat-card stat-card--cyan">
                <div class="stat-top">
                    <span class="stat-icon">🪤</span>
                    <span class="stat-trend stat-trend--positive">Live</span>
                </div>
                <div class="stat-label">Total Trap</div>
                <div class="stat-value">{{ $totalTraps }}</div>
                <div class="stat-meta">Seluruh titik monitoring</div>
            </article>

            <article class="stat-card stat-card--emerald">
                <div class="stat-top">
                    <span class="stat-icon">✅</span>
                    <span class="stat-trend stat-trend--positive">{{ $totalTraps > 0 ? round(($filled / $totalTraps) * 100, 1) : 0 }}%</span>
                </div>
                <div class="stat-label">Terisi Hari Ini</div>
                <div class="stat-value">{{ $filled }}</div>
                <div class="stat-meta">{{ $filled }} / {{ $totalTraps }} trap</div>
            </article>

            <article class="stat-card stat-card--amber">
                <div class="stat-top">
                    <span class="stat-icon">⚠️</span>
                    <span class="stat-trend stat-trend--warning">Perhatian</span>
                </div>
                <div class="stat-label">Medium / High</div>
                <div class="stat-value">{{ $dist['MEDIUM'] + $dist['HIGH'] }}</div>
                <div class="stat-meta">Kebutuhan perhatian</div>
            </article>

            <article class="stat-card stat-card--rose">
                <div class="stat-top">
                    <span class="stat-icon">📅</span>
                    <span class="stat-trend stat-trend--neutral">Aktif</span>
                </div>
                <div class="stat-label">Hari Tercatat</div>
                <div class="stat-value">{{ $totalHariTercatat }}</div>
                <div class="stat-meta">Data aktif tersedia</div>
            </article>
        </section>

        <div class="mt-8">
            <section class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Statistik & Tren</h2>
                    <span class="badge badge-neutral">Chart</span>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 20px;" class="chart-grid-responsive">
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                        <h3>Pelaporan per Spesies</h3>
                        @if (count($speciesCounts) === 0)
                            <p class="empty-state">Belum ada data.</p>
                        @else
                            <div class="species-summary">
                                <table class="mini-table">
                                    <thead>
                                        <tr>
                                            <th>Spesies</th>
                                            <th>Total Kali Tercatat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($speciesCounts as $spesies => $total)
                                            <tr>
                                                <td>{{ $spesies }}</td>
                                                <td>{{ $total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="max-width: 260px; height: 260px; margin: 0 auto;">
                                <canvas id="speciesChart"></canvas>
                            </div>
                            <script>
                                const speciesData = @json($speciesCounts);
                                const speciesLabels = Object.keys(speciesData);
                                const speciesValues = Object.values(speciesData);
                                const speciesColors = ['#0B1F3A', '#F4A340', '#1d527d', '#f7b65d', '#12345d'];

                                new Chart(document.getElementById('speciesChart'), {
                                    type: 'doughnut',
                                    data: {
                                        labels: speciesLabels,
                                        datasets: [{
                                            data: speciesValues,
                                            backgroundColor: speciesColors.slice(0, speciesLabels.length),
                                            borderWidth: 2,
                                            borderColor: '#fff',
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: {
                                            legend: { position: 'bottom', labels: { padding: 15, font: { size: 13 } } },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(ctx) {
                                                        return ctx.label + ': ' + ctx.raw + ' kali tercatat';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                        @endif
                    </div>

                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 18px; box-shadow: 0 4px 12px rgba(0,0,0,0.04);">
                        <h3>Statistik Aktivitas per Bulan</h3>
                        @if (count($monthlyStats) === 0)
                            <p class="empty-state">Belum ada cukup data buat statistik bulanan.</p>
                        @else
                            <div class="chart-wrap">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                            <script>
                                const monthlyData = @json($monthlyStats);
                                const rawLabels = Object.keys(monthlyData);

                                const bulanNama = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                const labels = rawLabels.map(m => {
                                    const [y, mo] = m.split('-');
                                    return bulanNama[parseInt(mo)] + ' ' + y;
                                });

                                const lowData = rawLabels.map(m => monthlyData[m].LOW);
                                const mediumData = rawLabels.map(m => monthlyData[m].MEDIUM);
                                const highData = rawLabels.map(m => monthlyData[m].HIGH);

                                const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');

                                function buatGradient(ctx, colorRgba) {
                                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                    gradient.addColorStop(0, colorRgba(0.35));
                                    gradient.addColorStop(1, colorRgba(0));
                                    return gradient;
                                }

                                new Chart(ctxMonthly, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'LOW',
                                                data: lowData,
                                                borderColor: '#1d527d',
                                                backgroundColor: buatGradient(ctxMonthly, (a) => `rgba(29, 82, 125, ${a})`),
                                                tension: 0.4,
                                                fill: true,
                                                pointRadius: 4,
                                                pointBackgroundColor: '#1d527d',
                                                borderWidth: 2.5,
                                            },
                                            {
                                                label: 'MEDIUM',
                                                data: mediumData,
                                                borderColor: '#F4A340',
                                                backgroundColor: buatGradient(ctxMonthly, (a) => `rgba(244, 163, 64, ${a})`),
                                                tension: 0.4,
                                                fill: true,
                                                pointRadius: 4,
                                                pointBackgroundColor: '#F4A340',
                                                borderWidth: 2.5,
                                            },
                                            {
                                                label: 'HIGH',
                                                data: highData,
                                                borderColor: '#0B1F3A',
                                                backgroundColor: buatGradient(ctxMonthly, (a) => `rgba(11, 31, 58, ${a})`),
                                                tension: 0.4,
                                                fill: true,
                                                pointRadius: 4,
                                                pointBackgroundColor: '#0B1F3A',
                                                borderWidth: 2.5,
                                            },
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        interaction: { mode: 'index', intersect: false },
                                        plugins: {
                                            legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true, font: { size: 13 } } },
                                        },
                                        scales: {
                                            x: { grid: { display: false } },
                                            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } }
                                        }
                                    }
                                });
                            </script>
                        @endif
                    </div>
                </div>
            </section>
        </div>
            <div class="mt-8">
            <section class="panel panel-highlight">
                <div class="panel-header panel-header--stacked">
                    <div>
                        <p class="page-kicker page-kicker--small">Status board</p>
                        <h2 class="panel-title">Hari Ini</h2>
                    </div>
                    <div class="mini-kpis">
                        <span>{{ $filled }} terisi</span>
                        <span>{{ $dist['HIGH'] }} high</span>
                    </div>
                </div>

                <div class="status-board p-4 sm:p-5">
                    <div class="activity-box">
                        @if ($filled === 0)
                            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                                Belum ada input untuk hari ini.
                            </div>
                        @else
                            <div class="activity-legend">
                                <span><i class="legend-dot legend-dot--low"></i> LOW</span>
                                <span><i class="legend-dot legend-dot--medium"></i> MEDIUM</span>
                                <span><i class="legend-dot legend-dot--high"></i> HIGH</span>
                            </div>
                            <div class="activity-grid">
                                @foreach ($todayEntries as $entry)
                                    @php
                                        $color = match($entry->aktivitas) {
                                            'LOW' => '#1d527d',
                                            'MEDIUM' => '#F4A340',
                                            'HIGH' => '#0B1F3A',
                                            default => '#94a3b8',
                                        };
                                    @endphp
                                    <div title="Trap #{{ $entry->trap_id }} - {{ $entry->aktivitas }}" class="activity-item" style="background: {{ $color }};">
                                        <span>#{{ $entry->trap_id }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
        <div class="mt-8">
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
        </div>
    </div>
</body>
</html>