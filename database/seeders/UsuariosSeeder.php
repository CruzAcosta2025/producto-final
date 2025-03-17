<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\CentroMedico;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        $centros = CentroMedico::all();

        foreach ($centros as $index => $centro) {
            // Crear un administrador para cada centro
            $rolAdminCentro = Rol::where('nombre_rol', 'Administrador Centro Médico')->first();

            Usuario::create([
                'nombre' => 'Admin Centro ' . ($index + 1),
                'email' => 'admin_centro' . ($index + 1) . '@example.com',
                'password' => bcrypt('password'),
                'id_rol' => $rolAdminCentro->id_rol,
                'id_centro' => $centro->id_centro,
                'estado' => 'ACTIVO'
            ]);

            // Crear usuarios adicionales para cada centro
            $roles = Rol::whereNotIn('nombre_rol', ['Administrador Global', 'Administrador Centro Médico'])->get();
            foreach ($roles as $rol) {
                Usuario::create([
                    'nombre' => 'Usuario ' . $rol->nombre_rol . ' Centro ' . ($index + 1),
                    'email' => strtolower(str_replace(' ', '_', $rol->nombre_rol)) . '_centro' . ($index + 1) . '@example.com',
                    'password' => bcrypt('password'),
                    'id_rol' => $rol->id_rol,
                    'id_centro' => $centro->id_centro,
                    'estado' => 'ACTIVO'
                ]);
            }
        }

        // Crear un Administrador Global sin centro asignado
        $rolAdminGlobal = Rol::where('nombre_rol', 'Administrador Global')->first();
        Usuario::create([
            'nombre' => 'Admin Global',
            'email' => 'admin_global@example.com',
            'password' => bcrypt('password'),
            'id_rol' => $rolAdminGlobal->id_rol,
            'id_centro' => null,
            'estado' => 'ACTIVO'
        ]);
    }
}
