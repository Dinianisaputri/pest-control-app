<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekomendasi_approval_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rekomendasi_perbaikan_id')
                ->constrained('rekomendasi_perbaikans')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('aksi');
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_sesudahnya');
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_approval_histories');
    }
};
