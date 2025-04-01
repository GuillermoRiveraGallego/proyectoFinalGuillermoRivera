<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psy\Util\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'nombre_usuario' => $this->faker->unique()->userName,
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'correo' => $this->faker->unique()->safeEmail(),
            'contrasena' => bcrypt('password'), // Contraseña por defecto
            'es_admin' => false,

        ];
    }
}
