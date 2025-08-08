<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacenes';
    protected $primaryKey = 'id_almacen';
    public $timestamps = false;
    protected $fillable = ['id_sucursal', 'id_tipo_almacen', 'nombre_almacen', 'id_usuario'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_sucursal');
    }

    public function tipo_almacen()
    {
        return $this->belongsTo(TipoAlmacen::class, 'id_tipo_almacen', 'id_tipo_almacen');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_almacen', 'id_almacen');
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'id_almacen', 'id_almacen');
    }

    public function mermas()
    {
        return $this->hasMany(Merma::class, 'id_almacen', 'id_almacen');
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_almacen', 'id_almacen');
    }

    public function solicitudes_origen()
    {
        return $this->hasMany(Solicitud::class, 'id_almacen_origen', 'id_almacen');
    }

    public function solicitudes_destino()
    {
        return $this->hasMany(Solicitud::class, 'id_almacen_destino', 'id_almacen');
    }
}