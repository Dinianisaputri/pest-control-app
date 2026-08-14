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

        return view('dashboard', compact('totalTraps', 'today', 'filled', 'dist', 'typeCounts', 'totalHariTercatat', 'todayEntries'));
    }
}