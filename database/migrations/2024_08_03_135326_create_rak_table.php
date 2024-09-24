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
        Schema::create('rak', function (Blueprint $table) {
            $table->string('rak_id', 16)->primary()->nullable(false);
            $table->string('rak_nama', 20)->nullable(false);
            $table->string('rak_lokasi', 50)->nullable(false);
            $table->integer('rak_kapasitas')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rak');
    }
};
