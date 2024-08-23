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
        Schema::create('detail_regus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_regu')->constrained('regus')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_jabatan_tugas')->constrained('jabatan_tugas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_pegawai')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_regus');
    }
};
