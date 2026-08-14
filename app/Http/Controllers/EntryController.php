<?php

namespace App\Http\Controllers;

use App\Models\Trap;
use App\Models\Entry;
use App\Http\Requests\StoreEntryRequest;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function create(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->format('Y-m-d'));

        $traps = Trap::orderBy('type_detector')->orderBy('no_trap')->get();

        $existingEntries = Entry::where('tanggal', $tanggal)->get()->keyBy('trap_id');

        return view('entries.create', compact('traps', 'tanggal', 'existingEntries'));
    }

    public function store(StoreEntryRequest $request)
{
    $tanggal = $request->input('tanggal');
    $data = $request->input('entries', []);
    $files = $request->file('entries', []);

    foreach ($data as $trapId => $row) {
        $adaIsi = !empty($row['tindakan']) || !empty($row['hasil'])
            || !empty($row['rekomendasi_catatan']) || !empty($row['perbaikan_catatan']);

        if (!$adaIsi && empty($files[$trapId]['rekomendasi_gambar']) && empty($files[$trapId]['perbaikan_gambar'])) {
            continue;
        }

        $entry = Entry::updateOrCreate(
            ['trap_id' => $trapId, 'tanggal' => $tanggal],
            [
                'tindakan' => $row['tindakan'] ?? null,
                'aktivitas' => $row['aktivitas'] ?? 'LOW',
                'hasil' => $row['hasil'] ?? null,
            ]
        );

        $update = array_filter([
            'rekomendasi_catatan' => $row['rekomendasi_catatan'] ?? null,
            'perbaikan_catatan' => $row['perbaikan_catatan'] ?? null,
        ]);

        if (isset($files[$trapId]['rekomendasi_gambar']) && $files[$trapId]['rekomendasi_gambar']) {
            $update['rekomendasi_gambar'] = $files[$trapId]['rekomendasi_gambar']->store('rekomendasi', 'public');
        }

        if (isset($files[$trapId]['perbaikan_gambar']) && $files[$trapId]['perbaikan_gambar']) {
            $update['perbaikan_gambar'] = $files[$trapId]['perbaikan_gambar']->store('perbaikan', 'public');
        }

        if (!empty($update)) {
            $entry->rekomendasi()->updateOrCreate(['entry_id' => $entry->id], $update);
        }
    }

    return redirect()->route('entries.create', ['tanggal' => $tanggal])
        ->with('success', 'Data berhasil disimpan!');
}
    public function export(Request $request)
    {
        $tanggal = $request->query('tanggal');

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PestControlExport($tanggal),
            'pest-control-' . $tanggal . '.xlsx'
        );
    }

    public function riwayat(Request $request)
    {
        $tanggalList = Entry::select('tanggal')->distinct()->orderBy('tanggal', 'desc')->pluck('tanggal');

        $tanggalDipilih = $request->query('tanggal', $tanggalList->first());

        $traps = Trap::with(['entries' => function ($query) use ($tanggalDipilih) {
            $query->where('tanggal', $tanggalDipilih)->with('rekomendasi');
        }])->orderBy('type_detector')->orderBy('no_trap')->get();

        return view('entries.riwayat', compact('tanggalList', 'tanggalDipilih', 'traps'));
    }
}