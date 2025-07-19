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
        Schema::create('ektras', function (Blueprint $table) {
            $table->id();
            $table->string('judul_ektra', 100);
            $table->text('isi_ektra');
            $table->string('gambar_ektra', 200);
            $table->string('pembina', 50);
            $table->string('hari', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ektras');
    }
};
