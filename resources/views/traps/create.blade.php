<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Trap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div>
                <p class="page-kicker">Master Data</p>
                <h1 class="page-title">Tambah Trap Baru</h1>
            </div>
        </header>

        @if ($errors->any())
            <div class="alert-error mb-6">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card mx-auto max-w-2xl">
            <form method="POST" action="{{ route('traps.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="no_trap" class="field-label">No. Trap</label>
                    <input id="no_trap" type="text" name="no_trap" value="{{ old('no_trap') }}" class="input">
                </div>

                <div>
                    <label for="type_detector" class="field-label">Type Detector</label>
                    <select id="type_detector" name="type_detector" class="select">
                        <option value="P. Lalat">P. Lalat</option>
                        <option value="Insect Light">Insect Light</option>
                        <option value="Rodent Baint Stat">Rodent Baint Stat</option>
                        <option value="Rodent Baint Stat Box">Rodent Baint Stat Box</option>
                        <option value="P. Kucing">P. Kucing</option>
                    </select>
                </div>

                <div>
                    <label for="spesies_hama" class="field-label">Spesies Hama</label>
                    <input id="spesies_hama" type="text" name="spesies_hama" value="{{ old('spesies_hama') }}" class="input">
                </div>

                <div>
                    <label for="lokasi" class="field-label">Lokasi</label>
                    <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi') }}" class="input">
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-end">
                    <a href="{{ route('traps.index') }}" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
