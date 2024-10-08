<?php

namespace Database\Seeders;

use App\Models\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 10 entri rak menggunakan factory
        Rak::factory()->count(10)->create();
    }
}
