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
        Schema::create('logo_formulir', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('header_title')->nullable();
            $table->string('logo_left')->nullable(); // path logo kiri
            $table->string('logo_right')->nullable(); // path logo kanan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logo_formulir');
    }
};
