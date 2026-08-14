<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rekomendasi_perbaikans', function (Blueprint $table) {
            $table->renameColumn('catatan', 'rekomendasi_catatan');
            $table->renameColumn('gambar', 'rekomendasi_gambar');
            $table->text('perbaikan_catatan')->nullable()->after('rekomendasi_gambar');
            $table->string('perbaikan_gambar')->nullable()->after('perbaikan_catatan');
        });
    }

    public function down(): void
    {
        Schema::table('rekomendasi_perbaikans', function (Blueprint $table) {
            $table->renameColumn('rekomendasi_catatan', 'catatan');
            $table->renameColumn('rekomendasi_gambar', 'gambar');
            $table->dropColumn(['perbaikan_catatan', 'perbaikan_gambar']);
        });
    }
};