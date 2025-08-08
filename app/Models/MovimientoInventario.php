<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';
    protected $primaryKey = 'id_movimiento';
    public $timestamps = false;
    protected $fillable = ['id_almacen', 'id_lote', 'id_tipo_movimiento', 'cantidad', 'fecha_movimiento', 'id_usuario', 'id_compra', 'id_entrega', 'id_merma'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen', 'id_almacen');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote', 'id_lote');
    }

    public function tipo_movimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento', 'id_tipo_movimiento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compra');
    }

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega', 'id_entrega');
    }

    public function merma()
    {
        return $this->belongsTo(Merma::class, 'id_merma', 'id_merma');
    }
}