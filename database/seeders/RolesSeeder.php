<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['nombre_rol' => 'Administrador Global', 'descripcion' => 'Acceso completo al sistema'],
            ['nombre_rol' => 'Administrador Centro Médico', 'descripcion' => 'Acceso a la gestión de un centro médico específico'],
            ['nombre_rol' => 'Médico/Doctor', 'descripcion' => 'Realiza consultas y gestiona historiales clínicos'],
            ['nombre_rol' => 'Enfermero/Enfermera', 'descripcion' => 'Registra triajes y asiste en procedimientos médicos'],
            ['nombre_rol' => 'Laboratorista', 'descripcion' => 'Realiza y gestiona exámenes de laboratorio'],
            ['nombre_rol' => 'Técnico Radiólogo', 'descripcion' => 'Gestiona estudios de imágenes y radiografías'],
            ['nombre_rol' => 'Personal de Triaje', 'descripcion' => 'Registra signos vitales y datos iniciales del paciente'],
            ['nombre_rol' => 'Cajero/Personal de Caja', 'descripcion' => 'Gestiona facturas y pagos'],
            ['nombre_rol' => 'Personal Administrativo', 'descripcion' => 'Gestión administrativa general y donaciones de sangre']
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
