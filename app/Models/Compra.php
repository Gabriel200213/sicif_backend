<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    public $timestamps = false;
    protected $fillable = ['id_usuario', 'id_proveedor', 'id_almacen', 'fecha_compra', 'total', 'id_estado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen', 'id_almacen');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class, 'id_compra', 'id_compra');
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_compra', 'id_compra');
    }
}