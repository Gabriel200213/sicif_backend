<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'unidades_medida';
    protected $primaryKey = 'id_unidad_medida';
    public $timestamps = false;
    protected $fillable = ['nombre_unidad'];

    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_unidad_medida', 'id_unidad_medida');
    }
}