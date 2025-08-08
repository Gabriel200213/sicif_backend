<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursales';
    protected $primaryKey = 'id_sucursal';
    public $timestamps = false;
    protected $fillable = ['nombre_sucursal', 'direccion'];

    public function almacenes()
    {
        return $this->hasMany(Almacen::class, 'id_sucursal', 'id_sucursal');
    }
}