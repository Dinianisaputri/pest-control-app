<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\Trap;
use Illuminate\Http\Request;

class EntryApiController extends Controller
{
    // GET /api/entries
    public function index()
    {
        $entries = Entry::with('trap')
            ->with('rekomendasi')
            ->orderByDesc('tanggal')
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data pencatatan berhasil diambil',
            'data' => $entries,
        ]);
    }

    // GET /api/entries/{entry}
    public function show(Entry $entry)
    {
        $entry->load(['trap', 'rekomendasi']);

        return response()->json([
            'status' => 'success',
            'message' => 'Detail pencatatan berhasil diambil',
            'data' => $entry,
        ]);
    }

    // POST /api/entries
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trap_id' => 'required|exists:traps,id',
            'tanggal' => 'required|date',
            'tindakan' => 'required|string',
            'aktivitas' => 'required|in:Low,Medium,High',
            'hasil' => 'required|string',
        ]);

        $entry = Entry::create($validated);

        $entry->load('trap');

        return response()->json([
            'status' => 'success',
            'message' => 'Pencatatan berhasil ditambahkan',
            'data' => $entry,
        ], 201);
    }

    // PUT /api/entries/{entry}
    public function update(Request $request, Entry $entry)
    {
        $validated = $request->validate([
            'trap_id' => 'required|exists:traps,id',
            'tanggal' => 'required|date',
            'tindakan' => 'required|string',
            'aktivitas' => 'required|in:Low,Medium,High',
            'hasil' => 'required|string',
        ]);

        $entry->update($validated);

        $entry->load(['trap', 'rekomendasi']);

        return response()->json([
            'status' => 'success',
            'message' => 'Pencatatan berhasil diubah',
            'data' => $entry,
        ]);
    }

    // DELETE /api/entries/{entry}
    public function destroy(Entry $entry)
    {
        $entry->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pencatatan berhasil dihapus',
        ]);
    }
}