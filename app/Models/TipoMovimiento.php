<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $table = 'tipos_movimiento';
    protected $primaryKey = 'id_tipo_movimiento';
    public $timestamps = false;
    protected $fillable = ['nombre_movimiento'];

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_tipo_movimiento', 'id_tipo_movimiento');
    }
}