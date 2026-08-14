<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <div class="page-wrap">
        <header class="page-header">
            <div>
                <p class="page-kicker">Master Data</p>
                <h1 class="page-title">Edit Trap #{{ $trap->no_trap }}</h1>
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
            <form method="POST" action="{{ route('traps.update', $trap) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="no_trap" class="field-label">No. Trap</label>
                    <input id="no_trap" type="text" name="no_trap" value="{{ old('no_trap', $trap->no_trap) }}" class="input">
                </div>

                <div>
                    <label for="type_detector" class="field-label">Type Detector</label>
                    <select id="type_detector" name="type_detector" class="select">
                        @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
                            <option value="{{ $type }}" {{ $trap->type_detector == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="spesies_hama" class="field-label">Spesies Hama</label>
                    <input id="spesies_hama" type="text" name="spesies_hama" value="{{ old('spesies_hama', $trap->spesies_hama) }}" class="input">
                </div>

                <div>
                    <label for="lokasi" class="field-label">Lokasi</label>
                    <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $trap->lokasi) }}" class="input">
                </div>

                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:justify-between">
                    <a href="{{ route('traps.index') }}" class="btn-secondary">Batal</a>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('traps.destroy', $trap) }}" onsubmit="return confirm('Yakin mau hapus trap ini?')" class="mt-6 border-t border-slate-200 pt-5">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Hapus Trap Ini</button>
            </form>
        </div>
    </div>
</body>
</html>