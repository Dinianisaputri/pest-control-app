<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrapSeeder extends Seeder
{
    public function run(): void
    {
        $traps = [];

        // P. LALAT
        $pLalat = [
            ['nums' => ['10', '11'], 'lokasi' => 'Halaman Depan'],
            ['nums' => ['1', '2'], 'lokasi' => 'Penerimaan Surimi'],
            ['nums' => ['5', '4'], 'lokasi' => 'Penerimaan FM'],
            ['nums' => ['7'], 'lokasi' => 'Halaman Timur FM'],
            ['nums' => ['6', '8'], 'lokasi' => 'TPS'],
            ['nums' => ['9'], 'lokasi' => 'Taman'],
        ];

        foreach ($pLalat as $group) {
            foreach ($group['nums'] as $no) {
                $traps[] = [
                    'no_trap' => str_pad($no, 2, '0', STR_PAD_LEFT),
                    'type_detector' => 'P. Lalat',
                    'spesies_hama' => 'Lalat',
                    'lokasi' => $group['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        // P. Kucing
        $pKucing = [
            ['nums' => ['1'], 'lokasi' => 'PN FF'],
        ];

        foreach ($pKucing as $group) {
            foreach ($group['nums'] as $no) {
                $traps[] = [
                    'no_trap' => str_pad($no, 2, '0', STR_PAD_LEFT),
                    'type_detector' => 'P. Kucing',
                    'spesies_hama' => 'Kucing',
                    'lokasi' => $group['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insect Light
        $InsectLight = [
            ['nums' => ['5'], 'lokasi' => 'Loker Laki-Laki'],
            ['nums' => ['3'], 'lokasi' => 'Penerimaan Surimi'],
            ['nums' => ['4'], 'lokasi' => 'Penerimaan FF'],
            ['nums' => ['6'], 'lokasi' => 'Ruang Proses FF'],
            ['nums' => ['7'], 'lokasi' => 'Ruang Packing FF'],
            ['nums' => ['1'], 'lokasi' => 'Packing Surimi'],
            ['nums' => ['2'], 'lokasi' => 'Ruang Proses Surimi Mesin 6'],
            ['nums' => ['8','9'], 'lokasi' => 'R. PK'],
            ['nums' => ['10'], 'lokasi' => 'R. Proses FM'],
            ['nums' => ['11'], 'lokasi' => 'Packing FM'],
            ['nums' => ['12'], 'lokasi' => 'FO Fish Oil'],
        ];

        foreach ($InsectLight as $group) {
            foreach ($group['nums'] as $no) {
                $traps[] = [
                    'no_trap' => str_pad($no, 2, '0', STR_PAD_LEFT),
                    'type_detector' => 'Insect Light',
                    'spesies_hama' => 'Lalat',
                    'lokasi' => $group['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        // Rodent Baint Stat
        $rodentBaintStat = [
            ['nums' => ['1', '2'], 'lokasi' => 'Lobby'],
            ['nums' => ['3', '4'], 'lokasi' => 'Dapur'],
            ['nums' => ['41', '42'], 'lokasi' => 'Kantor Lt 2'],
            ['nums' => ['5', '6'], 'lokasi' => 'Antoroom'],
            ['nums' => ['7', '8', '9', '10', '11'], 'lokasi' => 'Proses FF'],
            ['nums' => ['45', '46'], 'lokasi' => 'Packing FF'],
            ['nums' => ['12'], 'lokasi' => 'Loker Wanita'],
            ['nums' => ['13'], 'lokasi' => 'Loker Laki-laki'],
            ['nums' => ['14', '15', '16', '17', '18', '19', '20', '34', '35', '36'], 'lokasi' => 'Gudang NBB'],
            ['nums' => ['21', '22'], 'lokasi' => 'Stufing FM'],
            ['nums' => ['23', '24'], 'lokasi' => 'Gudang FM'],
            ['nums' => ['37', '38'], 'lokasi' => 'Gudang FO'],
            ['nums' => ['39'], 'lokasi' => 'Chili Room'],
            ['nums' => ['25', '26', '44', '27'], 'lokasi' => 'Packing FM'],
            ['nums' => ['28', '29'], 'lokasi' => 'Proses FM'],
            ['nums' => ['40', '4'], 'lokasi' => 'Panel Boiler FM'],
            ['nums' => ['30', '31', '32'], 'lokasi' => 'R. Proses Surimi'],
            ['nums' => ['33'], 'lokasi' => 'Water Chiller 1'],
        ];

        foreach ($rodentBaintStat as $group) {
            foreach ($group['nums'] as $no) {
                $traps[] = [
                    'no_trap' => str_pad($no, 2, '0', STR_PAD_LEFT),
                    'type_detector' => 'Rodent Baint Stat',
                    'spesies_hama' => 'Tikus',
                    'lokasi' => $group['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Rodent Baint Stat Box
        $rodentBaintStatBox = [
            ['nums' => ['1', '2'], 'lokasi' => 'Halaman Depan'],
            ['nums' => ['3', '4', '5'], 'lokasi' => 'Halaman Timur'],
            ['nums' => ['6'], 'lokasi' => 'Halaman Penerimaan'],
            ['nums' => ['7', '14'], 'lokasi' => 'Halaman Barat'],
            ['nums' => ['8', '12', '13'], 'lokasi' => 'Halaman Depan FM'],
            ['nums' => ['9'], 'lokasi' => 'P. Karyawan'],
            ['nums' => ['10', '11', '15'], 'lokasi' => 'Halaman Belakang FM'],
            ['nums' => ['16'], 'lokasi' => 'Ruang Istirahat FM'],
        ];

        foreach ($rodentBaintStatBox as $group) {
            foreach ($group['nums'] as $no) {
                $traps[] = [
                    'no_trap' => str_pad($no, 2, '0', STR_PAD_LEFT),
                    'type_detector' => 'Rodent Baint Stat Box',
                    'spesies_hama' => 'Tikus',
                    'lokasi' => $group['lokasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('traps')->insert($traps);   // <-- INI YANG KELUPAAN
    }
}