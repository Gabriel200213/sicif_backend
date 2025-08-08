<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $primaryKey = 'id_estado';
    public $timestamps = false;
    protected $fillable = ['nombre_estado'];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_estado', 'id_estado');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_estado', 'id_estado');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_estado', 'id_estado');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_estado', 'id_estado');
    }
}