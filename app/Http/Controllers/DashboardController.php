<?php

namespace App\Http\Controllers;

use App\Models\Trap;
use App\Models\Entry;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTraps = Trap::count();
        $today = now()->format('Y-m-d');

        $todayEntries = Entry::where('tanggal', $today)->get();
        $filled = $todayEntries->count();

        $dist = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
        foreach ($todayEntries as $entry) {
            if (isset($dist[$entry->aktivitas])) {
                $dist[$entry->aktivitas]++;
            }
        }

        $typeCounts = Trap::select('type_detector', DB::raw('count(*) as total'))
            ->groupBy('type_detector')
            ->pluck('total', 'type_detector');

        $totalHariTercatat = Entry::select('tanggal')->distinct()->count();

        // Jumlah pelaporan tercatat per spesies (berapa kali trap spesies ini pernah dicatat aktivitasnya)
        $speciesCounts = Entry::join('traps', 'entries.trap_id', '=', 'traps.id')
            ->select('traps.spesies_hama', DB::raw('count(*) as total'))
            ->groupBy('traps.spesies_hama')
            ->pluck('total', 'traps.spesies_hama');

        // Statistik bulanan: jumlah LOW/MEDIUM/HIGH per bulan, 6 bulan terakhir
        $monthlyRaw = Entry::select(
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
                'aktivitas',
                DB::raw('count(*) as total')
            )
            ->groupBy('bulan', 'aktivitas')
            ->orderBy('bulan')
            ->get();

        $monthlyLabels = $monthlyRaw->pluck('bulan')->unique()->sort()->values();
        $monthlyStats = [];
        foreach ($monthlyLabels as $bulan) {
            $monthlyStats[$bulan] = ['LOW' => 0, 'MEDIUM' => 0, 'HIGH' => 0];
        }
        foreach ($monthlyRaw as $row) {
            $monthlyStats[$row->bulan][$row->aktivitas] = $row->total;
        }

        return view('dashboard', compact(
            'totalTraps', 'today', 'filled', 'dist', 'typeCounts',
            'totalHariTercatat', 'todayEntries', 'speciesCounts', 'monthlyStats'
        ));
    }
}