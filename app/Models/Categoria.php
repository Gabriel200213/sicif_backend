<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;
    protected $fillable = ['nombre_categoria', 'id_unidad_medida'];

    public function unidad_medida()
    {
        return $this->belongsTo(UnidadMedida::class, 'id_unidad_medida', 'id_unidad_medida');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}