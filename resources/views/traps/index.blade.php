<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Trap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div>
                <p class="page-kicker">Master Data</p>
                <h1 class="page-title">Data Trap</h1>
            </div>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('traps.create') }}" class="btn-primary">
                    + Tambah Trap Baru
                </a>
            @endif
        </header>

        @if (session('success'))
            <div class="alert mb-6">
                {{ session('success') }}
            </div>
        @endif

        @foreach ($grouped as $type => $traps)
            <section class="panel mb-6">
                <div class="panel-header">
                    <h2 class="panel-title">{{ $type }}</h2>
                    <span class="badge badge-neutral">{{ $traps->count() }} item</span>
                </div>

                <div class="table-wrapper p-3 sm:p-5">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No. Trap</th>
                                <th>Spesies</th>
                                <th>Lokasi</th>
                                @if (auth()->user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traps as $trap)
                                <tr>
                                    <td><span class="font-semibold text-slate-700">{{ $trap->no_trap }}</span></td>
                                    <td>{{ $trap->spesies_hama }}</td>
                                    <td>{{ $trap->lokasi }}</td>
                                    @if (auth()->user()->role === 'admin')
                                        <td>
                                            <a href="{{ route('traps.edit', $trap) }}" class="btn-secondary">Edit</a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endforeach
    </div>
</body>
</html>