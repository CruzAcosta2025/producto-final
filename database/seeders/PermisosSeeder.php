<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisosSeeder extends Seeder
{
    public function run()
    {
        $permisos = [
            ['nombre_modulo' => 'Historial Clínico', 'tipo_permiso' => 'Ver'],
            ['nombre_modulo' => 'Historial Clínico', 'tipo_permiso' => 'Editar'],
            ['nombre_modulo' => 'Triaje', 'tipo_permiso' => 'Registrar'],
            ['nombre_modulo' => 'Facturación', 'tipo_permiso' => 'Ver'],
            ['nombre_modulo' => 'Facturación', 'tipo_permiso' => 'Crear'],
            ['nombre_modulo' => 'Exámenes Médicos', 'tipo_permiso' => 'Registrar resultados'],
            ['nombre_modulo' => 'Exámenes Médicos', 'tipo_permiso' => 'Ver'],
            ['nombre_modulo' => 'Donaciones de Sangre', 'tipo_permiso' => 'Gestionar'],
            ['nombre_modulo' => 'Reportes', 'tipo_permiso' => 'Generar'],
            ['nombre_modulo' => 'Pacientes', 'tipo_permiso' => 'Registrar'],
            ['nombre_modulo' => 'Pacientes', 'tipo_permiso' => 'Ver']
        ];

        foreach ($permisos as $permiso) {
            Permiso::create($permiso);
        }
    }
}

