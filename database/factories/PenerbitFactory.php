<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penerbit>
 */
class PenerbitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'penerbit_id' => fake()->numerify(),
            'penerbit_nama' => fake()->name(),
            'penerbit_alamat' => fake()->address(),
            'penerbit_notelp' => fake()->phoneNumber(),
            'penerbit_email' => fake()->safeEmail()
        ];
    }
}
