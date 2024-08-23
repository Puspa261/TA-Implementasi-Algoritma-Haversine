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
        Schema::create('pengaduan_masyarakats', function (Blueprint $table) {
            $table->id();
            // $table->string('date');
            $table->string('name');
            $table->string('phone');
            $table->string('jenis');
            $table->string('image');
            $table->string('message');
            $table->string('detail');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->boolean('status');
            $table->foreignId('id_pegawai')->nullable()->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('ip');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_masyarakats');
    }
};
