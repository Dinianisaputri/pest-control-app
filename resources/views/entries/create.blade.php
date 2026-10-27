<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Input Harian</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Penyegaran visual: struktur Blade, route, form, dan logika tetap dipertahankan. */
        .page-wrap { max-width: 1600px; }
        .page-header { align-items: flex-start; gap: 18px; padding: 20px 24px; }
        .page-header .page-title { letter-spacing: -.035em; }
        .inspection-table-wrapper {
            max-width: 100%;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            border-radius: 14px;
            background: #fff;
        }
        .inspection-table {
            width: 100%;
            min-width: 0;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
        }
        .inspection-table th, .inspection-table td {
            padding: 8px 7px;
            vertical-align: top;
            overflow-wrap: anywhere;
        }
        .inspection-table th {
            white-space: normal;
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f7f9fc;
            color: #617087;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .035em;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
        }
        .inspection-table th:nth-child(1), .inspection-table td:nth-child(1) { width: 5%; }
        .inspection-table th:nth-child(2), .inspection-table td:nth-child(2) { width: 7%; }
        .inspection-table th:nth-child(3), .inspection-table td:nth-child(3) { width: 8%; }
        .inspection-table th:nth-child(4), .inspection-table td:nth-child(4) { width: 8%; }
        .inspection-table th:nth-child(5), .inspection-table td:nth-child(5) { width: 11%; }
        .inspection-table th:nth-child(6), .inspection-table td:nth-child(6) { width: 9%; }
        .inspection-table th:nth-child(7), .inspection-table td:nth-child(7) { width: 16%; }
        .inspection-table th:nth-child(8), .inspection-table td:nth-child(8) { width: 13%; }
        .inspection-table th:nth-child(9), .inspection-table td:nth-child(9) { width: 23%; }
        .inspection-table tbody tr { transition: background .15s ease; }
        .inspection-table tbody tr:hover { background: #f8fafc; }
        .inspection-table tbody td {
            border-bottom: 1px solid #eef2f7;
            font-size: 11px;
            line-height: 1.45;
        }
        .inspection-table tbody tr:last-child td { border-bottom: 0; }
        .inspection-table td:first-child span {
            display: inline-flex;
            max-width: 100%;
            padding: 4px 6px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            background: #f8fafc;
            color: #334155;
            font-size: 10px;
            overflow-wrap: anywhere;
        }
        .inspection-table .input, .inspection-table .select, .inspection-table .textarea,
        .inspection-table input.input, .inspection-table select.select, .inspection-table textarea.textarea {
            width: 100%;
            min-width: 0;
            box-sizing: border-box;
            min-height: 32px;
            margin-top: 0;
            padding: 6px 7px;
            border-radius: 7px;
            font-size: 11px;
        }
        .inspection-table textarea,
        .inspection-table .textarea { resize: vertical; min-height: 54px; line-height: 1.4; }
        .inspection-table input[type="file"] { display: block; max-width: 100%; margin-top: 6px; font-size: 9px; }
        .inspection-table input[type="file"]::file-selector-button { max-width: 100%; margin-right: 4px; padding: 4px 6px; border: 1px solid #d5dee8; border-radius: 5px; background: #f8fafc; color: #52627a; font: inherit; }
        .inspection-table td:nth-child(8) { background: #fafbfd; }
        .inspection-table td:nth-child(8) > .space-y-3 { display: grid; gap: 8px; }
        .inspection-table td:nth-child(8) details { border-color: #dce4ec; background: #fff; }
        .inspection-table details > summary { list-style-position: inside; overflow-wrap: anywhere; }
        .inspection-table details[open] { background: #fff; }
        .inspection-table td:nth-child(8) .status-pill { padding: 4px 7px; font-size: 9px; }
        .inspection-table td.min-w-\[200px\] { min-width: 0 !important; }
        .inspection-table td p { overflow-wrap: anywhere; }
        #searchResult { min-height: 20px; }
        #saveAllSection {
            position: static;
            z-index: auto;
            margin-top: 1rem;
            padding: 10px 0 0;
            border: 1px solid #e2e8f0;
            border-width: 1px 0 0;
            border-radius: 0;
            background: transparent;
            box-shadow: none;
            backdrop-filter: none;
        }
        .jump-controls-wrap {
            position: static;
            z-index: auto;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            gap: 8px;
            margin: 0 0 10px;
        }
        .jump-controls-wrap .jump-control {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            font-size: 14px;
        }
        @media (max-width: 1100px) {
            .inspection-table th, .inspection-table td { padding: 6px 5px; }
            .inspection-table tbody td { font-size: 10px; }
            .inspection-table input.input, .inspection-table select.select, .inspection-table textarea.textarea { font-size: 10px; }
        }
        @media (max-width: 760px) {
            .inspection-table-wrapper { overflow-x: auto; }
            .inspection-table,
            .inspection-table tbody,
            .inspection-table tr,
            .inspection-table td { display: block; width: 100%; }
            .inspection-table thead { display: none; }
            .inspection-table tbody tr {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                margin-bottom: 12px;
                padding: 12px;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                background: #fff;
            }
            .inspection-table tbody tr:last-child { margin-bottom: 0; }
            .inspection-table tbody td {
                min-width: 0;
                padding: 0;
                border: 0;
                background: transparent !important;
                font-size: 11px;
            }
            .inspection-table tbody td::before {
                display: block;
                margin-bottom: 4px;
                color: #718096;
                content: "";
                font-size: 9px;
                font-weight: 700;
                letter-spacing: .04em;
                text-transform: uppercase;
            }
            .inspection-table tbody td:nth-child(1)::before { content: "No. Trap"; }
            .inspection-table tbody td:nth-child(2)::before { content: "Jenis"; }
            .inspection-table tbody td:nth-child(3)::before { content: "Lokasi"; }
            .inspection-table tbody td:nth-child(4)::before { content: "Aktivitas"; }
            .inspection-table tbody td:nth-child(5)::before { content: "Tindakan"; }
            .inspection-table tbody td:nth-child(6)::before { content: "Hasil"; }
            .inspection-table tbody td:nth-child(7)::before { content: "Rekomendasi"; }
            .inspection-table tbody td:nth-child(8)::before { content: "Ringkasan"; }
            .inspection-table tbody td:nth-child(9)::before { content: "Perbaikan"; }
            .inspection-table tbody td:nth-child(n+7) { grid-column: 1 / -1; }
            .inspection-table td:first-child span { padding: 3px 5px; }
            .inspection-table input.input,
            .inspection-table select.select,
            .inspection-table textarea.textarea { min-height: 34px; padding: 6px; font-size: 11px; }
            .inspection-table textarea,
            .inspection-table .textarea { min-height: 58px; }
            .inspection-table input[type="file"] { font-size: 10px; }
            .inspection-table td:nth-child(8) > .space-y-3 { gap: 8px; }
        }
    </style>

</head>

<body class="app-shell">

    @include('partials.nav')

    <div class="page-wrap">

        <!-- HEADER -->

        <header class="page-header">

            <div>

                <p class="page-kicker">Operational Input</p>

                <h1 class="page-title">Input Harian Pest Control</h1>

            </div>

        </header>

        <!-- ALERT SUCCESS -->

        @if(session('success'))

            <div class="alert mb-6">

                {{ session('success') }}

            </div>

        @endif

        <!-- ALERT ERROR -->

        @if ($errors->any())

            <div class="alert-error mb-6">

                <ul class="list-disc space-y-1 pl-5">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <!-- FILTER BAR -->

        <section class="form-card mb-6">

            <div class="flex flex-col gap-4 lg:flex-row lg:items-end">

                <!-- TANGGAL -->

                <form

                    method="GET"

                    action="{{ route('entries.create') }}"

                    class="w-full lg:w-64"

                >

                    <label

                        for="tanggal"

                        class="field-label"

                    >

                        Pilih Tanggal

                    </label>

                    <input

                        id="tanggal"

                        type="date"

                        name="tanggal"

                        value="{{ $tanggal }}"

                        onchange="this.form.submit()"

                        class="input w-full"

                    >

                </form>

                <!-- SEARCH -->

                <div class="w-full lg:flex-1">

                    <label

                        for="searchInput"

                        class="field-label"

                    >

                        Cari Data Trap

                    </label>

                    <input

                        type="text"

                        id="searchInput"

                        placeholder="🔍 Cari No. Trap, Jenis, atau Lokasi..."

                        onkeyup="filterTable()"

                        class="input w-full"

                    >

                </div>

                <!-- EXPORT -->

                <div class="w-full lg:w-auto">

                    <label class="field-label invisible hidden lg:block">

                        Export

                    </label>

                    <a

                        href="{{ route('entries.export', ['tanggal' => $tanggal]) }}"

                        class="btn-secondary flex w-full items-center justify-center gap-2 whitespace-nowrap lg:w-auto"

                    >

                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm4 0v16m6-16v16M3 9h18m-18 6h18" />
                        </svg>

                        <span>Export Excel</span>

                    </a>

                </div>

            </div>

        </section>

        <div class="jump-controls-wrap">

            <button

                type="button"

                id="jumpToTopBtn"

                class="jump-control"

                aria-label="Kembali ke atas"

                title="Ke Atas"

            >

                ↑

            </button>

            <button

                type="button"

                id="jumpToSaveBtn"

                class="jump-control jump-control--primary"

                aria-label="Lanjut ke tombol simpan semua"

                title="Lanjut ke Simpan Semua"

            >

                ↓

            </button>

        </div>

        <!-- FORM INPUT -->

        <form

            method="POST"

            action="{{ route('entries.store') }}"

            enctype="multipart/form-data"

        >

            @csrf

            <input

                type="hidden"

                name="tanggal"

                value="{{ $tanggal }}"

            >

            <!-- PANEL INSPEKSI -->

            <section class="panel">

                <!-- PANEL HEADER -->

                <div class="panel-header">

                    <div>

                        <h2 class="panel-title">

                            Data inspeksi trap

                        </h2>

                        <p

                            id="searchResult"

                            class="mt-1 text-sm text-slate-500"

                        >

                            Menampilkan semua data trap

                        </p>

                    </div>

                </div>

                <!-- TABLE -->

                <div class="table-wrapper inspection-table-wrapper p-3 sm:p-5">

                    <table

                        class="data-table inspection-table"

                        id="entryTable"

                    >

                        <thead>

                            <tr>

                                <th>No. Trap</th>

                                <th>Jenis</th>

                                <th>Lokasi</th>

                                <th>Aktivitas</th>

                                <th>Tindakan</th>

                                <th>Hasil</th>

                                <th>Rekomendasi</th>

                                <th>Ringkasan</th>

                                <th>Perbaikan</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($traps as $trap)

@php

    $existing = $existingEntries->get($trap->id);

    $rekom = optional($existing)->rekomendasi;

    $adaRekomendasi = $rekom &&

        ($rekom->rekomendasi_catatan || $rekom->rekomendasi_gambar);

    $adaPerbaikan = $rekom &&

        ($rekom->perbaikan_catatan || $rekom->perbaikan_gambar);

@endphp

                                <tr>

                                    <!-- NO TRAP -->

                                    <td>

                                        <span class="font-semibold text-slate-700">

                                            {{ $trap->no_trap }}

                                        </span>

                                    </td>

                                    <!-- JENIS -->

                                    <td>

                                        {{ $trap->type_detector }}

                                    </td>

                                    <!-- LOKASI -->

                                    <td>

                                        {{ $trap->lokasi }}

                                    </td>

                                    <!-- AKTIVITAS -->

<td>

    @if (auth()->user()->role === 'admin')

        {{ optional($existing)->aktivitas ?: '-' }}

    @else

        <select

            name="entries[{{ $trap->id }}][aktivitas]"

            class="select"

        >

            <option value="LOW" {{ optional($existing)->aktivitas == 'LOW' ? 'selected' : '' }}>LOW</option>

            <option value="MEDIUM" {{ optional($existing)->aktivitas == 'MEDIUM' ? 'selected' : '' }}>MEDIUM</option>

            <option value="HIGH" {{ optional($existing)->aktivitas == 'HIGH' ? 'selected' : '' }}>HIGH</option>

        </select>

    @endif

</td>

                                    <!-- TINDAKAN -->

<td>

    @if (auth()->user()->role === 'admin')

        {{ optional($existing)->tindakan ?: '-' }}

    @else

        <input

            type="text"

            name="entries[{{ $trap->id }}][tindakan]"

            value="{{ optional($existing)->tindakan }}"

            class="input"

        >

    @endif

</td>

                                    <!-- HASIL -->

<td>

    @if (auth()->user()->role === 'admin')

        {{ optional($existing)->hasil ?: '-' }}

    @else

        <input

            type="text"

            name="entries[{{ $trap->id }}][hasil]"

            value="{{ optional($existing)->hasil }}"

            class="input"

        >

    @endif

</td>

{{-- REKOMENDASI: diisi Petugas --}}

<td>

    @if (auth()->user()->role === 'admin')

        <p class="whitespace-pre-line">

            {{ optional($rekom)->rekomendasi_catatan ?: '-' }}

        </p>

        @if (optional($rekom)->rekomendasi_gambar)

            <a

                href="{{ route('photo.file', ['path' => $rekom->rekomendasi_gambar]) }}"

                target="_blank"

                class="mt-2 inline-block text-xs font-medium text-[#1d527d] hover:underline"

            >

                Lihat foto rekomendasi

            </a>

        @endif

    @else

        <textarea

            name="entries[{{ $trap->id }}][rekomendasi_catatan]"

            rows="2"

            placeholder="Catatan rekomendasi"

            class="textarea"

        >{{ optional($rekom)->rekomendasi_catatan }}</textarea>

        <input

            type="file"

            name="entries[{{ $trap->id }}][rekomendasi_gambar]"

            accept="image/*"

            class="mt-3 block w-full text-sm"

        >

        @if (optional($rekom)->rekomendasi_gambar)

            <a

                href="{{ route('photo.file', ['path' => $rekom->rekomendasi_gambar]) }}"

                target="_blank"

                class="mt-2 inline-block text-xs font-medium text-[#1d527d] hover:underline"

            >

                Lihat foto lama

            </a>

        @endif

    @endif

</td>

<!-- RINGKASAN -->

                    <td class="min-w-[200px]">

                        <div class="space-y-2 text-xs text-slate-500">

                            <div>Rekomendasi:

                                <span class="{{ $adaRekomendasi ? 'font-semibold text-emerald-700' : 'text-slate-400' }}">

                                    {{ $adaRekomendasi ? 'Terisi' : 'Belum ada' }}

                                </span>

                            </div>

                            <div>Perbaikan:

                                <span class="{{ $adaPerbaikan ? 'font-semibold text-emerald-700' : 'text-slate-400' }}">

                                    {{ $adaPerbaikan ? 'Terisi' : 'Belum ada' }}

                                </span>

                            </div>

                        </div>

                    </td>

{{-- PERBAIKAN: diisi Admin --}}

<td>

    @if (auth()->user()->role === 'admin')

        <textarea

            name="entries[{{ $trap->id }}][perbaikan_catatan]"

            rows="2"

            placeholder="Catatan perbaikan"

            class="textarea"

        >{{ optional($rekom)->perbaikan_catatan }}</textarea>

        <input

            type="file"

            name="entries[{{ $trap->id }}][perbaikan_gambar]"

            accept="image/*"

            class="mt-3 block w-full text-sm"

        >

        @if (optional($rekom)->perbaikan_gambar)

            <a

                href="{{ route('photo.file', ['path' => $rekom->perbaikan_gambar]) }}"

                target="_blank"

                class="mt-2 inline-block text-xs font-medium text-[#1d527d] hover:underline"

            >

                Lihat foto lama

            </a>

        @endif

    @else

        <p class="whitespace-pre-line">

            {{ optional($rekom)->perbaikan_catatan ?: '-' }}

        </p>

        @if (optional($rekom)->perbaikan_gambar)

            <a

                href="{{ route('photo.file', ['path' => $rekom->perbaikan_gambar]) }}"

                target="_blank"

                class="mt-2 inline-block text-xs font-medium text-[#1d527d] hover:underline"

            >

                Lihat foto perbaikan

            </a>

        @endif

    @endif

</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </section>

            <!-- SIMPAN -->

            <div id="saveAllSection" class="mt-6 flex justify-end">

                <button

                    type="submit"

                    class="btn-primary"

                >

                    Simpan Semua

                </button>

            </div>

        </form>

    </div>

    <!-- SEARCH SCRIPT -->

    <script>

        document.getElementById('jumpToTopBtn')?.addEventListener('click', function () {

            window.scrollTo({

                top: 0,

                behavior: 'smooth'

            });

        });

        document.getElementById('jumpToSaveBtn')?.addEventListener('click', function () {

            document.getElementById('saveAllSection')?.scrollIntoView({

                behavior: 'smooth',

                block: 'start'

            });

        });

        function filterTable() {

            const input =

                document.getElementById('searchInput');

            const filter =

                input.value.toLowerCase().trim();

            const table =

                document.getElementById('entryTable');

            const rows =

                table.querySelectorAll('tbody tr');

            const resultText =

                document.getElementById('searchResult');

            let visibleCount = 0;

            rows.forEach(row => {

                const cells =

                    row.querySelectorAll('td');

                const noTrap =

                    cells[0]?.textContent.toLowerCase() || '';

                const jenis =

                    cells[1]?.textContent.toLowerCase() || '';

                const lokasi =

                    cells[2]?.textContent.toLowerCase() || '';

                const match =

                    noTrap.includes(filter) ||

                    jenis.includes(filter) ||

                    lokasi.includes(filter);

                if (match) {

                    row.style.display = '';

                    visibleCount++;

                } else {

                    row.style.display = 'none';

                }

            });

            if (filter === '') {

                resultText.textContent =

                    'Menampilkan semua data trap';

            } else {

                resultText.textContent =

                    `Menampilkan ${visibleCount} data trap`;

            }

        }

    </script>

</body>

</html>
