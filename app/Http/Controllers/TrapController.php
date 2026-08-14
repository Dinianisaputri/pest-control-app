<?php

namespace App\Http\Controllers;

use App\Models\Trap;
use Illuminate\Http\Request;

class TrapController extends Controller
{
    public function index()
    {
        $traps = Trap::orderBy('type_detector')->orderBy('no_trap')->get();
        $grouped = $traps->groupBy('type_detector');

        return view('traps.index', compact('grouped'));
    }

    public function create()
    {
        return view('traps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_trap' => 'required|string|max:10',
            'type_detector' => 'required|string|max:50',
            'spesies_hama' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
        ]);

        Trap::create($request->only('no_trap', 'type_detector', 'spesies_hama', 'lokasi'));

        return redirect()->route('traps.index')->with('success', 'Trap baru berhasil ditambahkan.');
    }

    public function edit(Trap $trap)
    {
        return view('traps.edit', compact('trap'));
    }

    public function update(Request $request, Trap $trap)
    {
        $request->validate([
            'no_trap' => 'required|string|max:10',
            'type_detector' => 'required|string|max:50',
            'spesies_hama' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
        ]);

        $trap->update($request->only('no_trap', 'type_detector', 'spesies_hama', 'lokasi'));

        return redirect()->route('traps.index')->with('success', 'Data trap berhasil diubah.');
    }

    public function destroy(Trap $trap)
    {
        $trap->delete();

        return redirect()->route('traps.index')->with('success', 'Trap berhasil dihapus.');
    }
}