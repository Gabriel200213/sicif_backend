<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAlmacen extends Model
{
    protected $table = 'tipos_almacen';
    protected $primaryKey = 'id_tipo_almacen';
    public $timestamps = false;
    protected $fillable = ['nombre_tipo'];

    public function almacenes()
    {
        return $this->hasMany(Almacen::class, 'id_tipo_almacen', 'id_tipo_almacen');
    }
}