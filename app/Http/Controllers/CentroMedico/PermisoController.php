<?php

namespace App\Http\Controllers\CentroMedico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permiso;
use Illuminate\Support\Facades\Auth;

class PermisoController extends Controller
{
    /**
     * Lista de módulos permitidos y sus tipos de permisos asociados.
     */
    private $modulosPermitidos = [
        'Gestión de Usuarios' => ['crear', 'editar', 'eliminar', 'visualizar'],
        'Gestión de Pacientes' => ['crear', 'editar', 'eliminar', 'visualizar'],
        'Gestión de Donaciones de Sangre' => ['crear', 'editar', 'eliminar', 'visualizar', 'solicitar_donaciones'],
        'Gestión de Historial Clínico' => ['crear', 'editar', 'visualizar'],
        'Gestión de Consultas y Diagnósticos' => [
            'crear',
            'editar',
            'visualizar',
            'crear_diagnosticos',
            'visualizar_diagnosticos'
        ],
        'Gestión de Exámenes Médicos' => [
            'crear',
            'editar',
            'visualizar',
            'subir_archivos_adjuntos',
            'editar_archivos_adjuntos'
        ],
        'Gestión de Tratamientos y Recetas Médicas' => [
            'crear',
            'editar',
            'visualizar',
            'crear_recetas',
            'editar_recetas'
        ],
        'Gestión de Caja' => ['crear', 'editar', 'visualizar', 'eliminar'],
        'Configuración del Centro Médico' => ['configurar_centro', 'gestionar_horarios'],
        'Reportes' => ['generar_reportes', 'visualizar_reportes'],
    ];

    /**
     * Muestra la lista de permisos asociados al centro médico del usuario autenticado.
     */
    public function index()
    {
        $idCentro = Auth::user()->id_centro;
        $permisos = Permiso::where('id_centro', $idCentro)->get();

        return view('admin.centro.permisos.index', compact('permisos'));
    }

    /**
     * Muestra el formulario para crear un nuevo permiso.
     */
    public function create()
    {
        $modulosPermitidos = array_keys($this->modulosPermitidos);

        return view('admin.centro.permisos.create', compact('modulosPermitidos'));
    }

    /**
     * Guarda un nuevo permiso en la base de datos.
     */
    public function store(Request $request)
    {
        $moduloSeleccionado = $request->input('nombre_modulo');
        $tiposPermisos = $this->modulosPermitidos[$moduloSeleccionado] ?? [];

        $request->validate([
            'nombre_modulo' => 'required|in:' . implode(',', array_keys($this->modulosPermitidos)),
            'tipo_permiso' => 'required|in:' . implode(',', $tiposPermisos),
        ]);

        // Verificar si el permiso ya existe para el centro médico actual
        $existePermiso = Permiso::where('id_centro', auth()->user()->id_centro)
            ->where('nombre_modulo', $request->nombre_modulo)
            ->where('tipo_permiso', $request->tipo_permiso)
            ->exists();

        if ($existePermiso) {
            return redirect()->back()->withErrors(['error' => 'Este permiso ya existe en el sistema.']);
        }

        // Crear el nuevo permiso
        Permiso::create([
            'nombre_modulo' => $request->nombre_modulo,
            'tipo_permiso' => $request->tipo_permiso,
            'id_centro' => auth()->user()->id_centro,
        ]);

        return redirect()->route('permisos.index')->with('success', 'Permiso creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un permiso existente.
     */
    public function edit($id)
    {
        $permiso = Permiso::findOrFail($id);

        $modulosPermitidos = array_keys($this->modulosPermitidos);
        $tiposPermisos = $this->modulosPermitidos[$permiso->nombre_modulo] ?? [];

        return view('admin.centro.permisos.edit', compact('permiso', 'modulosPermitidos', 'tiposPermisos'));
    }

    /**
     * Actualiza un permiso existente en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);
        $moduloSeleccionado = $request->input('nombre_modulo');
        $tiposPermisos = $this->modulosPermitidos[$moduloSeleccionado] ?? [];

        $request->validate([
            'nombre_modulo' => 'required|in:' . implode(',', array_keys($this->modulosPermitidos)),
            'tipo_permiso' => 'required|in:' . implode(',', $tiposPermisos),
        ]);

        // Verificar si otro permiso idéntico ya existe para el centro médico
        $existePermiso = Permiso::where('id_centro', auth()->user()->id_centro)
            ->where('nombre_modulo', $request->nombre_modulo)
            ->where('tipo_permiso', $request->tipo_permiso)
            ->where('id_permiso', '!=', $id)
            ->exists();

        if ($existePermiso) {
            return redirect()->back()->withErrors(['error' => 'Otro permiso con estas características ya existe.']);
        }

        // Actualizar el permiso
        $permiso->update([
            'nombre_modulo' => $request->nombre_modulo,
            'tipo_permiso' => $request->tipo_permiso,
        ]);

        return redirect()->route('permisos.index')->with('success', 'Permiso actualizado exitosamente.');
    }

    /**
     * Elimina un permiso de la base de datos.
     */
    public function destroy($id)
    {
        $permiso = Permiso::findOrFail($id);
        $permiso->delete();

        return redirect()->route('permisos.index')->with('success', 'Permiso eliminado exitosamente.');
    }

    /**
     * API interna: Retorna los tipos de permisos disponibles para un módulo específico.
     */
    public function getTiposPermisos(Request $request)
    {
        $modulo = $request->input('nombre_modulo');

        if (array_key_exists($modulo, $this->modulosPermitidos)) {
            return response()->json($this->modulosPermitidos[$modulo]);
        }

        return response()->json([]);
    }
}
