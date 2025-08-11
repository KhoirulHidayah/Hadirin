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
        Schema::create('asal_instansi', function (Blueprint $table) {
            $table->id();
            $table->string('asal_instansi')->unique();
            $table->string('kategori_nama'); // Menggunakan nama kategori sebagai kunci
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asal_instansi');
    }
};