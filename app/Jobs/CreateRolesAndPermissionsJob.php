<?php

namespace App\Jobs;

use App\Models\Rol;
use App\Models\Permiso;
use App\Models\RolPermiso;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateRolesAndPermissionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $centroMedicoId;

    /**
     * Create a new job instance.
     *
     * @param int $centroMedicoId
     */
    public function __construct($centroMedicoId)
    {
        $this->centroMedicoId = $centroMedicoId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $roles = [
            'Administrador Centro Médico',
            'Médico/a',
            'Técnico',
            'Enfermero/a',
            'Personal Administrativo'
        ];

        $permisos = [
            // Gestión de Usuarios
            ['nombre_modulo' => 'usuarios', 'tipo_permiso' => 'crear_usuarios'],
            ['nombre_modulo' => 'usuarios', 'tipo_permiso' => 'editar_usuarios'],
            ['nombre_modulo' => 'usuarios', 'tipo_permiso' => 'eliminar_usuarios'],
            ['nombre_modulo' => 'usuarios', 'tipo_permiso' => 'visualizar_usuarios'],

            // Gestión de Pacientes
            ['nombre_modulo' => 'pacientes', 'tipo_permiso' => 'crear_pacientes'],
            ['nombre_modulo' => 'pacientes', 'tipo_permiso' => 'editar_pacientes'],
            ['nombre_modulo' => 'pacientes', 'tipo_permiso' => 'eliminar_pacientes'],
            ['nombre_modulo' => 'pacientes', 'tipo_permiso' => 'visualizar_pacientes'],

            // Gestión de Donaciones de Sangre
            ['nombre_modulo' => 'donaciones', 'tipo_permiso' => 'crear_donadores'],
            ['nombre_modulo' => 'donaciones', 'tipo_permiso' => 'editar_donadores'],
            ['nombre_modulo' => 'donaciones', 'tipo_permiso' => 'eliminar_donadores'],
            ['nombre_modulo' => 'donaciones', 'tipo_permiso' => 'visualizar_donadores'],
            ['nombre_modulo' => 'donaciones', 'tipo_permiso' => 'solicitar_donaciones'],

            // Gestión de Historial Clínico
            ['nombre_modulo' => 'historial', 'tipo_permiso' => 'crear_historial'],
            ['nombre_modulo' => 'historial', 'tipo_permiso' => 'editar_historial'],
            ['nombre_modulo' => 'historial', 'tipo_permiso' => 'visualizar_historial'],

            // Gestión de Consultas y Diagnósticos
            ['nombre_modulo' => 'consultas', 'tipo_permiso' => 'crear_consultas'],
            ['nombre_modulo' => 'consultas', 'tipo_permiso' => 'editar_consultas'],
            ['nombre_modulo' => 'consultas', 'tipo_permiso' => 'visualizar_consultas'],
            ['nombre_modulo' => 'diagnosticos', 'tipo_permiso' => 'crear_diagnosticos'],
            ['nombre_modulo' => 'diagnosticos', 'tipo_permiso' => 'visualizar_diagnosticos'],

            // Gestión de Exámenes Médicos
            ['nombre_modulo' => 'examenes', 'tipo_permiso' => 'crear_examenes'],
            ['nombre_modulo' => 'examenes', 'tipo_permiso' => 'editar_examenes'],
            ['nombre_modulo' => 'examenes', 'tipo_permiso' => 'visualizar_examenes'],
            ['nombre_modulo' => 'archivos', 'tipo_permiso' => 'subir_archivos_adjuntos'],
            ['nombre_modulo' => 'archivos', 'tipo_permiso' => 'editar_archivos_adjuntos'],

            // Gestión de Tratamientos y Recetas
            ['nombre_modulo' => 'tratamientos', 'tipo_permiso' => 'crear_tratamientos'],
            ['nombre_modulo' => 'tratamientos', 'tipo_permiso' => 'editar_tratamientos'],
            ['nombre_modulo' => 'tratamientos', 'tipo_permiso' => 'visualizar_tratamientos'],
            ['nombre_modulo' => 'recetas', 'tipo_permiso' => 'crear_recetas'],
            ['nombre_modulo' => 'recetas', 'tipo_permiso' => 'editar_recetas'],
            ['nombre_modulo' => 'recetas', 'tipo_permiso' => 'visualizar_recetas'],

            // Gestión de Caja
            ['nombre_modulo' => 'caja', 'tipo_permiso' => 'crear_facturas'],
            ['nombre_modulo' => 'caja', 'tipo_permiso' => 'editar_facturas'],
            ['nombre_modulo' => 'caja', 'tipo_permiso' => 'visualizar_facturas'],
            ['nombre_modulo' => 'caja', 'tipo_permiso' => 'eliminar_facturas'],

            // Configuración del Centro Médico
            ['nombre_modulo' => 'configuracion', 'tipo_permiso' => 'configurar_centro'],
            ['nombre_modulo' => 'configuracion', 'tipo_permiso' => 'gestionar_horarios'],

            // Reportes
            ['nombre_modulo' => 'reportes', 'tipo_permiso' => 'generar_reportes'],
            ['nombre_modulo' => 'reportes', 'tipo_permiso' => 'visualizar_reportes']
        ];

        foreach ($roles as $rol) {
            $nuevoRol = Rol::firstOrCreate([
                'nombre_rol' => $rol,
                'descripcion' => "$rol del centro médico",
                'id_centro' => $this->centroMedicoId,
            ]);

            foreach ($permisos as $permiso) {
                $nuevoPermiso = Permiso::firstOrCreate([
                    'nombre_modulo' => $permiso['nombre_modulo'],
                    'tipo_permiso' => $permiso['tipo_permiso'],
                    'id_centro' => $this->centroMedicoId,
                ]);

                RolPermiso::firstOrCreate([
                    'id_rol' => $nuevoRol->id_rol,
                    'id_permiso' => $nuevoPermiso->id_permiso,
                ]);
            }
        }
    }
}
