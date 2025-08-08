<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
    protected $primaryKey = 'id_lote';
    public $timestamps = false;
    protected $fillable = ['id_producto', 'id_almacen', 'fecha_compra', 'fecha_vencimiento', 'cantidad_inicial', 'cantidad_actual'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen', 'id_almacen');
    }

    public function mermas()
    {
        return $this->hasMany(Merma::class, 'id_lote', 'id_lote');
    }

    public function entrega_detalles()
    {
        return $this->hasMany(EntregaDetalle::class, 'id_lote', 'id_lote');
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_lote', 'id_lote');
    }
}