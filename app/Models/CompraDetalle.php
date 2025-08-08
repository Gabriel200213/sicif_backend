<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraDetalle extends Model
{
    protected $table = 'compra_detalle';
    protected $primaryKey = 'id_compra_detalle';
    public $timestamps = false;
    protected $fillable = ['id_compra', 'id_producto', 'cantidad', 'precio_unitario', 'subtotal'];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'id_compra', 'id_compra');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}