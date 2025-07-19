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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('kepala_sekolah', 70);
            $table->string('foto_kepala_sekolah', 200);
            $table->text('sambutan_kepala_sekolah');
            $table->text('sejarah');
            $table->text('visi');
            $table->text('misi');
            $table->string('akreditasi', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
