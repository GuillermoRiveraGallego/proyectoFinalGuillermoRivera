<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $nombres = ['Camisetas', 'Pantalones', 'Zapatillas'];

        return [
            'nombre' => $this->faker->randomElement($nombres),
            'descripcion' => $this->faker->sentence(),
        ];
    }
}
