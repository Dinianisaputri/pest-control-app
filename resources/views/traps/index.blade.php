<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Trap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .trap-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .trap-hero {
            position: relative;
            overflow: hidden;
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

        .trap-hero::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -55px;
            top: -80px;
            border-radius: 50%;
            background: rgba(34, 197, 94, .08);
            pointer-events: none;
        }

        .trap-hero-content,
        .trap-hero-action {
            position: relative;
            z-index: 1;
        }

        .trap-description {
            margin-top: 8px;
            max-width: 600px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .trap-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .trap-summary-card {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
        }

        .trap-summary-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .trap-summary-value {
            margin-top: 8px;
            color: #0f172a;
            font-size: 28px;
            font-weight: 750;
            letter-spacing: -.04em;
        }

        .trap-summary-note {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
        }

        .trap-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .trap-search-wrap {
            position: relative;
            width: 100%;
            max-width: 380px;
        }

        .trap-search {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            background: #fff;
            color: #0f172a;
            font-size: 14px;
            outline: none;
        }

        .trap-search:focus {
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, .10);
        }

        .trap-search-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .trap-group-count {
            padding: 5px 10px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .trap-type-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #15803d;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .trap-type-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22c55e;
        }

        .trap-empty {
            padding: 36px 20px;
            color: #64748b;
            text-align: center;
            font-size: 14px;
        }

        .trap-table td {
            vertical-align: middle;
        }

        .trap-number {
            display: inline-flex;
            padding: 5px 9px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fafc;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .trap-location {
            color: #475569;
        }

        .trap-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 12px;
            border: 1px solid #d1fae5;
            border-radius: 8px;
            background: #f0fdf4;
            color: #15803d;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: background .2s ease;
        }

        .trap-edit:hover {
            background: #dcfce7;
        }

        @media (max-width: 640px) {
            .trap-hero {
                padding: 22px 18px;
            }

            .trap-summary {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .trap-summary-card {
                padding: 16px;
            }

            .trap-summary-value {
                font-size: 24px;
            }

            .trap-toolbar {
                align-items: stretch;
                padding: 16px;
            }

            .trap-search-wrap {
                max-width: none;
            }
        }
    </style>
</head>

<body class="app-shell">
    @include('partials.nav')

    @php
        $totalTrap = collect($grouped)->sum(fn ($traps) => $traps->count());
        $totalJenis = collect($grouped)->count();
        $isAdmin = auth()->user()->role === 'admin';
    @endphp

    <main class="page-wrap trap-page">
        <header class="trap-hero">
            <div class="trap-hero-content">
                <p class="page-kicker">MASTER DATA</p>
                <h1 class="page-title">Data Master Trap</h1>
                <p class="trap-description">
                    Kelola dan pantau data perangkap hama yang digunakan dalam kegiatan
                    inspeksi pest control di area perusahaan.
                </p>
            </div>

            @if ($isAdmin)
                <div class="trap-hero-action">
                    <a href="{{ route('traps.create') }}" class="btn-primary">
                        + Tambah Perangkap
                    </a>
                </div>
            @endif
        </header>

        @if (session('success'))
            <div class="alert mb-0" role="status" aria-live="polite">
                {{ session('success') }}
            </div>
        @endif

        <section class="trap-summary">
            <article class="trap-summary-card">
                <p class="trap-summary-label">Total Trap</p>
                <p class="trap-summary-value">{{ number_format($totalTrap) }}</p>
                <p class="trap-summary-note">Seluruh perangkap terdaftar</p>
            </article>

            <article class="trap-summary-card">
                <p class="trap-summary-label">Jenis Trap</p>
                <p class="trap-summary-value">{{ number_format($totalJenis) }}</p>
                <p class="trap-summary-note">Kelompok jenis perangkap</p>
            </article>

            <article class="trap-summary-card">
                <p class="trap-summary-label">Akses Pengguna</p>
                <p class="trap-summary-value" style="font-size: 22px;">
                    {{ $isAdmin ? 'Admin' : 'Petugas' }}
                </p>
                <p class="trap-summary-note">
                    {{ $isAdmin ? 'Dapat mengelola data trap' : 'Akses melihat data trap' }}
                </p>
            </article>
        </section>

        <section class="panel">
            <div class="trap-toolbar">
                <div>
                    <h2 class="panel-title">Daftar Perangkap</h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Data dikelompokkan berdasarkan jenis trap.
                    </p>
                </div>

                <div class="trap-search-wrap">
                    <span class="trap-search-icon" aria-hidden="true">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>
                    </span>
                    <input
                        id="trapSearch"
                        type="search"
                        class="trap-search"
                        placeholder="Cari nomor, spesies, atau lokasi..."
                        aria-label="Cari data trap"
                    >
                </div>
            </div>

            <div class="p-4 sm:p-5" style="display:flex; flex-direction:column; gap:20px;">
                @forelse ($grouped as $type => $traps)
                    <section class="panel trap-group" style="overflow:hidden;">
                        <div class="panel-header">
                            <div>
                                <span class="trap-type-label">
                                    <span class="trap-type-dot"></span>
                                    Jenis Perangkap
                                </span>
                                <h3 class="panel-title mt-1">{{ $type ?: 'Tidak ditentukan' }}</h3>
                            </div>

                            <span class="trap-group-count">
                                <span class="group-visible-count">{{ $traps->count() }}</span> item
                            </span>
                        </div>

                        <div class="table-wrapper">
                            <table class="data-table trap-table">
                                <thead>
                                    <tr>
                                        <th>No. Trap</th>
                                        <th>Spesies Hama</th>
                                        <th>Lokasi</th>
                                        @if ($isAdmin)
                                            <th style="width:100px;">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($traps as $trap)
                                        <tr class="trap-row">
                                            <td>
                                                <span class="trap-number">
                                                    {{ $trap->no_trap }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="font-semibold text-slate-700">
                                                    {{ $trap->spesies_hama ?: '—' }}
                                                </span>
                                            </td>

                                            <td class="trap-location">
                                                {{ $trap->lokasi ?: '—' }}
                                            </td>

                                            @if ($isAdmin)
                                                <td>
                                                    <a
                                                        href="{{ route('traps.edit', $trap) }}"
                                                        class="trap-edit"
                                                        aria-label="Edit trap {{ $trap->no_trap }}"
                                                    >
                                                        Edit
                                                    </a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach

                                    <tr class="trap-no-results" style="display:none;">
                                        <td colspan="{{ $isAdmin ? 4 : 3 }}" class="trap-empty">
                                            Tidak ada trap yang cocok dengan pencarian.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                @empty
                    <div class="trap-empty">
                        Belum ada data trap yang tersedia.
                    </div>
                @endforelse

                <div id="trapGlobalEmpty" class="trap-empty" style="display:none;">
                    Data trap tidak ditemukan. Coba kata kunci lain.
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('trapSearch');
            const groups = Array.from(document.querySelectorAll('.trap-group'));
            const globalEmpty = document.getElementById('trapGlobalEmpty');

            if (!searchInput) return;

            searchInput.addEventListener('input', function () {
                const keyword = this.value.trim().toLocaleLowerCase('id-ID');
                let totalVisible = 0;

                groups.forEach(function (group) {
                    const rows = Array.from(group.querySelectorAll('.trap-row'));
                    const noResults = group.querySelector('.trap-no-results');
                    const visibleCount = rows.reduce(function (count, row) {
                        const matches = row.textContent.toLocaleLowerCase('id-ID').includes(keyword);
                        row.style.display = matches ? '' : 'none';
                        return count + (matches ? 1 : 0);
                    }, 0);

                    const countElement = group.querySelector('.group-visible-count');
                    if (countElement) countElement.textContent = visibleCount;

                    if (noResults) {
                        noResults.style.display = visibleCount === 0 ? '' : 'none';
                    }

                    group.style.display = visibleCount > 0 ? '' : 'none';
                    totalVisible += visibleCount;
                });

                if (globalEmpty) {
                    globalEmpty.style.display = totalVisible === 0 ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>