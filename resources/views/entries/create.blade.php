<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Harian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <span>📊</span>
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


                    <!-- STATUS -->
                    <div class="status-stack">

                        <span class="status-pill success">
                            <span class="status-dot"></span>
                            R ready
                        </span>

                        <span class="status-pill warning">
                            <span class="status-dot"></span>
                            P pending
                        </span>

                    </div>

                </div>


                <!-- TABLE -->
                <div class="table-wrapper p-3 sm:p-5">

                    <table
                        class="data-table"
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
                                <th>Perbaikan</th>
                                <th>Status</th>
                            </tr>

                        </thead>


                        <tbody>

                            @foreach ($traps as $trap)

                                @php

                                    $existing = $existingEntries->get($trap->id);

                                    $rekom = optional($existing)->rekomendasi;

                                    $adaRekomendasi =
                                        $rekom &&
                                        (
                                            $rekom->rekomendasi_catatan ||
                                            $rekom->rekomendasi_gambar
                                        );

                                    $adaPerbaikan =
                                        $rekom &&
                                        (
                                            $rekom->perbaikan_catatan ||
                                            $rekom->perbaikan_gambar
                                        );

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

                                        <select
                                            name="entries[{{ $trap->id }}][aktivitas]"
                                            class="select"
                                        >

                                            <option
                                                value="LOW"
                                                {{ optional($existing)->aktivitas == 'LOW' ? 'selected' : '' }}
                                            >
                                                LOW
                                            </option>

                                            <option
                                                value="MEDIUM"
                                                {{ optional($existing)->aktivitas == 'MEDIUM' ? 'selected' : '' }}
                                            >
                                                MEDIUM
                                            </option>

                                            <option
                                                value="HIGH"
                                                {{ optional($existing)->aktivitas == 'HIGH' ? 'selected' : '' }}
                                            >
                                                HIGH
                                            </option>

                                        </select>

                                    </td>


                                    <!-- TINDAKAN -->
                                    <td>

                                        <input
                                            type="text"
                                            name="entries[{{ $trap->id }}][tindakan]"
                                            value="{{ optional($existing)->tindakan }}"
                                            class="input"
                                        >

                                    </td>


                                    <!-- HASIL -->
                                    <td>

                                        <input
                                            type="text"
                                            name="entries[{{ $trap->id }}][hasil]"
                                            value="{{ optional($existing)->hasil }}"
                                            class="input"
                                        >

                                    </td>


                                    <!-- REKOMENDASI -->
                                    <td>

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
                                            class="mt-3 block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-[#fff0d2] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#0B1F3A] hover:file:bg-[#ffe1ad]"
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

                                    </td>


                                    <!-- PERBAIKAN -->
                                    <td>

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
                                            class="mt-3 block w-full text-sm text-slate-500 file:mr-4 file:rounded-full file:border-0 file:bg-[#fff0d2] file:px-3 file:py-2 file:text-sm file:font-semibold file:text-[#0B1F3A] hover:file:bg-[#ffe1ad]"
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

                                    </td>


                                    <!-- STATUS -->
                                    <td class="text-center">

                                        <div class="flex justify-center gap-2">

                                            <span
                                                title="Rekomendasi"
                                                class="inline-block h-4 w-4 rounded-full border border-white shadow-sm"
                                                style="background: {{ $adaRekomendasi ? '#1d527d' : '#0B1F3A' }};"
                                            ></span>


                                            <span
                                                title="Perbaikan"
                                                class="inline-block h-4 w-4 rounded-full border border-white shadow-sm"
                                                style="background: {{ $adaPerbaikan ? '#1d527d' : '#0B1F3A' }};"
                                            ></span>

                                        </div>


                                        <div class="mt-2 text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                                            R / P
                                        </div>

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