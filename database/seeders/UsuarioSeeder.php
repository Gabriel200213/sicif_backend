<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        Usuario::create([
            'nombre' => 'Admin',
            'ap_paterno' => 'Sistema',
            'ap_materno' => 'Principal',
            'correo' => 'admin@sicif.com',
            'contraseña_hash' => Hash::make('password123'),
            'id_rol' => 1, // Administrador
            'id_estado' => 1, // Activo
        ]);
    }
}