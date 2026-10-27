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
        abort_unless(
            in_array(auth()->user()->role, ['pengelola', 'operatorpc'], true),
            403,
            'Halaman Input Harian hanya dapat diakses oleh Petugas.'
        );

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
    $role = auth()->user()->role;

    $isAdmin = $role === 'admin';
    $isPetugas = in_array($role, ['pengelola', 'operatorpc'], true);

    if (!$isAdmin && !$isPetugas) {
        abort(403, 'Anda tidak memiliki izin untuk menyimpan data.');
    }

    foreach ($data as $trapId => $row) {
        $fileRow = $files[$trapId] ?? [];

        // ADMIN: hanya boleh mengisi data perbaikan.
        if ($isAdmin) {
            $hasInspectionInput =
                !empty($row['aktivitas']) ||
                !empty($row['tindakan']) ||
                !empty($row['hasil']) ||
                !empty($row['rekomendasi_catatan']) ||
                !empty($fileRow['rekomendasi_gambar']);

            abort_unless(
                !$hasInspectionInput,
                403,
                'Admin tidak diizinkan mengisi data inspeksi.'
            );

            $adaPerbaikan =
                array_key_exists('perbaikan_catatan', $row) ||
                !empty($fileRow['perbaikan_gambar']);

            if (!$adaPerbaikan) {
                continue;
            }

            // Admin tidak boleh membuat data inspeksi baru.
            $entry = Entry::where('trap_id', $trapId)
                ->where('tanggal', $tanggal)
                ->first();

            abort_unless($entry, 404, 'Data inspeksi tidak ditemukan.');

            $rekomendasi = $entry->rekomendasi;

            abort_unless($rekomendasi, 404, 'Rekomendasi tidak ditemukan.');

            $update = [];

            if (array_key_exists('perbaikan_catatan', $row)) {
                $update['perbaikan_catatan'] =
                    $row['perbaikan_catatan'] ?: null;
            }

            if (!empty($fileRow['perbaikan_gambar'])) {
                $update['perbaikan_gambar'] =
                    $fileRow['perbaikan_gambar']->store(
                        'perbaikan',
                        'public'
                    );
            }

            if (!empty($update)) {
                $rekomendasi->update($update);
            }

            continue;
        }

        // PETUGAS: mengisi inspeksi dan rekomendasi.
        $adaIsi =
            !empty($row['aktivitas']) ||
            !empty($row['tindakan']) ||
            !empty($row['hasil']) ||
            !empty($row['rekomendasi_catatan']) ||
            !empty($fileRow['rekomendasi_gambar']);

        if (!$adaIsi) {
            continue;
        }

        $entry = Entry::updateOrCreate(
            [
                'trap_id' => $trapId,
                'tanggal' => $tanggal,
            ],
            [
                'tindakan' => $row['tindakan'] ?? null,
                'aktivitas' => $row['aktivitas'] ?? 'LOW',
                'hasil' => $row['hasil'] ?? null,
            ]
        );

        $rekomendasi = $entry->rekomendasi;

        $update = [];

        if (array_key_exists('rekomendasi_catatan', $row)) {
            $update['rekomendasi_catatan'] =
                $row['rekomendasi_catatan'] ?: null;
        }

        if (!empty($fileRow['rekomendasi_gambar'])) {
            $update['rekomendasi_gambar'] =
                $fileRow['rekomendasi_gambar']->store(
                    'rekomendasi',
                    'public'
                );
        }

        if (empty($update)) {
            continue;
        }

        if (!$rekomendasi) {
            $entry->rekomendasi()->create($update);

            continue;
        }

        $rekomendasiBerubah = false;

        foreach ($update as $field => $value) {
            if (
                $field === 'rekomendasi_catatan' &&
                $rekomendasi->{$field} !== $value
            ) {
                $rekomendasiBerubah = true;
            }

            if ($field === 'rekomendasi_gambar') {
                $rekomendasiBerubah = true;
            }
        }

        if (
            $rekomendasiBerubah &&
            ($rekomendasi->status_persetujuan ?? 'pending') !== 'pending'
        ) {
            $statusLama = $rekomendasi->status_persetujuan;

            $update['status_persetujuan'] = 'pending';
            $update['approved_by'] = null;
            $update['catatan_admin'] = null;
            $update['diputuskan_pada'] = null;

            $rekomendasi->update($update);
            $rekomendasi->approvalHistories()->create([
                'user_id' => auth()->id(),
                'aksi' => 'dikirim_ulang',
                'status_sebelumnya' => $statusLama,
                'status_sesudahnya' => 'pending',
                'catatan' => 'Rekomendasi diubah oleh Petugas dan menunggu pemeriksaan ulang.',
            ]);
        } else {
            $rekomendasi->update($update);
        }
    }

    $redirect = $isAdmin
        ? redirect()->route('entries.riwayat', [
            'bulan' => \Carbon\Carbon::parse($tanggal)->format('Y-m'),
            'tanggal' => $tanggal,
        ])
        : redirect()->route('entries.create', ['tanggal' => $tanggal]);

    return $redirect->with('success', 'Data berhasil disimpan!');
}


public function exportZip(Request $request)
{
    $bulan = $request->query('bulan');

    if (
        !$bulan ||
        !preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $bulan)
    ) {
        abort(400, 'Bulan tidak valid atau belum dipilih.');
    }

    $start = \Carbon\Carbon::createFromFormat('!Y-m', $bulan);
    $end = $start->copy()->endOfMonth();

    // Ambil hanya tanggal yang memiliki data inspeksi.
    $tanggalList = \App\Models\Entry::query()
        ->whereBetween('tanggal', [
            $start->format('Y-m-d'),
            $end->format('Y-m-d'),
        ])
        ->select('tanggal')
        ->distinct()
        ->orderBy('tanggal')
        ->pluck('tanggal');

    if ($tanggalList->isEmpty()) {
        return back()->with(
            'error',
            'Tidak ada data inspeksi pada bulan yang dipilih.'
        );
    }

    $zipPath = storage_path('app/pest-control-' . $bulan . '.zip');

    $zip = new \ZipArchive();

    if (
        $zip->open(
            $zipPath,
            \ZipArchive::CREATE | \ZipArchive::OVERWRITE
        ) !== true
    ) {
        abort(500, 'Gagal membuat file ZIP.');
    }

    try {
        foreach ($tanggalList as $tanggal) {
            $tanggal = \Carbon\Carbon::parse($tanggal)->format('Y-m-d');

            $xlsx = \Maatwebsite\Excel\Facades\Excel::raw(
                new \App\Exports\PestControlExport($tanggal),
                \Maatwebsite\Excel\Excel::XLSX
            );

            $zip->addFromString(
                'pest-control-' . $tanggal . '.xlsx',
                $xlsx
            );
        }
    } finally {
        $zip->close();
    }

    return response()
        ->download($zipPath, 'pest-control-' . $bulan . '.zip')
        ->deleteFileAfterSend(true);
}

public function riwayat(Request $request)
{
    // Ambil bulan yang benar-benar memiliki data inspeksi.
    $daftarBulan = Entry::query()
        ->select('tanggal')
        ->distinct()
        ->orderByDesc('tanggal')
        ->pluck('tanggal')
        ->map(
            fn ($tanggal) => \Carbon\Carbon::parse($tanggal)->format('Y-m')
        )
        ->unique()
        ->values();

    // Bulan yang dipilih, default ke bulan terbaru yang memiliki data.
    $bulanDipilih = $request->query(
        'bulan',
        $daftarBulan->first()
    );

    // Jika bulan tidak tersedia, gunakan bulan terbaru yang valid.
    if (!$daftarBulan->contains($bulanDipilih)) {
        $bulanDipilih = $daftarBulan->first();
    }

    // Ambil tanggal yang memiliki data inspeksi pada bulan terpilih.
    $tanggalList = collect();

    if ($bulanDipilih) {
        $awalBulan = \Carbon\Carbon::createFromFormat(
            '!Y-m',
            $bulanDipilih
        );

        $tanggalList = Entry::query()
            ->whereBetween('tanggal', [
                $awalBulan->toDateString(),
                $awalBulan->copy()->endOfMonth()->toDateString(),
            ])
            ->select('tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->pluck('tanggal');
    }

    $tanggalDipilih = null;
    $trapsTanggal = collect();
    $tanggalRequested = $request->query('tanggal');

    if ($tanggalRequested && $tanggalList->contains($tanggalRequested)) {
        $tanggalDipilih = $tanggalRequested;
        $trapsTanggal = Trap::with([
            'entries' => function ($query) use ($tanggalDipilih) {
                $query->where('tanggal', $tanggalDipilih)
                    ->with([
                        'rekomendasi.approver',
                        'rekomendasi.approvalHistories.user',
                    ]);
            },
        ])
            ->orderBy('no_trap')
            ->get();
    }

    return view('entries.riwayat', compact(
        'daftarBulan',
        'bulanDipilih',
        'tanggalList',
        'tanggalDipilih',
        'trapsTanggal'
    ));
}

public function kalender(Request $request)
{
    $daftarBulan = Entry::query()
        ->selectRaw("DATE_FORMAT(tanggal, '%Y-%m') as bulan")
        ->distinct()
        ->orderByDesc('bulan')
        ->pluck('bulan');

    $bulanDipilih = $request->query('bulan', $daftarBulan->first());

    if (!$daftarBulan->contains($bulanDipilih)) {
        $bulanDipilih = $daftarBulan->first();
    }

    $tanggalList = collect();

    if ($bulanDipilih) {
        $tanggalList = Entry::query()
            ->whereRaw("DATE_FORMAT(tanggal, '%Y-%m') = ?", [$bulanDipilih])
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal');
    }

    return view('entries.kalender', compact(
        'daftarBulan',
        'bulanDipilih',
        'tanggalList'
    ));
}
}