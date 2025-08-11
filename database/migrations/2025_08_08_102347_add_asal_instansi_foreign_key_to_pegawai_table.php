<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            // Drop foreign key lama jika ada (jika Anda pernah membuatnya sebelumnya)
            // $table->dropForeign(['asal_instansi']);

            // Tambahkan foreign key baru dengan onUpdate('cascade')
            $table->foreign('asal_instansi')
                  ->references('asal_instansi')
                  ->on('asal_instansi')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); // Atau 'restrict', 'cascade' sesuai kebutuhan Anda
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['asal_instansi']);
        });
    }
};

