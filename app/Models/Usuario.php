<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_usuario', 'nombre', 'apellidos', 'correo', 'contrasena', 'es_admin'
    ];

    protected $hidden = ['contrasena', 'remember_token'];

    // Le indicamos a Laravel que nuestra contraseña se llama 'contrasena'
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
