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
        Schema::create('gambar_saranas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sarana_id');
            $table->string('gambar');
            $table->string('judul');
            $table->timestamps();

            $table->foreign('sarana_id')->references('id')->on('saranas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_saranas');
    }
};
