<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaDetalle extends Model
{
    protected $table = 'entrega_detalle';
    protected $primaryKey = 'id_entrega_detalle';
    public $timestamps = false;
    protected $fillable = ['id_entrega', 'id_lote', 'cantidad_entregada'];

    public function entrega()
    {
        return $this->belongsTo(Entrega::class, 'id_entrega', 'id_entrega');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote', 'id_lote');
    }
}