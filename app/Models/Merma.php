<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merma extends Model
{
    protected $table = 'mermas';
    protected $primaryKey = 'id_merma';
    public $timestamps = false;
    protected $fillable = ['id_almacen', 'id_lote', 'id_usuario', 'motivo', 'cantidad_perdida', 'fecha_merma'];

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen', 'id_almacen');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id_lote', 'id_lote');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function movimientos_inventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'id_merma', 'id_merma');
    }
}