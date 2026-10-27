<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trap</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-shell">
    @include('partials.nav')

    <main class="page-wrap trap-form-page">
        <header class="page-header">
            <div>
                <p class="page-kicker">Master Data</p>
                <h1 class="page-title">Edit Trap #{{ $trap->no_trap }}</h1>
                <p class="mt-2 text-sm text-slate-600">Perbarui informasi titik monitoring yang dipilih.</p>
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

        @if (session('error'))
            <div class="alert-error mb-6" role="alert">{{ session('error') }}</div>
        @endif

        <section class="form-card trap-form-card mx-auto max-w-3xl">
            <div class="mb-5 border-b border-slate-200 pb-4">
                <h2 class="panel-title">Informasi perangkap</h2>
                <p class="mt-1 text-sm text-slate-500">Periksa kembali detail sebelum menyimpan perubahan.</p>
            </div>
            <form method="POST" action="{{ route('traps.update', $trap) }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="trap-form-grid">
                    <div>
                        <label for="no_trap" class="field-label">No. Trap <span class="text-red-600">*</span></label>
                        <input id="no_trap" type="text" name="no_trap" value="{{ old('no_trap', $trap->no_trap) }}" maxlength="10" required autocomplete="off" aria-describedby="no_trap_help no_trap_error" @class(['input', 'is-invalid' => $errors->has('no_trap')])>
                        <p id="no_trap_help" class="mt-1 text-xs text-slate-500">Maksimal 10 karakter.</p>
                        @error('no_trap') <p id="no_trap_error" class="field-error" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type_detector" class="field-label">Jenis Detector <span class="text-red-600">*</span></label>
                        <select id="type_detector" name="type_detector" required aria-describedby="type_detector_error" @class(['select', 'is-invalid' => $errors->has('type_detector')])>
                            <option value="">Pilih jenis detector</option>
                            @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
                                <option value="{{ $type }}" @selected(old('type_detector', $trap->type_detector) === $type)>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type_detector') <p id="type_detector_error" class="field-error" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="spesies_hama" class="field-label">Spesies Hama <span class="text-red-600">*</span></label>
                        <input id="spesies_hama" type="text" name="spesies_hama" value="{{ old('spesies_hama', $trap->spesies_hama) }}" maxlength="50" required autocomplete="off" aria-describedby="spesies_hama_error" @class(['input', 'is-invalid' => $errors->has('spesies_hama')])>
                        @error('spesies_hama') <p id="spesies_hama_error" class="field-error" role="alert">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="lokasi" class="field-label">Lokasi <span class="text-red-600">*</span></label>
                        <input id="lokasi" type="text" name="lokasi" value="{{ old('lokasi', $trap->lokasi) }}" maxlength="100" required autocomplete="off" aria-describedby="lokasi_error" @class(['input', 'is-invalid' => $errors->has('lokasi')])>
                        @error('lokasi') <p id="lokasi_error" class="field-error" role="alert">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-between">
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
        </section>
    </main>
</body>
</html>