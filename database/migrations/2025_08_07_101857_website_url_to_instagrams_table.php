<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instagrams', function (Blueprint $table) {
            // Menambahkan kolom 'website_url' setelah kolom 'instagram_username'
            // Kolom ini bersifat nullable, jadi tidak wajib diisi
            $table->string('website_url')->nullable()->after('instagram_username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instagrams', function (Blueprint $table) {
            // Menghapus kolom 'website_url' jika rollback
            $table->dropColumn('website_url');
        });
    }
};
