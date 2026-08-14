<?php

namespace App\Exports;

use App\Models\Trap;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PestControlExport implements FromCollection, WithHeadings, WithDrawings, WithEvents, WithCustomStartCell, WithColumnWidths
{
    protected $tanggal;
    protected $imageRows = [];
    protected $headerRow = 8;
    protected $lastDataRow;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function startCell(): string
    {
        return 'A' . $this->headerRow;
    }

    public function collection()
    {
        $traps = Trap::with(['entries' => function ($query) {
            $query->where('tanggal', $this->tanggal)->with('rekomendasi');
        }])->orderBy('type_detector')->orderBy('no_trap')->get();

        $rows = collect();
        $rowNumber = $this->headerRow + 1;

        foreach ($traps as $i => $trap) {
            $entry = $trap->entries->first();
            $rekom = optional($entry)->rekomendasi;

            if (optional($rekom)->rekomendasi_gambar) {
                $this->imageRows[] = ['row' => $rowNumber, 'col' => 'K', 'path' => $rekom->rekomendasi_gambar];
            }
            if (optional($rekom)->perbaikan_gambar) {
                $this->imageRows[] = ['row' => $rowNumber, 'col' => 'M', 'path' => $rekom->perbaikan_gambar];
            }

            $rows->push([
                'No' => $i + 1,
                'No. Trap' => $trap->no_trap,
                'Type Detector' => $trap->type_detector,
                'Spesies' => $trap->spesies_hama,
                'Lokasi' => $trap->lokasi,
                'Tanggal' => $this->tanggal,
                'Tindakan' => optional($entry)->tindakan ?? '-',
                'Aktivitas' => optional($entry)->aktivitas ?? '-',
                'Hasil' => optional($entry)->hasil ?? '-',
                'Catatan Rekomendasi' => optional($rekom)->rekomendasi_catatan ?? '-',
                'Foto Rekomendasi' => '',
                'Catatan Perbaikan' => optional($rekom)->perbaikan_catatan ?? '-',
                'Foto Perbaikan' => '',
            ]);

            $rowNumber++;
        }

        $this->lastDataRow = $rowNumber - 1;

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'No. Trap', 'Type Detector', 'Spesies', 'Lokasi', 'Tanggal',
            'Tindakan', 'Aktivitas', 'Hasil',
            'Catatan Rekomendasi', 'Foto Rekomendasi',
            'Catatan Perbaikan', 'Foto Perbaikan',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5, 'B' => 10, 'C' => 20, 'D' => 10, 'E' => 20, 'F' => 14,
            'G' => 22, 'H' => 10, 'I' => 22, 'J' => 24, 'K' => 18, 'L' => 24, 'M' => 18,
        ];
    }

    public function drawings()
    {
        $drawings = [];

        $logoPath = public_path('images/logo.png');
        if (file_exists($logoPath)) {
            $logo = new Drawing();
            $logo->setName('Logo');
            $logo->setPath($logoPath);
            $logo->setHeight(50);
            $logo->setCoordinates('A1');
            $drawings[] = $logo;
        }

        foreach ($this->imageRows as $item) {
            $fullPath = storage_path('app/public/' . $item['path']);
            if (!file_exists($fullPath)) {
                continue;
            }

            $drawing = new Drawing();
            $drawing->setName('Foto');
            $drawing->setPath($fullPath);
            $drawing->setHeight(80);
            $drawing->setCoordinates($item['col'] . $item['row']);
            $drawings[] = $drawing;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->mergeCells('A1:M1');
                $sheet->setCellValue('A1', 'STARFOOD INTERNATIONAL');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A2:M2');
                $sheet->setCellValue('A2', 'PEST CONTROL REPORT - PENGENDALIAN HAMA');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A4:D4');
                $sheet->setCellValue('A4', 'Tanggal Produksi: ' . \Carbon\Carbon::parse($this->tanggal)->translatedFormat('d F Y'));
                $sheet->getStyle('A4')->getFont()->setBold(true);

                $sheet->mergeCells('A5:D5');
                $sheet->setCellValue('A5', 'Unit: Fish Meal');
                $sheet->getStyle('A5')->getFont()->setBold(true);

                $sheet->mergeCells('J4:M4');
                $sheet->setCellValue('J4', 'Nomor: QC/SFI/IV.02.07');
                $sheet->getStyle('J4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $sheet->mergeCells('J5:M5');
                $sheet->setCellValue('J5', 'Dicetak: ' . now()->format('d/m/Y H:i'));
                $sheet->getStyle('J5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

                $headerRange = 'A' . $this->headerRow . ':M' . $this->headerRow;
                $sheet->getStyle($headerRange)->getFont()->setBold(true);
                $sheet->getStyle($headerRange)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('D9E1F2');
                $sheet->getStyle($headerRange)->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                if ($this->lastDataRow) {
                    $tableRange = 'A' . $this->headerRow . ':M' . $this->lastDataRow;
                    $sheet->getStyle($tableRange)->getBorders()->getAllBorders()
                        ->setBorderStyle(Border::BORDER_THIN);

                    for ($r = $this->headerRow + 1; $r <= $this->lastDataRow; $r++) {
                        $sheet->getRowDimension($r)->setRowHeight(60);
                    }

                    $signRow = $this->lastDataRow + 3;
                    $sheet->setCellValue('B' . $signRow, 'Reviewed by');
                    $sheet->setCellValue('F' . $signRow, 'Checked by');
                    $sheet->setCellValue('J' . $signRow, 'Report by');
                    $sheet->getStyle('B' . $signRow . ':J' . $signRow)->getFont()->setBold(true);

                    $sheet->setCellValue('B' . ($signRow + 4), 'Quality Control Dept');
                    $sheet->setCellValue('F' . ($signRow + 4), 'Production Dept');
                    $sheet->setCellValue('J' . ($signRow + 4), 'Petugas Pest Control');
                }

                $sheet->getRowDimension(1)->setRowHeight(40);
            },
        ];
    }
}