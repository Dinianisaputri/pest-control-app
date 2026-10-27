<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Inspeksi Bulanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .history-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .history-hero {
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

        .history-description {
            max-width: 620px;
            margin-top: 8px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .history-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .history-summary-card {
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
        }

        .history-summary-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }

        .history-summary-value {
            margin-top: 8px;
            color: #0f172a;
            font-size: 28px;
            font-weight: 750;
            letter-spacing: -.04em;
        }

        .history-summary-note {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 12px;
        }

        .history-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #e2e8f0;
        }

        .history-month-select {
            width: 100%;
            max-width: 300px;
        }

        .history-month-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .history-month-card {
            display: flex;
            min-height: 190px;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #fff;
            color: inherit;
            text-decoration: none;
            transition: transform .18s ease, border-color .18s ease, box-shadow .18s ease;
        }

        .history-month-card:hover {
            transform: translateY(-2px);
            border-color: #f07f5f;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .06);
        }

        .history-month-card.is-selected {
            border-color: #f07f5f;
            background: #fff7f2;
        }

        .history-month-icon {
            display: flex;
            width: 46px;
            height: 46px;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: #123b3a;
            color: #fff;
        }

        .history-month-name {
            margin-top: 16px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 700;
        }

        .history-month-meta {
            margin-top: 5px;
            color: #64748b;
            font-size: 13px;
        }

        .history-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 18px;
            color: #123b3a;
            font-size: 13px;
            font-weight: 700;
        }

        .history-selected-pill {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 11px;
            font-weight: 700;
        }

        .history-date-list {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .history-date-card {
            display: block;
            padding: 15px;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
            background: #fff;
            text-decoration: none;
            transition: border-color .18s ease, background .18s ease;
        }

        .history-date-card:hover {
            border-color: #f07f5f;
            background: #fff7f2;
        }

        .history-date-weekday {
            color: #64748b;
            font-size: 12px;
        }

        .history-date-name {
            margin-top: 5px;
            color: #0f172a;
            font-size: 14px;
            font-weight: 700;
        }

        .history-date-action {
            margin-top: 8px;
            color: #123b3a;
            font-size: 12px;
            font-weight: 600;
        }

        .history-empty {
            padding: 38px 20px;
            text-align: center;
            color: #64748b;
        }

        .history-empty-icon {
            display: flex;
            width: 56px;
            height: 56px;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border-radius: 16px;
            background: #f1f5f9;
            color: #64748b;
        }

        @media (max-width: 1024px) {
            .history-month-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .history-date-list {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .history-hero {
                padding: 22px 18px;
            }

            .history-summary {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .history-summary-card {
                padding: 16px;
            }

            .history-summary-value {
                font-size: 24px;
            }

            .history-toolbar {
                align-items: stretch;
                padding: 16px;
            }

            .history-month-select {
                max-width: none;
            }

            .history-month-grid {
                grid-template-columns: 1fr;
            }

            .history-date-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
</head>

<body class="app-shell">
    @include('partials.nav')

    @php
        $jumlahBulan = $daftarBulan->count();
        $jumlahTanggalDipilih = $tanggalList->count();
        $namaBulanDipilih = $bulanDipilih
            ? \Carbon\Carbon::createFromFormat('Y-m', $bulanDipilih)->locale('id')->translatedFormat('F Y')
            : 'Belum dipilih';
    @endphp

    <main class="page-wrap history-page">
        <header class="history-hero">
            <div>
                <p class="page-kicker">INSPECTION HISTORY</p>
                <h1 class="page-title">Riwayat Inspeksi</h1>
                <p class="history-description">
                    Telusuri riwayat inspeksi berdasarkan bulan dan buka tanggal tertentu
                    untuk melihat detail pemeriksaan perangkap hama.
                </p>
            </div>

            @if ($bulanDipilih)
                <a href="{{ route('entries.export.zip', ['bulan' => $bulanDipilih]) }}" class="btn-secondary">
                    Export ZIP Bulanan
                </a>
            @endif
        </header>

        @if (session('success'))
            <div class="alert mb-0">
                {{ session('success') }}
            </div>
        @endif

        <section class="history-summary">
            <article class="history-summary-card">
                <p class="history-summary-label">Bulan Tercatat</p>
                <p class="history-summary-value">{{ number_format($jumlahBulan) }}</p>
                <p class="history-summary-note">Bulan dengan data inspeksi</p>
            </article>

            <article class="history-summary-card">
                <p class="history-summary-label">Tanggal pada Bulan Terpilih</p>
                <p class="history-summary-value">{{ number_format($jumlahTanggalDipilih) }}</p>
                <p class="history-summary-note">{{ $namaBulanDipilih }}</p>
            </article>

            <article class="history-summary-card">
                <p class="history-summary-label">Bulan Aktif</p>
                <p class="history-summary-value" style="font-size: 22px;">{{ $bulanDipilih ? \Carbon\Carbon::createFromFormat('Y-m', $bulanDipilih)->locale('id')->translatedFormat('M Y') : '—' }}</p>
                <p class="history-summary-note">Bulan yang sedang ditampilkan</p>
            </article>
        </section>

        @if ($tanggalDipilih)
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">Detail Inspeksi</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ \Carbon\Carbon::parse($tanggalDipilih)->locale('id')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4 p-4 sm:p-6">
                    @foreach ($trapsTanggal as $trap)
                        @php
                            $entry = $trap->entries->first();
                            $rekom = $entry?->rekomendasi;
                            $statusApproval = $rekom
                                ? ($rekom->status_persetujuan ?? 'pending')
                                : null;
                            $statusLabel = [
                                'pending' => 'Menunggu keputusan',
                                'disetujui' => 'Disetujui',
                                'ditolak' => 'Ditolak',
                                'perlu_revisi' => 'Perlu revisi',
                            ][$statusApproval] ?? $statusApproval;
                            $statusTone = [
                                'pending' => 'warning',
                                'disetujui' => 'success',
                                'ditolak' => 'danger',
                                'perlu_revisi' => 'warning',
                            ][$statusApproval] ?? 'neutral';
                        @endphp

                        <article class="rounded-xl border border-slate-200 bg-white p-4 sm:p-5">
                            <header class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">
                                        {{ $trap->no_trap }} · {{ $trap->type_detector }}
                                    </h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $trap->spesies_hama }} · {{ $trap->lokasi }}
                                    </p>
                                </div>
                                @if ($entry)
                                    <span class="status-pill success">Sudah diperiksa</span>
                                @elseif ($trap->created_at && $trap->created_at->toDateString() > $tanggalDipilih)
                                    <span class="status-pill neutral">Belum terdaftar pada tanggal ini</span>
                                @elseif ($trap->created_at)
                                    <span class="status-pill warning">Belum diperiksa</span>
                                @else
                                    <span class="status-pill neutral">Status inspeksi tidak dapat ditentukan</span>
                                @endif
                            </header>

                            @if ($entry)
                                <dl class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <dt class="field-label">Aktivitas hama</dt>
                                        <dd>{{ $entry->aktivitas ?: '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="field-label">Tindakan</dt>
                                        <dd class="whitespace-pre-line">{{ $entry->tindakan ?: '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="field-label">Hasil inspeksi</dt>
                                        <dd class="whitespace-pre-line">{{ $entry->hasil ?: '-' }}</dd>
                                    </div>
                                </dl>
                                <p class="mt-3 text-xs text-slate-500">
                                    Identitas Petugas tidak tersedia pada data inspeksi lama.
                                </p>

                                <section class="mt-5 border-t border-slate-100 pt-4">
                                    <h4 class="font-semibold text-slate-900">Rekomendasi Petugas</h4>
                                    @if ($rekom)
                                        <p class="mt-2 whitespace-pre-line text-sm text-slate-700">
                                            {{ $rekom->rekomendasi_catatan ?: 'Tidak ada catatan rekomendasi.' }}
                                        </p>
                                        @if ($rekom->rekomendasi_gambar)
                                            <a
                                                class="mt-2 inline-block text-sm font-medium text-[#1d527d] hover:underline"
                                                href="{{ route('photo.file', ['path' => $rekom->rekomendasi_gambar]) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                <img
                                                    src="{{ route('photo.file', ['path' => $rekom->rekomendasi_gambar]) }}"
                                                    alt="Foto rekomendasi"
                                                    class="mt-2 max-h-48 rounded-lg object-contain"
                                                >
                                                <span>Lihat foto rekomendasi ukuran penuh</span>
                                            </a>
                                        @endif
                                    @else
                                        <p class="mt-2 text-sm text-slate-500">Rekomendasi belum tersedia.</p>
                                    @endif
                                </section>

                                <section class="mt-5 border-t border-slate-100 pt-4">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <h4 class="font-semibold text-slate-900">Approval</h4>
                                        @if ($rekom)
                                            <span class="status-pill {{ $statusTone }}">{{ $statusLabel }}</span>
                                        @else
                                            <span class="status-pill neutral">Tidak ada rekomendasi</span>
                                        @endif
                                    </div>

                                    @if ($rekom)
                                        @if ($rekom->catatan_admin)
                                            <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 p-3 text-sm">
                                                <p class="font-semibold text-amber-800">Catatan keputusan Admin</p>
                                                <p class="mt-1 whitespace-pre-line text-amber-900">{{ $rekom->catatan_admin }}</p>
                                                <p class="mt-2 text-xs text-amber-800">
                                                    {{ $rekom->diputuskan_pada ?? '-' }}
                                                    · {{ $rekom->approver?->name ?? 'Pengguna tidak tersedia' }}
                                                </p>
                                            </div>
                                        @endif

                                        @if (auth()->user()->role === 'admin')
                                            <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                                <form method="POST" action="{{ route('rekomendasi.approve', $rekom) }}">
                                                    @csrf
                                                    <label class="field-label" for="approve-note-{{ $rekom->id }}">
                                                        Catatan persetujuan (opsional)
                                                    </label>
                                                    <textarea
                                                        id="approve-note-{{ $rekom->id }}"
                                                        name="catatan_admin"
                                                        rows="3"
                                                        maxlength="2000"
                                                        class="textarea mb-2 w-full"
                                                    >{{ old('catatan_admin') }}</textarea>
                                                    <button type="submit" class="btn-primary">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('rekomendasi.reject', $rekom) }}">
                                                    @csrf
                                                    <label class="field-label" for="reject-note-{{ $rekom->id }}">
                                                        Alasan penolakan
                                                    </label>
                                                    <textarea
                                                        id="reject-note-{{ $rekom->id }}"
                                                        name="catatan_admin"
                                                        rows="3"
                                                        maxlength="2000"
                                                        required
                                                        class="textarea mb-2 w-full"
                                                    >{{ old('catatan_admin') }}</textarea>
                                                    <button type="submit" class="btn-secondary">Tolak</button>
                                                </form>
                                                <form method="POST" action="{{ route('rekomendasi.revision', $rekom) }}">
                                                    @csrf
                                                    <label class="field-label" for="revision-note-{{ $rekom->id }}">
                                                        Catatan revisi
                                                    </label>
                                                    <textarea
                                                        id="revision-note-{{ $rekom->id }}"
                                                        name="catatan_admin"
                                                        rows="3"
                                                        maxlength="2000"
                                                        required
                                                        class="textarea mb-2 w-full"
                                                    >{{ old('catatan_admin') }}</textarea>
                                                    <button type="submit" class="btn-secondary">Minta revisi</button>
                                                </form>
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <h5 class="text-sm font-semibold text-slate-800">Riwayat keputusan</h5>
                                            @forelse ($rekom->approvalHistories as $history)
                                                <div class="mt-2 border-l-2 border-slate-300 pl-3 text-sm">
                                                    <p class="font-medium">
                                                        {{ strtoupper(str_replace('_', ' ', $history->aksi)) }}
                                                        · {{ $history->user?->name ?? 'Pengguna tidak tersedia' }}
                                                    </p>
                                                    <p class="text-xs text-slate-500">
                                                        {{ $history->status_sebelumnya ?? 'Belum ada status' }}
                                                        → {{ $history->status_sesudahnya }}
                                                        · {{ $history->created_at?->format('d-m-Y H:i') }}
                                                    </p>
                                                    @if ($history->catatan)
                                                        <p class="mt-1 whitespace-pre-line">{{ $history->catatan }}</p>
                                                    @endif
                                                </div>
                                            @empty
                                                <p class="mt-2 text-sm text-slate-500">Belum ada riwayat keputusan.</p>
                                            @endforelse
                                        </div>
                                    @endif
                                </section>

                                <section class="mt-5 border-t border-slate-100 pt-4">
                                    <h4 class="font-semibold text-slate-900">Tindak lanjut perbaikan</h4>
                                    @if ($rekom?->perbaikan_catatan)
                                        <p class="mt-2 whitespace-pre-line text-sm text-slate-700">
                                            {{ $rekom->perbaikan_catatan }}
                                        </p>
                                    @else
                                        <p class="mt-2 text-sm text-slate-500">Belum ada tindak lanjut perbaikan.</p>
                                    @endif
                                    @if ($rekom?->perbaikan_gambar)
                                        <a
                                            class="mt-2 inline-block text-sm font-medium text-[#1d527d] hover:underline"
                                            href="{{ route('photo.file', ['path' => $rekom->perbaikan_gambar]) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            <img
                                                src="{{ route('photo.file', ['path' => $rekom->perbaikan_gambar]) }}"
                                                alt="Foto bukti perbaikan"
                                                class="mt-2 max-h-48 rounded-lg object-contain"
                                            >
                                            <span>Lihat foto bukti perbaikan ukuran penuh</span>
                                        </a>
                                    @endif

                                    @if (auth()->user()->role === 'admin' && $rekom)
                                        <form
                                            method="POST"
                                            action="{{ route('entries.store') }}"
                                            enctype="multipart/form-data"
                                            class="mt-4 max-w-2xl"
                                        >
                                            @csrf
                                            <input type="hidden" name="tanggal" value="{{ $tanggalDipilih }}">
                                            <label class="field-label" for="repair-note-{{ $rekom->id }}">
                                                Catatan perbaikan
                                            </label>
                                            <textarea
                                                id="repair-note-{{ $rekom->id }}"
                                                name="entries[{{ $trap->id }}][perbaikan_catatan]"
                                                rows="3"
                                                maxlength="500"
                                                class="textarea mb-3 w-full"
                                            >{{ $rekom->perbaikan_catatan }}</textarea>
                                            <label class="field-label" for="repair-photo-{{ $rekom->id }}">
                                                Foto bukti perbaikan
                                            </label>
                                            <input
                                                id="repair-photo-{{ $rekom->id }}"
                                                type="file"
                                                name="entries[{{ $trap->id }}][perbaikan_gambar]"
                                                accept="image/*"
                                                class="mb-3 block w-full text-sm"
                                            >
                                            <button type="submit" class="btn-primary">Simpan tindak lanjut</button>
                                        </form>
                                    @endif
                                </section>
                            @endif
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($daftarBulan->isEmpty())
            <section class="panel">
                <div class="history-empty">
                    <div class="history-empty-icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/>
                            <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-slate-800">Belum Ada Riwayat Inspeksi</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Daftar bulan akan muncul setelah terdapat data inspeksi.
                    </p>
                    @if (in_array(auth()->user()->role, ['pengelola', 'operatorpc'], true))
                        <a href="{{ route('entries.create') }}" class="btn-primary mt-5 inline-flex">
                            Buka Input Harian
                        </a>
                    @endif
                </div>
            </section>
        @else
            <section class="panel">
                <div class="history-toolbar">
                    <div>
                        <h2 class="panel-title">Pilih Bulan Inspeksi</h2>
                        <p class="mt-1 text-sm text-slate-500">Pilih bulan untuk melihat kalender dan tanggal yang memiliki data.</p>
                    </div>

                    <form action="{{ route('entries.riwayat') }}" method="GET">
                        <label for="bulan" class="field-label">Bulan dan Tahun</label>
                        <select id="bulan" name="bulan" class="select history-month-select" onchange="this.form.submit()">
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

                <div class="p-4 sm:p-6">
                    <div class="history-month-grid">
                        @foreach ($daftarBulan as $bulan)
                            @php
                                $tanggalBulan = $bulan === $bulanDipilih ? $tanggalList : collect();

                                $jumlahHari = $bulan === $bulanDipilih
                                    ? $tanggalBulan->count()
                                    : \App\Models\Entry::whereRaw(
                                        "DATE_FORMAT(tanggal, '%Y-%m') = ?",
                                        [$bulan]
                                    )->distinct()->count('tanggal');

                                $namaBulan = \Carbon\Carbon::createFromFormat('Y-m', $bulan)
                                    ->locale('id')
                                    ->translatedFormat('F Y');
                            @endphp

                            <a
                                href="{{ route('entries.kalender', ['bulan' => $bulan]) }}"
                                class="history-month-card {{ $bulan === $bulanDipilih ? 'is-selected' : '' }}"
                            >
                                <div>
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="history-month-icon">
                                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="3" y="4" width="18" height="17" rx="2" stroke-width="1.7"/>
                                                <path d="M16 2v4M8 2v4M3 10h18" stroke-width="1.7" stroke-linecap="round"/>
                                            </svg>
                                        </div>

                                        @if ($bulan === $bulanDipilih)
                                            <span class="history-selected-pill">Dipilih</span>
                                        @else
                                            <svg width="20" height="20" class="text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <h3 class="history-month-name">{{ $namaBulan }}</h3>
                                    <p class="history-month-meta">{{ $jumlahHari }} tanggal memiliki data inspeksi</p>
                                </div>

                                <div class="history-card-footer">
                                    <span>Lihat kalender</span>
                                    <span aria-hidden="true">→</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="panel-title">Ringkasan Tanggal Inspeksi</h2>
                        <p class="mt-1 text-sm text-slate-500">Pilih tanggal untuk membuka detail inspeksi harian.</p>
                    </div>
                    <span class="badge badge-neutral">{{ $namaBulanDipilih }}</span>
                </div>

                <div class="p-4 sm:p-6">
                    <div class="history-date-list">
                        @forelse ($tanggalList as $tanggal)
                            <a href="{{ route('entries.riwayat', ['bulan' => $bulanDipilih, 'tanggal' => $tanggal]) }}"
                               class="history-date-card">
                                <span class="history-date-weekday">
                                    {{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l') }}
                                </span>
                                <span class="history-date-name">
                                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                </span>
                                <span class="history-date-action">Buka detail inspeksi →</span>
                            </a>
                        @empty
                            <div class="history-empty" style="grid-column: 1 / -1;">
                                Tidak ada tanggal inspeksi pada bulan ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        @endif
    </main>
</body>
</html>
