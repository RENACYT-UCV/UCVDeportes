<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Entrenador',    'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Atleta',        'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('usuarios')->insert([
            'nombre'           => 'Admin',
            'apellido_paterno' => 'UCVDeportes',
            'apellido_materno' => '',
            'sexo'             => 'M',
            'username'         => 'admin',
            'contraseña'       => Hash::make('Admin1234!'),
            'email'            => 'admin@ucvdeportes.ve',
            'fecha_nacimiento' => '1990-01-01',
            'rol_id'           => 1,
            'campus'           => 'Central',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}
