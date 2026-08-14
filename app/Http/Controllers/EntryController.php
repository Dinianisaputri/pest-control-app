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
            if (empty($row['tindakan']) && empty($row['hasil']) && empty($row['catatan'])) {
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

            $catatan = $row['catatan'] ?? null;
            $gambarPath = null;

            if (isset($files[$trapId]['gambar']) && $files[$trapId]['gambar']) {
                $gambarPath = $files[$trapId]['gambar']->store('rekomendasi', 'public');
            }

            if ($catatan || $gambarPath) {
                $entry->rekomendasi()->updateOrCreate(
                    ['entry_id' => $entry->id],
                    array_filter([
                        'catatan' => $catatan,
                        'gambar' => $gambarPath,
                    ])
                );
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