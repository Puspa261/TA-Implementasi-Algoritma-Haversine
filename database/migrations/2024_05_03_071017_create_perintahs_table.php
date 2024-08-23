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
        Schema::create('perintahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_surat_tugas')->constrained('surat_tugas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_regu')->constrained('regus')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perintahs');
    }
};