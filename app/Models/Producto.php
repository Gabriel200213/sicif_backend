<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;
    protected $fillable = ['codigo_unico', 'nombre', 'precio', 'id_categoria', 'id_proveedor'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function compra_detalles()
    {
        return $this->hasMany(CompraDetalle::class, 'id_producto', 'id_producto');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_producto', 'id_producto');
    }

    public function solicitud_detalles()
    {
        return $this->hasMany(SolicitudDetalle::class, 'id_producto', 'id_producto');
    }
}