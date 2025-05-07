<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBuku;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        KategoriBuku::factory()->count(20)->create();
    }
}
