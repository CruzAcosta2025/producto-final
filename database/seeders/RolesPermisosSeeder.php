<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;
use App\Models\Permiso;

class RolesPermisosSeeder extends Seeder
{
    public function run()
    {
        // Permisos para el Administrador Global
        $adminGlobal = Rol::where('nombre_rol', 'Administrador Global')->first();
        $adminGlobal->permisos()->sync(Permiso::all());

        // Permisos para el Administrador del Centro Médico
        $adminCentro = Rol::where('nombre_rol', 'Administrador Centro Médico')->first();
        $adminCentro->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Usuarios', 'Roles', 'Permisos', 'Reportes', 'Configuración General', 'Pacientes', 'Historial Clínico'
        ])->get());

        // Permisos para el Médico/Doctor
        $medico = Rol::where('nombre_rol', 'Médico/Doctor')->first();
        $medico->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Pacientes', 'Historial Clínico', 'Consultas Médicas', 'Recetas Médicas', 'Exámenes Médicos'
        ])->get());

        // Permisos para otros roles
        $enfermero = Rol::where('nombre_rol', 'Enfermero/Enfermera')->first();
        $enfermero->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Pacientes', 'Triaje'
        ])->get());

        $laboratorista = Rol::where('nombre_rol', 'Laboratorista')->first();
        $laboratorista->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Exámenes Médicos'
        ])->get());

        $tecnicoRad = Rol::where('nombre_rol', 'Técnico Radiólogo')->first();
        $tecnicoRad->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Exámenes Médicos'
        ])->get());

        $cajero = Rol::where('nombre_rol', 'Cajero/Personal de Caja')->first();
        $cajero->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Facturación', 'Caja'
        ])->get());

        $adminPersonal = Rol::where('nombre_rol', 'Personal Administrativo')->first();
        $adminPersonal->permisos()->sync(Permiso::whereIn('nombre_modulo', [
            'Pacientes', 'Solicitudes de Sangre', 'Donaciones de Sangre'
        ])->get());
    }
}
