<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Inspeksi | Starfood International</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .calendar-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .calendar-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            padding: 28px;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
        }

        .calendar-description {
            max-width: 620px;
            margin-top: 8px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .calendar-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .calendar-summary-card {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
        }

        .calendar-summary-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .calendar-summary-value {
            margin-top: 8px;
            color: #0f172a;
            font-size: 27px;
            font-weight: 750;
            letter-spacing: -.04em;
        }

        .calendar-summary-note {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
        }

        .calendar-month-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            padding: 20px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .calendar-select {
            width: 100%;
            max-width: 320px;
        }

        .calendar-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .calendar-period-label {
            color: #f07f5f;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .calendar-period-title {
            margin-top: 4px;
            color: #123b3a;
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -.035em;
        }

        .calendar-period-subtitle {
            margin-top: 5px;
            color: #64748b;
            font-size: 13px;
        }

        .calendar-nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-nav-link,
        .calendar-nav-disabled {
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            color: #475569;
        }

        .calendar-nav-link {
            text-decoration: none;
            transition: background .18s ease, color .18s ease, border-color .18s ease;
        }

        .calendar-nav-link:hover {
            border-color: #123b3a;
            background: #123b3a;
            color: #fff;
        }

        .calendar-nav-disabled {
            color: #cbd5e1;
            background: #f8fafc;
        }

        .inspection-calendar {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
            gap: 8px;
            width: 100%;
        }

        .inspection-weekday {
            display: flex;
            min-width: 0;
            align-items: center;
            justify-content: center;
            padding: 12px 2px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .inspection-day {
            display: flex;
            min-width: 0;
            min-height: 76px;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 6px;
            box-sizing: border-box;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 15px;
        }

        a.inspection-day.has-data {
            border: 1px solid #123b3a;
            background: #123b3a;
            color: #fff;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: background .18s ease, border-color .18s ease, transform .18s ease;
        }

        a.inspection-day.has-data:hover {
            transform: translateY(-2px);
            border-color: #f07f5f;
            background: #f07f5f;
        }

        .inspection-day.empty-day {
            visibility: hidden;
            border: 0;
            background: transparent;
        }

        .inspection-day .day-indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #f07f5f;
        }

        .calendar-legend {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px 20px;
            padding: 16px 22px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
        }

        .calendar-legend-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-legend-color {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            border-radius: 4px;
        }

        .calendar-legend-hint {
            margin-left: auto;
            color: #94a3b8;
        }

        .calendar-empty {
            padding: 42px 20px;
            text-align: center;
            color: #64748b;
        }

        .calendar-empty-icon {
            display: flex;
            width: 60px;
            height: 60px;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border-radius: 17px;
            background: #f1f5f9;
            color: #123b3a;
        }

        @media (max-width: 1024px) {
            .inspection-day {
                min-height: 64px;
            }
        }

        @media (max-width: 640px) {
            .calendar-hero {
                padding: 22px 18px;
            }

            .calendar-summary {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .calendar-summary-card {
                padding: 16px;
            }

            .calendar-summary-value {
                font-size: 24px;
            }

            .calendar-month-toolbar,
            .calendar-heading {
                align-items: stretch;
                padding: 16px;
            }

            .calendar-select {
                max-width: none;
            }

            .calendar-period-title {
                font-size: 21px;
            }

            .inspection-calendar {
                gap: 4px;
            }

            .inspection-weekday {
                padding: 10px 0;
                border-radius: 7px;
                font-size: 10px;
            }

            .inspection-day {
                min-height: 46px;
                border-radius: 7px;
                font-size: 12px;
                gap: 3px;
            }

            .inspection-day .day-indicator {
                width: 4px;
                height: 4px;
            }

            .calendar-grid-wrap {
                padding: 12px !important;
            }

            .calendar-legend {
                padding: 14px;
                gap: 10px;
            }

            .calendar-legend-hint {
                width: 100%;
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="app-shell">
    @include('partials.nav')

    @php
        $jumlahBulanTercatat = $daftarBulan->count();
    @endphp

    <main class="page-wrap calendar-page">
        <header class="calendar-hero">
            <div>
                <p class="page-kicker">INSPECTION CALENDAR</p>
                <h1 class="page-title">Kalender Inspeksi</h1>
                <p class="calendar-description">
                    Pilih tanggal yang memiliki data inspeksi untuk membuka detail pemeriksaan harian.
                </p>
            </div>

            <a href="{{ route('entries.riwayat') }}" class="btn-secondary">
                Riwayat Bulanan
            </a>
        </header>

        @if ($daftarBulan->isEmpty())
            <section class="panel">
                <div class="calendar-empty">
                    <div class="calendar-empty-icon">
                        <svg width="30" height="30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/>
                            <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-800">Belum Ada Data Inspeksi</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Kalender akan tersedia setelah data inspeksi tersimpan.
                    </p>
                    @if (in_array(auth()->user()->role, ['pengelola', 'operatorpc'], true))
                        <a href="{{ route('entries.create') }}" class="btn-primary mt-5 inline-flex">
                            Buka Input Harian
                        </a>
                    @endif
                </div>
            </section>
        @else
            @php
                $awalBulan = \Carbon\Carbon::createFromFormat('!Y-m', $bulanDipilih);
                $jumlahHari = $awalBulan->daysInMonth;
                $offset = $awalBulan->dayOfWeek;

                $tanggalAktif = $tanggalList
                    ->map(fn ($tanggal) => (int) \Carbon\Carbon::parse($tanggal)->day)
                    ->all();

                $namaBulan = $awalBulan->locale('id')->translatedFormat('F Y');

                $indexBulan = $daftarBulan->search($bulanDipilih);

                $bulanLebihBaru = $indexBulan !== false && $indexBulan > 0
                    ? $daftarBulan[$indexBulan - 1]
                    : null;

                $bulanLebihLama = $indexBulan !== false && $indexBulan < $daftarBulan->count() - 1
                    ? $daftarBulan[$indexBulan + 1]
                    : null;
            @endphp

            <section class="calendar-summary">
                <article class="calendar-summary-card">
                    <p class="calendar-summary-label">Bulan Tercatat</p>
                    <p class="calendar-summary-value">{{ number_format($jumlahBulanTercatat) }}</p>
                    <p class="calendar-summary-note">Bulan dengan data inspeksi</p>
                </article>

                <article class="calendar-summary-card">
                    <p class="calendar-summary-label">Tanggal Berisi Data</p>
                    <p class="calendar-summary-value">{{ number_format($tanggalList->count()) }}</p>
                    <p class="calendar-summary-note">Pada {{ $namaBulan }}</p>
                </article>

                <article class="calendar-summary-card">
                    <p class="calendar-summary-label">Hari dalam Bulan</p>
                    <p class="calendar-summary-value">{{ number_format($jumlahHari) }}</p>
                    <p class="calendar-summary-note">Jumlah hari kalender pada periode ini</p>
                </article>
            </section>

            <section class="panel">
                <div class="calendar-month-toolbar">
                    <div>
                        <h2 class="panel-title">Pilih Periode Inspeksi</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Pilih bulan yang memiliki data inspeksi.
                        </p>
                    </div>

                    <form action="{{ route('entries.kalender') }}" method="GET">
                        <label for="bulan" class="field-label">Bulan dan Tahun</label>
                        <select id="bulan" name="bulan" class="select calendar-select" onchange="this.form.submit()">
                            @foreach ($daftarBulan as $bulan)
                                <option value="{{ $bulan }}" @selected($bulan === $bulanDipilih)>
                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->locale('id')->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                        <noscript>
                            <button type="submit" class="btn-primary mt-2">Tampilkan</button>
                        </noscript>
                    </form>
                </div>
            </section>

            <section class="panel" style="overflow:hidden;">
                <div class="calendar-heading">
                    <div>
                        <p class="calendar-period-label">Periode Terpilih</p>
                        <h2 class="calendar-period-title">{{ $namaBulan }}</h2>
                        <p class="calendar-period-subtitle">
                            {{ $tanggalList->count() }} tanggal memiliki data inspeksi
                        </p>
                    </div>

                    <div class="calendar-nav">
                        @if ($bulanLebihLama)
                            <a href="{{ route('entries.kalender', ['bulan' => $bulanLebihLama]) }}"
                               class="calendar-nav-link" title="Periode lebih lama" aria-label="Periode lebih lama">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="calendar-nav-disabled" aria-disabled="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif

                        @if ($bulanLebihBaru)
                            <a href="{{ route('entries.kalender', ['bulan' => $bulanLebihBaru]) }}"
                               class="calendar-nav-link" title="Periode lebih baru" aria-label="Periode lebih baru">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        @else
                            <span class="calendar-nav-disabled" aria-disabled="true">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="calendar-grid-wrap" style="padding:20px;">
                    <div class="inspection-calendar">
                        @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $namaHari)
                            <div class="inspection-weekday">{{ $namaHari }}</div>
                        @endforeach
                    </div>

                    <div class="inspection-calendar" style="margin-top:8px;">
                        @for ($i = 0; $i < $offset; $i++)
                            <div class="inspection-day empty-day"></div>
                        @endfor

                        @for ($hari = 1; $hari <= $jumlahHari; $hari++)
                            @php
                                $adaData = in_array($hari, $tanggalAktif, true);
                                $tanggalLengkap = $awalBulan->copy()->day($hari)->format('Y-m-d');
                            @endphp

                            @if ($adaData)
                                <a href="{{ route('entries.riwayat', ['bulan' => $bulanDipilih, 'tanggal' => $tanggalLengkap]) }}"
                                   class="inspection-day has-data"
                                   title="Lihat detail inspeksi {{ $tanggalLengkap }}"
                                   aria-label="Lihat detail inspeksi tanggal {{ $hari }} {{ $namaBulan }}">
                                    <span>{{ $hari }}</span>
                                    <span class="day-indicator"></span>
                                </a>
                            @else
                                <div class="inspection-day" aria-label="Tidak ada data tanggal {{ $hari }}">
                                    {{ $hari }}
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="calendar-legend">
                    <span class="calendar-legend-item">
                        <span class="calendar-legend-color" style="background:#123b3a;"></span>
                        Tanggal memiliki data
                    </span>
                    <span class="calendar-legend-item">
                        <span class="calendar-legend-color" style="background:#f1f5f9;border:1px solid #e2e8f0;"></span>
                        Tidak ada data
                    </span>
                    <span class="calendar-legend-hint">Klik tanggal yang ditandai untuk melihat detail inspeksi.</span>
                </div>
            </section>
        @endif

        <div>
            <a href="{{ route('entries.riwayat') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-[#123b3a] hover:text-[#123b3a]">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali ke Riwayat Bulanan
            </a>
        </div>
    </main>
</body>
</html>
