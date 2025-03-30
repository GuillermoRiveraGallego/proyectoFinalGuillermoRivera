<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; // Laravel espera "users", así que lo especificamos.

    protected $fillable = [
        'nombre_usuario', 'nombre', 'apellidos', 'password', 'correo', 'es_admin', 'foto_perfil'
    ];

    protected $hidden = ['password', 'remember_token'];

    // Un usuario puede tener muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    // Un usuario puede tener muchas reseñas
    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    // Un usuario puede tener muchas facturas
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
