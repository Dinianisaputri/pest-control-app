<?php

namespace App\Exports;

use App\Models\Trap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PestControlExport implements FromCollection, WithHeadings
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        $traps = Trap::with(['entries' => function ($query) {
            $query->where('tanggal', $this->tanggal)->with('rekomendasi');
        }])->orderBy('type_detector')->orderBy('no_trap')->get();

        return $traps->map(function ($trap) {
            $entry = $trap->entries->first(); // entry untuk tanggal ini (kalau ada)

            return [
                'No. Trap' => $trap->no_trap,
                'Type Detector' => $trap->type_detector,
                'Spesies' => $trap->spesies_hama,
                'Lokasi' => $trap->lokasi,
                'Tanggal' => $this->tanggal,
                'Tindakan' => optional($entry)->tindakan ?? '-',
                'Aktivitas' => optional($entry)->aktivitas ?? '-',
                'Hasil' => optional($entry)->hasil ?? '-',
                'Rekomendasi Perbaikan' => optional(optional($entry)->rekomendasi)->catatan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['No. Trap', 'Type Detector', 'Spesies', 'Lokasi', 'Tanggal', 'Tindakan', 'Aktivitas', 'Hasil', 'Rekomendasi Perbaikan'];
    }
}