<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->text('descripcion');
            $table->decimal('precio', 10, 2)->unsigned();
            $table->json('imagenes')->nullable();
            $table->integer('stock')->default(0); // Control de inventario
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null'); // Relación con categorías
            $table->boolean('disponible')->default(true); // Para activar/desactivar productos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
