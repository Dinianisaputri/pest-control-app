<!DOCTYPE html>
<html>
<head><title>Tambah Trap</title></head>
<body>
    @include('partials.nav')
    <h1>Tambah Trap Baru</h1>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('traps.store') }}">
        @csrf
        <label>No. Trap:</label><br>
        <input type="text" name="no_trap" value="{{ old('no_trap') }}"><br><br>

        <label>Type Detector:</label><br>
        <select name="type_detector">
            <option value="P. Lalat">P. Lalat</option>
            <option value="Insect Light">Insect Light</option>
            <option value="Rodent Baint Stat">Rodent Baint Stat</option>
            <option value="Rodent Baint Stat Box">Rodent Baint Stat Box</option>
            <option value="P. Kucing">P. Kucing</option>
        </select><br><br>

        <label>Spesies Hama:</label><br>
        <input type="text" name="spesies_hama" value="{{ old('spesies_hama') }}"><br><br>

        <label>Lokasi:</label><br>
        <input type="text" name="lokasi" value="{{ old('lokasi') }}"><br><br>

        <button type="submit">Simpan</button>
        <a href="{{ route('traps.index') }}">Batal</a>
    </form>
</body>
</html>
