<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';
    protected $primaryKey = 'id_entrega';
    public $timestamps = false;
    protected $fillable = ['id_solicitud', 'id_usuario_entrega', 'fecha_entrega', 'id_estado'];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    public function usuario_entrega()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_entrega', 'id_usuario');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function detalles()
    {
        return $this->hasMany(EntregaDetalle::class, 'id_entrega', 'id_entrega');
    }
}