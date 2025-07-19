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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul_berita', 100);
            $table->text('isi_berita');
            $table->string('gambar_berita', 200);
            $table->unsignedBigInteger('penulis_id');
            $table->timestamps();

            $table->foreign('penulis_id')->references('id')->on('akuns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
