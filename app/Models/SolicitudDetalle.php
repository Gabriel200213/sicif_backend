<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDetalle extends Model
{
    protected $table = 'solicitud_detalle';
    protected $primaryKey = 'id_solicitud_detalle';
    public $timestamps = false;
    protected $fillable = ['id_solicitud', 'id_producto', 'cantidad_solicitada'];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}