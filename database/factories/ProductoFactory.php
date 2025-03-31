<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'nombre' => $this->faker->unique()->word(),
            'descripcion' => $this->faker->sentence(),
            'precio' => $this->faker->randomFloat(2, 1, 500),
            'imagenes' => json_encode([
                'Imagenes/camisetaEspana.png', // Imagen 1 (frontal)
                'Imagenes/camisetaEspana2.png'  // Imagen 2 (trasera)
            ]),
            'stock' => $this->faker->numberBetween(0, 100),
            'categoria_id' => $this->faker->numberBetween(1, 3),
            'disponible' => $this->faker->boolean(),
        ];
    }
}


