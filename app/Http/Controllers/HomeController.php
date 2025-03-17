<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $centroMedico = $user->centroMedico;

        $nombre_usuario = $user->nombre;
        $nombre_centro = $centroMedico->nombre ?? 'Centro Médico';
        $logo_centro = $centroMedico->logo ? 'storage/' . $centroMedico->logo : null;
        $color_tema = $centroMedico->color_tema ?? '#004643';
        $hover_color = '#006d62';

        $menus = [];
        $layout = 'layouts.dashboard'; // Predeterminado para roles distintos a 'Administrador Centro Médico'

        // Menús y layout según el rol
        switch ($user->rol->nombre_rol) {
            case 'Administrador Global':
                $menus = [
                    ['nombre' => 'Dashboard Global', 'ruta' => 'admin.global.dashboard'],
                    ['nombre' => 'Gestión de Centros Médicos', 'ruta' => 'centros.index'],
                    ['nombre' => 'Gestión de Usuarios Globales', 'ruta' => 'usuarios.index'],
                ];
                break;

            case 'Administrador Centro Médico':
                $menus = [
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
                $layout = 'layouts.admin-centro'; // Usar layout para Administrador Centro Médico
                break;

            case 'Médico/a':
                $menus = [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Diagnósticos', 'ruta' => 'diagnosticos.index'],
                    ['nombre' => 'Tratamientos', 'ruta' => 'tratamientos.index'],
                    ['nombre' => 'Recetas y Medicamentos', 'ruta' => 'recetas.index'],
                    ['nombre' => 'Cirugías', 'ruta' => 'cirugias.index'],
                ];
                break;

            case 'Técnico':
                $menus = [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Archivos Adjuntos', 'ruta' => 'archivos.index'],
                ];
                break;

            case 'Enfermero/a':
                $menus = [
                    ['nombre' => 'Historial Clínico', 'ruta' => 'historial.index'],
                    ['nombre' => 'Solicitudes de Sangre', 'ruta' => 'sangre.solicitudes.index'],
                    ['nombre' => 'Vacunas', 'ruta' => 'vacunas.index'],
                    ['nombre' => 'Triajes', 'ruta' => 'triajes.index'],
                ];
                break;

            case 'Personal Administrativo':
                $menus = [
                    ['nombre' => 'Gestión de Pacientes', 'ruta' => 'pacientes.index'],
                    ['nombre' => 'Facturación', 'ruta' => 'caja.index'],
                    ['nombre' => 'Gestión de Servicios', 'ruta' => 'servicios.index'],
                    ['nombre' => 'Gestión de Horarios', 'ruta' => 'horarios.index'],
                    ['nombre' => 'Donadores de Sangre', 'ruta' => 'sangre.donadores.index'],
                    ['nombre' => 'Turnos Disponibles', 'ruta' => 'turnos.disponibles'],
                ];
                break;

            default:
                $menus = [
                    ['nombre' => 'Inicio', 'ruta' => 'home'],
                ];
                break;
        }

        return view('home', compact('menus', 'nombre_usuario', 'nombre_centro', 'logo_centro', 'color_tema', 'hover_color', 'layout'));
    }
}
