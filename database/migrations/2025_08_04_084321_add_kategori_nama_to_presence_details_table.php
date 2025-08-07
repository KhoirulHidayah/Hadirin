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
        Schema::table('presence_details', function (Blueprint $table) {
            // Add 'kategori_nama' column after 'asal_instansi'
            // This column will store the name of the category from the 'kategori' table.
            $table->string('kategori')->nullable()->after('asal_instansi');

            // You might consider adding an index for better query performance if you frequently filter by this column.
            // $table->index('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presence_details', function (Blueprint $table) {
            // Drop the 'kategori' column if the migration is rolled back
            $table->dropColumn('kategori');
        });
    }
};