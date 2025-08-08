<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'correo',
        'contraseña_hash',
        'id_rol',
        'id_estado',
    ];

    protected $hidden = [
        'contraseña_hash',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña_hash;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function almacenes()
    {
        return $this->hasMany(Almacen::class, 'id_usuario', 'id_usuario');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_usuario', 'id_usuario');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_usuario_entrega', 'id_usuario');
    }

    public function mermas()
    {
        return $this->hasMany(Merma::class, 'id_usuario', 'id_usuario');
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_usuario', 'id_usuario');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_usuario_solicitante', 'id_usuario');
    }
}