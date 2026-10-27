<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekomendasi_perbaikans', function (Blueprint $table) {
            $table->string('status_persetujuan')
                ->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('catatan_admin')->nullable();
            $table->timestamp('diputuskan_pada')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rekomendasi_perbaikans', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);

            $table->dropColumn([
                'status_persetujuan',
                'approved_by',
                'catatan_admin',
                'diputuskan_pada',
            ]);
        });
    }
};
