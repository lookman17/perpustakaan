<?php

namespace Database\Factories;

use App\Models\KategoriBuku;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriBukuFactory extends Factory
{
    protected $model = KategoriBuku::class;

    public function definition(): array
    {
        return [
            'kategori_id' => 'KTG' . $this->faker->unique()->numerify('###'),
            'kategori_nama' => $this->faker->word(),
        ];
    }
}
