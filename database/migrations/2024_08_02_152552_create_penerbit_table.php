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
        Schema::create('penerbit', function (Blueprint $table) {
            $table->string('penerbit_id')->primary()->nullable(false);
            $table->string('penerbit_nama')->nullable(false);
            $table->string('penerbit_alamat')->nullable(false);
            $table->char('penerbit_notelp')->nullable(false);
            $table->string('penerbit_email')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerbit');
    }
};
