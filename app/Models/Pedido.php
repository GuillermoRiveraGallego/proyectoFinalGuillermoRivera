<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'factura_id', 'estado', 'total'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    public function productos1()
    {
        return $this->belongsToMany(Producto::class, 'pedido_productos')->withPivot('cantidad', 'precio_unitario');
    }
    public function productos()
    {
        return $this->hasMany(PedidoProducto::class);
    }


}
