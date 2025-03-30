<?php

namespace Database\Factories;

use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resena>
 */
class ResenaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'usuario_id' => Usuario::factory(),
            'producto_id' => Producto::factory(),
            'puntuacion' => $this->faker->numberBetween(1, 5),
            'comentario' => $this->faker->sentence(),
        ];
    }
}
