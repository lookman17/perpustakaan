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
        Schema::create('penulis', function (Blueprint $table) {
            $table->string('penulis_id', 16)->primary()->nullable(false);
            $table->string('penulis_nama_id', 50)->nullable(false);
            $table->string('penulis_tmptlahir', 15)->nullable(false);
            $table->date('penulis_tgllahir')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penulis');
    }
};
