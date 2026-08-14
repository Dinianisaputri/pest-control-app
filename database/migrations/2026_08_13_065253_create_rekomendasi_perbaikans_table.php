<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('rekomendasi_perbaikans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('entry_id')->constrained()->onDelete('cascade');
        $table->text('catatan')->nullable();
        $table->string('gambar')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_perbaikans');
    }
};
