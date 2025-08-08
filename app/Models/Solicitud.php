<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = false;
    protected $fillable = ['id_almacen_origen', 'id_almacen_destino', 'id_usuario_solicitante', 'fecha_solicitud', 'id_estado'];

    public function almacen_origen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen_origen', 'id_almacen');
    }

    public function almacen_destino()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen_destino', 'id_almacen');
    }

    public function usuario_solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_solicitante', 'id_usuario');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function entregas()
    {
        return $this->hasMany(Entrega::class, 'id_solicitud', 'id_solicitud');
    }

    public function detalles()
    {
        return $this->hasMany(SolicitudDetalle::class, 'id_solicitud', 'id_solicitud');
    }
}