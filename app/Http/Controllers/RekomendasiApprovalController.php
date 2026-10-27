<?php

namespace App\Http\Controllers;

use App\Models\RekomendasiPerbaikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RekomendasiApprovalController extends Controller
{
    public function approve(
        Request $request,
        RekomendasiPerbaikan $rekomendasi
    ) {
        $data = $request->validate([
            'catatan_admin' => ['nullable', 'string', 'max:2000'],
        ]);

        return $this->decide(
            $rekomendasi,
            'disetujui',
            $data['catatan_admin'] ?? null
        );
    }

    public function reject(
        Request $request,
        RekomendasiPerbaikan $rekomendasi
    ) {
        $data = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ]);

        return $this->decide(
            $rekomendasi,
            'ditolak',
            $data['catatan_admin']
        );
    }

    public function requestRevision(
        Request $request,
        RekomendasiPerbaikan $rekomendasi
    ) {
        $data = $request->validate([
            'catatan_admin' => ['required', 'string', 'max:2000'],
        ]);

        return $this->decide(
            $rekomendasi,
            'perlu_revisi',
            $data['catatan_admin']
        );
    }

    private function decide(
        RekomendasiPerbaikan $rekomendasi,
        string $statusBaru,
        ?string $catatan
    ) {
        DB::transaction(function () use (
            $rekomendasi,
            $statusBaru,
            $catatan
        ) {
            $rekomendasi->refresh();
            $statusLama = $rekomendasi->status_persetujuan ?? 'pending';

            if ($statusLama === $statusBaru) {
                throw ValidationException::withMessages([
                    'status' => 'Rekomendasi sudah memiliki status tersebut.',
                ]);
            }

            $rekomendasi->update([
                'status_persetujuan' => $statusBaru,
                'approved_by' => $statusBaru === 'disetujui'
                    ? auth()->id()
                    : null,
                'catatan_admin' => $catatan,
                'diputuskan_pada' => now(),
            ]);

            $rekomendasi->approvalHistories()->create([
                'user_id' => auth()->id(),
                'aksi' => $statusBaru,
                'status_sebelumnya' => $statusLama,
                'status_sesudahnya' => $statusBaru,
                'catatan' => $catatan,
            ]);
        });

        return back()->with('success', 'Keputusan approval berhasil disimpan.');
    }
}
