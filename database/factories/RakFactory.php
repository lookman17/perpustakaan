<?php

namespace Database\Factories;

use App\Models\Rak;
use Illuminate\Database\Eloquent\Factories\Factory;

class RakFactory extends Factory
{
    protected $model = Rak::class;

    public function definition(): array
    {
        // Generate a random ID for rak_id
        $rak_id = strtoupper(bin2hex(random_bytes(8))); // Generates a random 16-character string

        return [
            'rak_id' => $rak_id,
            'rak_nama' => $this->faker->randomLetter(), // Menghasilkan satu huruf acak
            'rak_lokasi' => 'L-' . $this->faker->numberBetween(1, 10), // Format lokasi seperti L-1, L-2, dst.
            'rak_kapasitas' => $this->faker->randomElement([10, 20, 25, 30, 50]), // Menggunakan nilai spesifik untuk kapasitas
        ];
    }
}
