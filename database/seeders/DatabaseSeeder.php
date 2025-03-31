<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\pedidoProducto;
use App\Models\Producto;
use App\Models\Resena;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categorias = ['Camisetas', 'Pantalones', 'Zapatillas'];

        foreach ($categorias as $nombre) {
            Categoria::firstOrCreate(
                ['nombre' => $nombre],
                ['descripcion' => 'Categoría de ' . strtolower($nombre)]
            );
        }

        // Seeders normales
        Usuario::factory(10)->create();
        Producto::factory(20)->create();
        Factura::factory(10)->create();
        Pedido::factory(15)->create();
        PedidoProducto::factory(30)->create();
        Resena::factory(50)->create();

    }
}
