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

class PestControlExport implements
    FromCollection,
    WithHeadings,
    WithDrawings,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths
{
    protected $tanggal;

    protected $imageRows = [];

    protected $headerRow = 8;

    protected $lastDataRow;

    // ==========================================
    // STATISTIK DASHBOARD
    // ==========================================

    protected $totalTraps = 0;
    protected $inputTraps = 0;
    protected $inputPercentage = 0;

    protected $lowCount = 0;
    protected $mediumCount = 0;
    protected $highCount = 0;

    protected $tikusCount = 0;
    protected $lalatCount = 0;
    protected $kucingCount = 0;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    // ==========================================
    // POSISI AWAL TABEL
    // ==========================================

    public function startCell(): string
    {
        return 'A' . $this->headerRow;
    }

    // ==========================================
    // DATA
    // ==========================================

    public function collection()
    {
        $traps = Trap::with([
            'entries' => function ($query) {
                $query->where('tanggal', $this->tanggal)
                    ->with('rekomendasi');
            }
        ])
        ->orderBy('type_detector')
        ->orderBy('no_trap')
        ->get();

        $rows = collect();

        $rowNumber = $this->headerRow + 1;

        // ==========================================
        // TOTAL TRAP
        // ==========================================

        $this->totalTraps = $traps->count();

        foreach ($traps as $i => $trap) {

            $entry = $trap->entries->first();
            $rekom = optional($entry)->rekomendasi;

            // ==========================================
            // STATISTIK
            // ==========================================

            if ($entry) {

                $this->inputTraps++;

                // AKTIVITAS
                $aktivitas = strtolower(
                    trim($entry->aktivitas ?? '')
                );

                if ($aktivitas === 'low') {
                    $this->lowCount++;
                } elseif ($aktivitas === 'medium') {
                    $this->mediumCount++;
                } elseif ($aktivitas === 'high') {
                    $this->highCount++;
                }

                // SPESIES
                $spesies = strtolower(
                    trim($trap->spesies_hama ?? '')
                );

                if ($spesies === 'tikus') {
                    $this->tikusCount++;
                } elseif ($spesies === 'lalat') {
                    $this->lalatCount++;
                } elseif ($spesies === 'kucing') {
                    $this->kucingCount++;
                }
            }

            // ==========================================
            // FOTO REKOMENDASI
            // ==========================================

            if (optional($rekom)->rekomendasi_gambar) {

                $this->imageRows[] = [
                    'row' => $rowNumber,
                    'col' => 'K',
                    'path' => $rekom->rekomendasi_gambar
                ];
            }

            // ==========================================
            // FOTO PERBAIKAN
            // ==========================================

            if (optional($rekom)->perbaikan_gambar) {

                $this->imageRows[] = [
                    'row' => $rowNumber,
                    'col' => 'M',
                    'path' => $rekom->perbaikan_gambar
                ];
            }

            // ==========================================
            // DATA TABEL
            // ==========================================

            $rows->push([
                'No' =>
                    $i + 1,

                'No. Trap' =>
                    $trap->no_trap,

                'Type Detector' =>
                    $trap->type_detector,

                'Spesies' =>
                    $trap->spesies_hama,

                'Lokasi' =>
                    $trap->lokasi,

                'Tanggal' =>
                    $this->tanggal,

                'Tindakan' =>
                    optional($entry)->tindakan ?? '-',

                'Aktivitas' =>
                    optional($entry)->aktivitas ?? '-',

                'Hasil' =>
                    optional($entry)->hasil ?? '-',

                'Catatan Rekomendasi' =>
                    optional($rekom)->rekomendasi_catatan ?? '-',

                'Foto Rekomendasi' =>
                    '',

                'Catatan Perbaikan' =>
                    optional($rekom)->perbaikan_catatan ?? '-',

                'Foto Perbaikan' =>
                    '',
            ]);

            $rowNumber++;
        }

        // ==========================================
        // PERSENTASE INPUT
        // ==========================================

        if ($this->totalTraps > 0) {

            $this->inputPercentage =
                ($this->inputTraps / $this->totalTraps) * 100;
        }

        $this->lastDataRow = $rowNumber - 1;

        return $rows;
    }

    // ==========================================
    // HEADER
    // ==========================================

    public function headings(): array
    {
        return [
            'No',
            'No. Trap',
            'Type Detector',
            'Spesies',
            'Lokasi',
            'Tanggal',
            'Tindakan',
            'Aktivitas',
            'Hasil',
            'Catatan Rekomendasi',
            'Foto Rekomendasi',
            'Catatan Perbaikan',
            'Foto Perbaikan',
        ];
    }

    // ==========================================
    // LEBAR KOLOM
    // ==========================================

    public function columnWidths(): array
    {
        return [

            // =========================
            // TABEL
            // =========================

            'A' => 5,
            'B' => 10,
            'C' => 20,
            'D' => 11,
            'E' => 20,
            'F' => 14,
            'G' => 22,
            'H' => 11,
            'I' => 22,
            'J' => 26,
            'K' => 18,
            'L' => 26,
            'M' => 18,

            // =========================
            // JARAK
            // =========================

            'N' => 3,

            // =========================
            // DASHBOARD
            // =========================

            'O' => 17,
            'P' => 17,
            'Q' => 17,
            'R' => 14,
            'S' => 14,
            'T' => 14,
            'U' => 14,
        ];
    }

    // ==========================================
    // DRAWINGS
    // ==========================================

    public function drawings()
    {
        $drawings = [];

        // ==========================================
        // LOGO
        // ==========================================

        $logoPath = public_path('images/logo.png');

        if (file_exists($logoPath)) {

            $logo = new Drawing();

            $logo->setName('Logo');
            $logo->setPath($logoPath);
            $logo->setHeight(50);
            $logo->setCoordinates('A1');

            $drawings[] = $logo;
        }

        // ==========================================
        // FOTO REKOMENDASI & PERBAIKAN
        // ==========================================

        foreach ($this->imageRows as $item) {

            $fullPath = storage_path(
                'app/public/' . $item['path']
            );

            if (!file_exists($fullPath)) {
                continue;
            }

            $drawing = new Drawing();

            $drawing->setName('Foto');
            $drawing->setPath($fullPath);
            $drawing->setHeight(80);
            $drawing->setCoordinates(
                $item['col'] . $item['row']
            );

            $drawings[] = $drawing;
        }

        return $drawings;
    }

    // ==========================================
    // EVENTS
    // ==========================================

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // ==========================================
                // DEFAULT ALIGNMENT
                // ==========================================

                $sheet->getStyle('A1:U' . max(
                    $this->lastDataRow ?? 20,
                    20
                ))
                ->getAlignment()
                ->setVertical(
                    Alignment::VERTICAL_CENTER
                )
                ->setHorizontal(
                    Alignment::HORIZONTAL_CENTER
                )
                ->setWrapText(true);

                // ==========================================
                // JUDUL UTAMA
                // ==========================================

                $sheet->mergeCells('A1:M1');

                $sheet->setCellValue(
                    'A1',
                    'STARFOOD INTERNATIONAL'
                );

                $sheet->getStyle('A1:M1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(16);

                $sheet->getStyle('A1:M1')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                // ==========================================
                // SUB JUDUL
                // ==========================================

                $sheet->mergeCells('A2:M2');

                $sheet->setCellValue(
                    'A2',
                    'PEST CONTROL REPORT - PENGENDALIAN HAMA'
                );

                $sheet->getStyle('A2:M2')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12);

                $sheet->getStyle('A2:M2')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);

                // ==========================================
                // INFORMASI LAPORAN
                // ==========================================

                $sheet->mergeCells('A4:D4');

                $sheet->setCellValue(
                    'A4',
                    'Tanggal Produksi: ' .
                    \Carbon\Carbon::parse($this->tanggal)
                        ->translatedFormat('d F Y')
                );

                $sheet->getStyle('A4:D4')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A4:D4')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);

                // ==========================================
                // UNIT
                // ==========================================

                $sheet->mergeCells('A5:D5');

                $sheet->setCellValue(
                    'A5',
                    'Unit: Fish Meal'
                );

                $sheet->getStyle('A5:D5')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('A5:D5')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_LEFT
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                // ==========================================
                // NOMOR DOKUMEN
                // ==========================================

                $sheet->mergeCells('J4:M4');

                $sheet->setCellValue(
                    'J4',
                    'Nomor: QC/SFI/IV.02.07'
                );

                $sheet->getStyle('J4:M4')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                // ==========================================
                // CETAK
                // ==========================================

                $sheet->mergeCells('J5:M5');

                $sheet->setCellValue(
                    'J5',
                    'Dicetak: ' .
                    now()->format('d/m/Y H:i')
                );

                $sheet->getStyle('J5:M5')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_RIGHT
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                // ==========================================
                // DASHBOARD
                // ==========================================

                // ------------------------------------------
                // HEADER DASHBOARD
                // ------------------------------------------

                $sheet->mergeCells('O8:U8');

                $sheet->setCellValue(
                    'O8',
                    'RINGKASAN PENGENDALIAN HAMA'
                );

                $sheet->getStyle('O8:U8')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12);

                $sheet->getStyle('O8:U8')
                    ->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setRGB('D9EAD3');

                $sheet->getStyle('O8:U8')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);

                $sheet->getStyle('O8:U8')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                // ==========================================
                // INPUT HARI INI
                // ==========================================

                $sheet->mergeCells('O9:R9');

                $sheet->setCellValue(
                    'O9',
                    'INPUT HARI INI'
                );

                $sheet->mergeCells('S9:U9');

                $sheet->setCellValue(
                    'S9',
                    $this->inputTraps .
                    ' / ' .
                    $this->totalTraps .
                    ' Trap'
                );

                // ==========================================
                // PERSENTASE
                // ==========================================

                $sheet->mergeCells('O10:R10');

                $sheet->setCellValue(
                    'O10',
                    'PERSENTASE INPUT'
                );

                $sheet->mergeCells('S10:U10');

                $sheet->setCellValue(
                    'S10',
                    number_format(
                        $this->inputPercentage,
                        2
                    ) . '%'
                );

                // ==========================================
                // STYLE INPUT
                // ==========================================

                $sheet->getStyle('O9:U10')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                $sheet->getStyle('O9:R10')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('S9:U10')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(12);

                $sheet->getStyle('S9:U10')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                // ==========================================
                // AKTIVITAS
                // ==========================================

                $sheet->mergeCells('O12:U12');

                $sheet->setCellValue(
                    'O12',
                    'AKTIVITAS'
                );

                $sheet->getStyle('O12:U12')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('O12:U12')
                    ->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setRGB('D9E1F2');

                $sheet->getStyle('O12:U12')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                // LOW
                $sheet->mergeCells('O13:R13');

                $sheet->setCellValue(
                    'O13',
                    'LOW'
                );

                $sheet->mergeCells('S13:U13');

                $sheet->setCellValue(
                    'S13',
                    $this->lowCount
                );

                // MEDIUM
                $sheet->mergeCells('O14:R14');

                $sheet->setCellValue(
                    'O14',
                    'MEDIUM'
                );

                $sheet->mergeCells('S14:U14');

                $sheet->setCellValue(
                    'S14',
                    $this->mediumCount
                );

                // HIGH
                $sheet->mergeCells('O15:R15');

                $sheet->setCellValue(
                    'O15',
                    'HIGH'
                );

                $sheet->mergeCells('S15:U15');

                $sheet->setCellValue(
                    'S15',
                    $this->highCount
                );

                // Border aktivitas
                $sheet->getStyle('O13:U15')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                $sheet->getStyle('O13:R15')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('S13:U15')
                    ->getFont()
                    ->setBold(true);

                // ==========================================
                // SPESIES HAMA
                // ==========================================

                $sheet->mergeCells('O17:U17');

                $sheet->setCellValue(
                    'O17',
                    'SPESIES HAMA'
                );

                $sheet->getStyle('O17:U17')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('O17:U17')
                    ->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setRGB('D9E1F2');

                $sheet->getStyle('O17:U17')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                // TIKUS
                $sheet->mergeCells('O18:R18');

                $sheet->setCellValue(
                    'O18',
                    'Tikus'
                );

                $sheet->mergeCells('S18:U18');

                $sheet->setCellValue(
                    'S18',
                    $this->tikusCount
                );

                // LALAT
                $sheet->mergeCells('O19:R19');

                $sheet->setCellValue(
                    'O19',
                    'Lalat'
                );

                $sheet->mergeCells('S19:U19');

                $sheet->setCellValue(
                    'S19',
                    $this->lalatCount
                );

                // KUCING
                $sheet->mergeCells('O20:R20');

                $sheet->setCellValue(
                    'O20',
                    'Kucing'
                );

                $sheet->mergeCells('S20:U20');

                $sheet->setCellValue(
                    'S20',
                    $this->kucingCount
                );

                // Border spesies
                $sheet->getStyle('O18:U20')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                $sheet->getStyle('O18:R20')
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle('S18:U20')
                    ->getFont()
                    ->setBold(true);

                // ==========================================
                // HEADER TABEL
                // ==========================================

                $headerRange =
                    'A' .
                    $this->headerRow .
                    ':M' .
                    $this->headerRow;

                $sheet->getStyle($headerRange)
                    ->getFont()
                    ->setBold(true);

                $sheet->getStyle($headerRange)
                    ->getFill()
                    ->setFillType(
                        Fill::FILL_SOLID
                    )
                    ->getStartColor()
                    ->setRGB('D9E1F2');

                $sheet->getStyle($headerRange)
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);

                $sheet->getStyle($headerRange)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );

                // ==========================================
                // DATA TABEL
                // ==========================================

                if ($this->lastDataRow) {

                    $tableRange =
                        'A' .
                        $this->headerRow .
                        ':M' .
                        $this->lastDataRow;

                    // Border
                    $sheet->getStyle($tableRange)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(
                            Border::BORDER_THIN
                        );

                    // Semua data center + middle + wrap
                    $sheet->getStyle(
                        'A' .
                        ($this->headerRow + 1) .
                        ':M' .
                        $this->lastDataRow
                    )
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);

                    // ======================================
                    // TINGGI BARIS DATA
                    // ======================================

                    for (
                        $r = $this->headerRow + 1;
                        $r <= $this->lastDataRow;
                        $r++
                    ) {

                        $sheet->getRowDimension($r)
                            ->setRowHeight(65);
                    }

                    // ======================================
                    // TANDA TANGAN
                    // ======================================

                    $signRow =
                        $this->lastDataRow + 3;

                    $sheet->setCellValue(
                        'B' . $signRow,
                        'Reviewed by'
                    );

                    $sheet->setCellValue(
                        'F' . $signRow,
                        'Checked by'
                    );

                    $sheet->setCellValue(
                        'J' . $signRow,
                        'Report by'
                    );

                    $sheet->getStyle(
                        'B' .
                        $signRow .
                        ':J' .
                        $signRow
                    )
                    ->getFont()
                    ->setBold(true);

                    $sheet->getStyle(
                        'B' .
                        $signRow .
                        ':J' .
                        $signRow
                    )
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );

                    // --------------------------------------
                    // JABATAN
                    // --------------------------------------

                    $sheet->setCellValue(
                        'B' . ($signRow + 4),
                        'Quality Control Dept'
                    );

                    $sheet->setCellValue(
                        'F' . ($signRow + 4),
                        'Production Dept'
                    );

                    $sheet->setCellValue(
                        'J' . ($signRow + 4),
                        'Petugas Pest Control'
                    );

                    $sheet->getStyle(
                        'B' . ($signRow + 4) .
                        ':J' . ($signRow + 4)
                    )
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);
                }

                // ==========================================
                // TINGGI BARIS
                // ==========================================

                $sheet->getRowDimension(1)
                    ->setRowHeight(40);

                $sheet->getRowDimension(2)
                    ->setRowHeight(28);

                $sheet->getRowDimension(4)
                    ->setRowHeight(22);

                $sheet->getRowDimension(5)
                    ->setRowHeight(22);

                $sheet->getRowDimension(8)
                    ->setRowHeight(35);

                $sheet->getRowDimension(9)
                    ->setRowHeight(30);

                $sheet->getRowDimension(10)
                    ->setRowHeight(30);

                $sheet->getRowDimension(12)
                    ->setRowHeight(28);

                $sheet->getRowDimension(17)
                    ->setRowHeight(28);

                // ==========================================
                // FREEZE HEADER
                // ==========================================

                $sheet->freezePane('A9');
            },
        ];
    }
}