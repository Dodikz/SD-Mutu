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
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_prestasi', ['Akademik', 'Non Akademik']);
            $table->string('nama_prestasi', 50);
            $table->string('keterangan_prestasi', 100);
            $table->string('penyelenggara', 50);
            $table->string('peringkat', 50);
            $table->string('bidang', 50);
            $table->string('gambar_prestasi', 200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasis');
    }
};
