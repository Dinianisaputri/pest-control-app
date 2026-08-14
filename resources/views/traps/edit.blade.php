<!DOCTYPE html>
<html>
<head><title>Edit Trap</title></head>
<body>
    @include('partials.nav')
    <h1>Edit Trap #{{ $trap->no_trap }}</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('traps.update', $trap) }}">
        @csrf
        @method('PUT')

        <label>No. Trap:</label><br>
        <input type="text" name="no_trap" value="{{ old('no_trap', $trap->no_trap) }}"><br><br>

        <label>Type Detector:</label><br>
        <select name="type_detector">
            @foreach (['P. Lalat', 'Insect Light', 'Rodent Baint Stat', 'Rodent Baint Stat Box', 'P. Kucing'] as $type)
                <option value="{{ $type }}" {{ $trap->type_detector == $type ? 'selected' : '' }}>{{ $type }}</option>
            @endforeach
        </select><br><br>

        <label>Spesies Hama:</label><br>
        <input type="text" name="spesies_hama" value="{{ old('spesies_hama', $trap->spesies_hama) }}"><br><br>

        <label>Lokasi:</label><br>
        <input type="text" name="lokasi" value="{{ old('lokasi', $trap->lokasi) }}"><br><br>

        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('traps.index') }}">Batal</a>
    </form>

    <form method="POST" action="{{ route('traps.destroy', $trap) }}" onsubmit="return confirm('Yakin mau hapus trap ini?')" style="margin-top: 10px;">
        @csrf
        @method('DELETE')
        <button type="submit" style="color: red;">Hapus Trap Ini</button>
    </form>
</body>
</html>