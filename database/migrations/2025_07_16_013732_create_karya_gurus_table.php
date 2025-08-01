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
            $table->string('slug')->unique();
            $table->string('foto_karya_guru', 200);
            $table->text('isi_karya');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

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
