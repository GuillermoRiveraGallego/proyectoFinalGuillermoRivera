<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
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
            'factura_id' => Factura::factory(),
            'estado' => $this->faker->randomElement(['pendiente', 'procesando', 'enviado', 'entregado', 'cancelado']),
            'total' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
