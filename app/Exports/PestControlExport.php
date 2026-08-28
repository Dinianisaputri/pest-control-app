<?php

namespace App\Exports;

use App\Models\Trap;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PestControlExport implements
    FromCollection,
    WithHeadings,
    WithDrawings,
    WithEvents,
    WithCustomStartCell,
    WithColumnWidths
{
    /*
    |--------------------------------------------------------------------------
    | PROPERTY
    |--------------------------------------------------------------------------
    */

    protected $tanggal;

    protected $imageRows = [];

    protected $headerRow = 8;

    protected $lastDataRow;


    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }


    /*
    |--------------------------------------------------------------------------
    | START CELL
    |--------------------------------------------------------------------------
    |
    | Header tabel dimulai dari A8.
    |
    */

    public function startCell(): string
    {
        return 'A' . $this->headerRow;
    }


    /*
    |--------------------------------------------------------------------------
    | COLLECTION
    |--------------------------------------------------------------------------
    |
    | Mengambil semua data trap berdasarkan tanggal yang dipilih.
    |
    */

    public function collection()
    {
        $traps = Trap::with([
            'entries' => function ($query) {

                $query
                    ->where('tanggal', $this->tanggal)
                    ->with('rekomendasi');
            }
        ])
            ->orderBy('type_detector')
            ->orderBy('no_trap')
            ->get();


        $rows = collect();


        /*
        |--------------------------------------------------------------------------
        | Data dimulai dari baris 9
        |--------------------------------------------------------------------------
        */

        $rowNumber = $this->headerRow + 1;


        foreach ($traps as $index => $trap) {

            /*
            |--------------------------------------------------------------------------
            | Ambil entry berdasarkan tanggal
            |--------------------------------------------------------------------------
            */

            $entry = $trap->entries->first();


            /*
            |--------------------------------------------------------------------------
            | Ambil data rekomendasi
            |--------------------------------------------------------------------------
            */

            $rekom = optional($entry)->rekomendasi;


            /*
            |--------------------------------------------------------------------------
            | FOTO REKOMENDASI
            |--------------------------------------------------------------------------
            */

            if (optional($rekom)->rekomendasi_gambar) {

                $this->imageRows[] = [
                    'row'  => $rowNumber,
                    'col'  => 'K',
                    'path' => $rekom->rekomendasi_gambar,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | FOTO PERBAIKAN
            |--------------------------------------------------------------------------
            */

            if (optional($rekom)->perbaikan_gambar) {

                $this->imageRows[] = [
                    'row'  => $rowNumber,
                    'col'  => 'M',
                    'path' => $rekom->perbaikan_gambar,
                ];
            }


            /*
            |--------------------------------------------------------------------------
            | MASUKKAN DATA KE EXCEL
            |--------------------------------------------------------------------------
            */

            $rows->push([

                'No' => $index + 1,

                'No. Trap' => $trap->no_trap,

                'Type Detector' => $trap->type_detector,

                'Spesies' => $trap->spesies_hama,

                'Lokasi' => $trap->lokasi,

                'Tanggal' => $this->tanggal,

                'Tindakan' => optional($entry)->tindakan ?? '-',

                'Aktivitas' => optional($entry)->aktivitas ?? '-',

                'Hasil' => optional($entry)->hasil ?? '-',

                'Catatan Rekomendasi' =>
                    optional($rekom)->rekomendasi_catatan ?? '-',

                'Foto Rekomendasi' => '',

                'Catatan Perbaikan' =>
                    optional($rekom)->perbaikan_catatan ?? '-',

                'Foto Perbaikan' => '',
            ]);


            /*
            |--------------------------------------------------------------------------
            | Pindah ke baris berikutnya
            |--------------------------------------------------------------------------
            */

            $rowNumber++;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan baris terakhir
        |--------------------------------------------------------------------------
        */

        $this->lastDataRow = $rowNumber - 1;


        return $rows;
    }


    /*
    |--------------------------------------------------------------------------
    | HEADINGS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | COLUMN WIDTHS
    |--------------------------------------------------------------------------
    */

    public function columnWidths(): array
    {
        return [

            'A' => 5,

            'B' => 10,

            'C' => 20,

            'D' => 10,

            'E' => 22,

            'F' => 14,

            'G' => 22,

            'H' => 12,

            'I' => 22,

            'J' => 25,

            'K' => 18,

            'L' => 25,

            'M' => 18,

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | DRAWINGS
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk memasukkan:
    | 1. Logo Starfood
    | 2. Foto rekomendasi
    | 3. Foto perbaikan
    |
    */

    public function drawings()
    {
        $drawings = [];


        /*
        |--------------------------------------------------------------------------
        | LOGO STARFOOD
        |--------------------------------------------------------------------------
        */

        $logoPath = public_path('images/logo.png');


        if (file_exists($logoPath)) {

            $logo = new Drawing();

            $logo->setName('Logo Starfood');

            $logo->setDescription(
                'Logo Starfood International'
            );

            $logo->setPath($logoPath);

            /*
            | Ukuran logo
            */

            $logo->setHeight(50);

            /*
            | Posisi logo
            */

            $logo->setCoordinates('A1');

            /*
            | Sedikit masuk dari tepi
            */

            $logo->setOffsetX(5);

            $logo->setOffsetY(5);


            $drawings[] = $logo;
        }


        /*
        |--------------------------------------------------------------------------
        | FOTO REKOMENDASI & FOTO PERBAIKAN
        |--------------------------------------------------------------------------
        */

        foreach ($this->imageRows as $item) {

            /*
            |--------------------------------------------------------------------------
            | Lokasi file gambar
            |--------------------------------------------------------------------------
            */

            $fullPath = storage_path(
                'app/public/' . $item['path']
            );


            /*
            |--------------------------------------------------------------------------
            | Kalau file tidak ditemukan
            |--------------------------------------------------------------------------
            */

            if (!file_exists($fullPath)) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Buat drawing
            |--------------------------------------------------------------------------
            */

            $drawing = new Drawing();


            /*
            |--------------------------------------------------------------------------
            | Nama drawing
            |--------------------------------------------------------------------------
            */

            if ($item['col'] === 'K') {

                $drawing->setName(
                    'Foto Rekomendasi'
                );

                $drawing->setDescription(
                    'Foto Rekomendasi Pest Control'
                );

            } else {

                $drawing->setName(
                    'Foto Perbaikan'
                );

                $drawing->setDescription(
                    'Foto Perbaikan Pest Control'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Path gambar
            |--------------------------------------------------------------------------
            */

            $drawing->setPath($fullPath);


            /*
            |--------------------------------------------------------------------------
            | Ukuran foto
            |--------------------------------------------------------------------------
            |
            | Tinggi foto dibuat 55.
            | Tinggi row nantinya 65.
            |
            */

            $drawing->setHeight(55);


            /*
            |--------------------------------------------------------------------------
            | Posisi berdasarkan kolom dan baris data
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Foto rekomendasi Trap 1 -> K9
            | Foto perbaikan Trap 1    -> M9
            |
            | Trap 2 -> K10 / M10
            |
            */

            $drawing->setCoordinates(
                $item['col'] . $item['row']
            );


            /*
            |--------------------------------------------------------------------------
            | Jarak dari sisi cell
            |--------------------------------------------------------------------------
            */

            $drawing->setOffsetX(5);

            $drawing->setOffsetY(5);


            /*
            |--------------------------------------------------------------------------
            | Masukkan ke drawings
            |--------------------------------------------------------------------------
            */

            $drawings[] = $drawing;
        }


        return $drawings;
    }


    /*
    |--------------------------------------------------------------------------
    | REGISTER EVENTS
    |--------------------------------------------------------------------------
    */

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();


                /*
                |--------------------------------------------------------------------------
                | 1. TINGGI BARIS DATA
                |--------------------------------------------------------------------------
                |
                | Ini penting untuk foto.
                |
                | Foto = 55
                | Row   = 65
                |
                | Jadi foto tidak turun ke baris berikutnya.
                |
                */

                if ($this->lastDataRow >= 9) {

                    for (
                        $row = 9;
                        $row <= $this->lastDataRow;
                        $row++
                    ) {

                        $sheet
                            ->getRowDimension($row)
                            ->setRowHeight(65);
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | 2. JUDUL STARFOOD INTERNATIONAL
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('C1:G1');

                $sheet->setCellValue(
                    'C1',
                    'STARFOOD INTERNATIONAL'
                );


                $sheet
                    ->getStyle('C1')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(15);


                $sheet
                    ->getStyle('C1')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );


                /*
                |--------------------------------------------------------------------------
                | 3. JUDUL PEST CONTROL REPORT
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('C2:G2');

                $sheet->setCellValue(
                    'C2',
                    'PEST CONTROL REPORT'
                );


                $sheet
                    ->getStyle('C2')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(11);


                $sheet
                    ->getStyle('C2')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );


                /*
                |--------------------------------------------------------------------------
                | 4. SUB JUDUL PENGENDALIAN HAMA
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('C3:G3');

                $sheet->setCellValue(
                    'C3',
                    'PENGENDALIAN HAMA'
                );


                $sheet
                    ->getStyle('C3')
                    ->getFont()
                    ->setItalic(true)
                    ->setSize(10);


                $sheet
                    ->getStyle('C3')
                    ->getFont()
                    ->getColor()
                    ->setRGB('64748B');


                $sheet
                    ->getStyle('C3')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );


                /*
                |--------------------------------------------------------------------------
                | 5. BORDER LOGO
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A1:B4')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | 6. BORDER AREA JUDUL
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('C1:G4')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | 7. INFORMASI DOKUMEN
                |--------------------------------------------------------------------------
                */

                $infoRows = [

                    [
                        'Nomor',
                        'QC/SFI/IV.02.07',
                    ],

                    [
                        'Edisi/revisi',
                        '02-Jan',
                    ],

                    [
                        'Tanggal',
                        '31/05/2025',
                    ],

                    [
                        'Halaman',
                        '1',
                    ],

                ];


                foreach ($infoRows as $index => $info) {

                    $row = $index + 1;


                    /*
                    |--------------------------------------------------------------------------
                    | Label
                    |--------------------------------------------------------------------------
                    */

                    $sheet->setCellValue(
                        'J' . $row,
                        $info[0]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Nilai
                    |--------------------------------------------------------------------------
                    */

                    $sheet->setCellValue(
                        'L' . $row,
                        $info[1]
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Merge label J-K
                    |--------------------------------------------------------------------------
                    */

                    $sheet->mergeCells(
                        'J' . $row . ':K' . $row
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Merge value L-M
                    |--------------------------------------------------------------------------
                    */

                    $sheet->mergeCells(
                        'L' . $row . ':M' . $row
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | 8. BORDER INFORMASI DOKUMEN
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('J1:M4')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | 9. FONT LABEL INFORMASI
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('J1:K4')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(10);


                /*
                |--------------------------------------------------------------------------
                | 10. FONT NILAI INFORMASI
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('L1:M4')
                    ->getFont()
                    ->setSize(10);


                /*
                |--------------------------------------------------------------------------
                | 11. ALIGNMENT INFORMASI
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('J1:M4')
                    ->getAlignment()
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    );


                /*
                |--------------------------------------------------------------------------
                | 12. TINGGI HEADER ATAS
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getRowDimension(1)
                    ->setRowHeight(24);

                $sheet
                    ->getRowDimension(2)
                    ->setRowHeight(21);

                $sheet
                    ->getRowDimension(3)
                    ->setRowHeight(21);

                $sheet
                    ->getRowDimension(4)
                    ->setRowHeight(20);


                /*
                |--------------------------------------------------------------------------
                | 13. TANGGAL PRODUKSI
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A5:G5');


                $tanggalProduksi = Carbon::parse(
                    $this->tanggal
                )->translatedFormat('d F Y');


                $sheet->setCellValue(
                    'A5',
                    'Tanggal Produksi: ' . $tanggalProduksi
                );


                $sheet
                    ->getStyle('A5')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(10);


                /*
                |--------------------------------------------------------------------------
                | 14. UNIT
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A6:G6');


                $sheet->setCellValue(
                    'A6',
                    'Unit: Fish Meal'
                );


                $sheet
                    ->getStyle('A6')
                    ->getFont()
                    ->setBold(true)
                    ->setSize(10);


                /*
                |--------------------------------------------------------------------------
                | 15. BORDER TANGGAL & UNIT
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A5:M6')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | 16. TINGGI BARIS 5 & 6
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getRowDimension(5)
                    ->setRowHeight(20);

                $sheet
                    ->getRowDimension(6)
                    ->setRowHeight(20);


                /*
                |--------------------------------------------------------------------------
                | 17. DICETAK
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A7:M7');


                $sheet->setCellValue(
                    'A7',
                    'Dicetak: ' . now()->format('d/m/Y H:i')
                );


                $sheet
                    ->getStyle('A7')
                    ->getFont()
                    ->setItalic(true)
                    ->setSize(9);


                $sheet
                    ->getStyle('A7')
                    ->getFont()
                    ->getColor()
                    ->setRGB('94A3B8');


                $sheet
                    ->getRowDimension(7)
                    ->setRowHeight(16);


                /*
                |--------------------------------------------------------------------------
                | 18. HEADER TABEL
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A8:M8')
                    ->getFont()
                    ->setBold(true);


                $sheet
                    ->getStyle('A8:M8')
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);


                /*
                |--------------------------------------------------------------------------
                | 19. BORDER HEADER TABEL
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getStyle('A8:M8')
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(
                        Border::BORDER_THIN
                    );


                /*
                |--------------------------------------------------------------------------
                | 20. TINGGI HEADER TABEL
                |--------------------------------------------------------------------------
                */

                $sheet
                    ->getRowDimension(8)
                    ->setRowHeight(30);


                /*
                |--------------------------------------------------------------------------
                | 21. FORMAT DATA
                |--------------------------------------------------------------------------
                */

                if ($this->lastDataRow >= 9) {

                    $dataRange =
                        'A9:M' . $this->lastDataRow;


                    /*
                    |--------------------------------------------------------------------------
                    | Border data
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle($dataRange)
                        ->getBorders()
                        ->getAllBorders()
                        ->setBorderStyle(
                            Border::BORDER_THIN
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Vertical alignment
                    |--------------------------------------------------------------------------
                    */

                    $sheet
                        ->getStyle($dataRange)
                        ->getAlignment()
                        ->setVertical(
                            Alignment::VERTICAL_CENTER
                        )
                        ->setWrapText(true);
                }


                /*
                |--------------------------------------------------------------------------
                | 22. CENTER KOLOM TERTENTU
                |--------------------------------------------------------------------------
                */

                if ($this->lastDataRow >= 9) {

                    $centerColumns = [

                        'A',

                        'B',

                        'D',

                        'F',

                        'H',

                        'K',

                        'M',

                    ];


                    foreach ($centerColumns as $column) {

                        $sheet
                            ->getStyle(
                                $column .
                                '9:' .
                                $column .
                                $this->lastDataRow
                            )
                            ->getAlignment()
                            ->setHorizontal(
                                Alignment::HORIZONTAL_CENTER
                            )
                            ->setVertical(
                                Alignment::VERTICAL_CENTER
                            );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | 23. FREEZE HEADER
                |--------------------------------------------------------------------------
                |
                | Saat scroll ke bawah, header tabel tetap terlihat.
                |
                */

                $sheet->freezePane('A9');
            },
        ];
    }
}