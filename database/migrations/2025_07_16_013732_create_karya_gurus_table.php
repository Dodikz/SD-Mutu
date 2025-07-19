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
        Schema::create('karya_gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karya_guru', 50);
            $table->string('foto_karya_guru', 200);
            $table->text('isi_karya');
            $table->unsignedBigInteger('guru_id');
            $table->timestamps();

            $table->foreign('guru_id')->references('id')->on('akuns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_gurus');
    }
};
