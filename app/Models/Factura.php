<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = ['usuario_id', 'total', 'metodo_pago', 'fecha_pago'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
