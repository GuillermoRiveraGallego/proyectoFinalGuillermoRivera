<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factura>
 */
class FacturaFactory extends Factory
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
            'total' => $this->faker->randomFloat(2, 10, 1000),
            'metodo_pago' => $this->faker->randomElement(['tarjeta', 'paypal', 'transferencia']),
            'fecha_pago' => $this->faker->dateTimeThisYear(),
        ];
    }
}
