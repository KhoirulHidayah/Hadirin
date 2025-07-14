<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id(); // Primary key auto increment
            $table->string('nama');
            $table->string('nip')->unique(); // Unik
            $table->string('jabatan');
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('asal_instansi')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
