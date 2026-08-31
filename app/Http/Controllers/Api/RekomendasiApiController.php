<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Entry;
use App\Models\RekomendasiPerbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RekomendasiApiController extends Controller
{
    // GET /api/rekomendasi/{entry}
    public function show(Entry $entry)
    {
        $rekomendasi = $entry->rekomendasi;

        if (!$rekomendasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data rekomendasi belum tersedia.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data rekomendasi berhasil diambil.',
            'data' => $rekomendasi,
        ]);
    }

    // POST /api/rekomendasi/{entry}
    public function store(Request $request, Entry $entry)
    {
        $request->validate([
            'rekomendasi_catatan' => 'nullable|string',
            'perbaikan_catatan' => 'nullable|string',

            'rekomendasi_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'perbaikan_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        if ($entry->rekomendasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rekomendasi untuk entry ini sudah tersedia.',
            ], 409);
        }

        $data = [
            'entry_id' => $entry->id,
            'rekomendasi_catatan' => $request->rekomendasi_catatan,
            'perbaikan_catatan' => $request->perbaikan_catatan,
        ];

        // Upload foto rekomendasi
        if ($request->hasFile('rekomendasi_gambar')) {
            $data['rekomendasi_gambar'] =
                $request->file('rekomendasi_gambar')
                    ->store('rekomendasi', 'public');
        }

        // Upload foto perbaikan
        if ($request->hasFile('perbaikan_gambar')) {
            $data['perbaikan_gambar'] =
                $request->file('perbaikan_gambar')
                    ->store('perbaikan', 'public');
        }

        $rekomendasi = RekomendasiPerbaikan::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data rekomendasi berhasil ditambahkan.',
            'data' => $rekomendasi,
        ], 201);
    }

    // PUT /api/rekomendasi/{entry}
    public function update(Request $request, Entry $entry)
    {
        $rekomendasi = $entry->rekomendasi;

        if (!$rekomendasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data rekomendasi belum tersedia.',
            ], 404);
        }

        $request->validate([
            'rekomendasi_catatan' => 'nullable|string',
            'perbaikan_catatan' => 'nullable|string',

            'rekomendasi_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'perbaikan_gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $data = [
            'rekomendasi_catatan' => $request->rekomendasi_catatan,
            'perbaikan_catatan' => $request->perbaikan_catatan,
        ];

        // Ganti foto rekomendasi jika ada foto baru
        if ($request->hasFile('rekomendasi_gambar')) {

            if ($rekomendasi->rekomendasi_gambar) {
                Storage::disk('public')->delete(
                    $rekomendasi->rekomendasi_gambar
                );
            }

            $data['rekomendasi_gambar'] =
                $request->file('rekomendasi_gambar')
                    ->store('rekomendasi', 'public');
        }

        // Ganti foto perbaikan jika ada foto baru
        if ($request->hasFile('perbaikan_gambar')) {

            if ($rekomendasi->perbaikan_gambar) {
                Storage::disk('public')->delete(
                    $rekomendasi->perbaikan_gambar
                );
            }

            $data['perbaikan_gambar'] =
                $request->file('perbaikan_gambar')
                    ->store('perbaikan', 'public');
        }

        $rekomendasi->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Data rekomendasi berhasil diperbarui.',
            'data' => $rekomendasi,
        ]);
    }

    // DELETE /api/rekomendasi/{entry}
    public function destroy(Entry $entry)
    {
        $rekomendasi = $entry->rekomendasi;

        if (!$rekomendasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data rekomendasi belum tersedia.',
            ], 404);
        }

        if ($rekomendasi->rekomendasi_gambar) {
            Storage::disk('public')->delete(
                $rekomendasi->rekomendasi_gambar
            );
        }

        if ($rekomendasi->perbaikan_gambar) {
            Storage::disk('public')->delete(
                $rekomendasi->perbaikan_gambar
            );
        }

        $rekomendasi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data rekomendasi berhasil dihapus.',
        ]);
    }
}