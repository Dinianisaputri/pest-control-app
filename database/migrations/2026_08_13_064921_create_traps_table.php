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
        Schema::create('traps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('no_trap');
            $table->string('type_detector');
            $table->string('spesies_hama');
            $table->string('lokasi');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traps');
    }
};
