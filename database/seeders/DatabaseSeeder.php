<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estado')->insert([
            ['id_estado' => 1, 'nombre' => 'Activo'],
            ['id_estado' => 2, 'nombre' => 'Inactivo'],
        ]);

        DB::table('unidad_medida')->insert([
            ['id_unidad_medida' => 1, 'nombre' => 'Gramo'],
            ['id_unidad_medida' => 2, 'nombre' => 'Litro'],
        ]);

        DB::table('producto')->insert([
            [
                'id_producto' => 1,
                'nombre' => 'Producto de Ejemplo',
                'descripcion' => 'Descripción del producto',
                'precio' => 10.50,
                'id_unidad_medida' => 1,
                'id_estado' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}