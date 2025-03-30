<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'precio', 'imagen', 'stock', 'categoria_id', 'disponible'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_productos')->withPivot('cantidad', 'precio_unitario');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

}
