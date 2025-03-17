<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareCentroMedicoData
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $centroMedico = $user->centroMedico;

            // Definir el layout según el rol del usuario
            $layout = ($user->rol->nombre_rol === 'Administrador Centro Médico')
                ? 'layouts.admin-centro'
                : 'layouts.dashboard';

            // Definir el menú según el rol del usuario
            $menus = $this->getMenusPorRol($user->rol->nombre_rol);

            // Compartir variables globales con todas las vistas
            view()->share([
                'menus' => $menus,
                'nombre_centro' => $centroMedico->nombre ?? 'MediSys',
                'logo_centro' => $centroMedico && $centroMedico->logo
                    ? 'storage/' . $centroMedico->logo
                    : asset('images/logo-medisys.png'), // Logo predeterminado
                'color_tema' => $centroMedico->color_tema ?? '#004643',
                'hover_color' => '#006d62',
                'nombre_usuario' => $user->nombre,
                'layout' => $layout, // Compartir el layout dinámico
            ]);
        }

        return $next($request);
    }

    private function getMenusPorRol($rol)
    {
        switch ($rol) {
            case 'Administrador Global':
                return [
                    ['nombre' => 'Dashboard Global', 'ruta' => 'admin.global.dashboard'],
                    ['nombre' => 'Gestión de Centros Médicos', 'ruta' => 'centros.index'],
                    ['nombre' => 'Gestión de Usuarios Globales', 'ruta' => 'usuarios.index'],
                ];

            case 'Administrador Centro Médico':
                return [
                    ['nombre' => 'Inicio', 'ruta' => 'admin.centro.dashboard'],
                    ['nombre' => 'Configurar Centro Médico', 'ruta' => 'configurar.centro'],
                    ['nombre' => 'Gestión de Roles', 'ruta' => 'roles.index'],
                    ['nombre' => 'Gestión de Permisos', 'ruta' => 'permisos.index'],
                    ['nombre' => 'Gestión de Usuarios', 'ruta' => 'usuarios-centro.index'],
                    ['nombre' => 'Gestión de Personal Médico', 'ruta' => 'personal-medico.index'],
                    ['nombre' => 'Gestión de Trabajadores', 'ruta' => 'trabajadores.index'],
                    ['nombre' => 'Gestión de Pacientes', 'ruta' => 'pacientes.index'],
                    ['nombre' => 'Gestión de Especialidades', 'ruta' => 'especialidad.index'],
                    ['nombre' => 'Gestión de Horarios', 'ruta' => 'horarios.index'],
                    ['nombre' => 'Turnos Disponibles', 'ruta' => 'turnos.disponibles'],
                    ['nombre' => 'Gestión de Caja', 'ruta' => 'modulocaja.index'],
                    ['nombre' => 'Facturación', 'ruta' => 'caja.index'],
                    ['nombre' => 'Gestión de Servicios', 'ruta' => 'servicios.index'],
                    ['nombre' => 'Gestión de Reportes', 'ruta' => 'reportes.index'],
                    ['nombre' => 'Donadores de Sangre', 'ruta' => 'sangre.donadores.index'],
                    ['nombre' => 'Solicitudes de Sangre', 'ruta' => 'sangre.solicitudes.index'],
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Gestión de Alergias', 'ruta' => 'alergias.index'],
                    ['nombre' => 'Diagnósticos', 'ruta' => 'diagnosticos.index'],
                    ['nombre' => 'Gestión de Vacunas', 'ruta' => 'vacunas.index'],
                    ['nombre' => 'Cirugías', 'ruta' => 'cirugias.index'],
                    ['nombre' => 'Recetas y Medicamentos', 'ruta' => 'recetas.index'],
                    ['nombre' => 'Triajes', 'ruta' => 'triajes.index'],
                    ['nombre' => 'Tratamientos', 'ruta' => 'tratamientos.index'],
                    ['nombre' => 'Archivos Adjuntos', 'ruta' => 'archivos.index'],
                ];

            case 'Médico/a':
                return [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Diagnósticos', 'ruta' => 'diagnosticos.index'],
                    ['nombre' => 'Tratamientos', 'ruta' => 'tratamientos.index'],
                    ['nombre' => 'Recetas y Medicamentos', 'ruta' => 'recetas.index'],
                    ['nombre' => 'Cirugías', 'ruta' => 'cirugias.index'],
                    ['nombre' => 'Gestión de Alergias', 'ruta' => 'alergias.index'],
                    ['nombre' => 'Gestión de Vacunas', 'ruta' => 'vacunas.index'],
                ];

            case 'Técnico':
                return [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Archivos Adjuntos', 'ruta' => 'archivos.index'],
                ];

            case 'Enfermero/a':
                return [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Solicitudes de Sangre', 'ruta' => 'sangre.solicitudes.index'],
                    ['nombre' => 'Gestión de Vacunas', 'ruta' => 'vacunas.index'],
                    ['nombre' => 'Triajes', 'ruta' => 'triajes.index'],
                ];

            case 'Personal Administrativo':
                return [
                    ['nombre' => 'Gestión de Pacientes', 'ruta' => 'pacientes.index'],
                    ['nombre' => 'Facturación', 'ruta' => 'caja.index'],
                    ['nombre' => 'Gestión de Servicios', 'ruta' => 'servicios.index'],
                    ['nombre' => 'Gestión de Horarios', 'ruta' => 'horarios.index'],
                    ['nombre' => 'Gestión de Caja', 'ruta' => 'modulocaja.index'],
                    ['nombre' => 'Donadores de Sangre', 'ruta' => 'sangre.donadores.index'],
                    ['nombre' => 'Turnos Disponibles', 'ruta' => 'turnos.disponibles'],
                    ['nombre' => 'Gestión de Usuarios', 'ruta' => 'usuarios-centro.index'],
                ];

            default:
                return [['nombre' => 'Inicio', 'ruta' => 'home']];
        }
    }
}
