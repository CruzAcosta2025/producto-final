<?php

namespace App\Http\Controllers\CentroMedico\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Services\ReniecService;
use App\Http\Controllers\HistorialEliminacionesController; // Agregar esta línea arriba


class PacienteController extends Controller
{

    protected $reniecService;


    public function __construct(ReniecService $reniecService)
    {
        $this->reniecService = $reniecService;
    }
    public function buscarPorDni(Request $request)
    {
        $request->validate([
            'dni' => 'required|digits:8',
        ]);

        $dni = $request->input('dni');
        $datos = $this->reniecService->consultarDni($dni);

        if (!$datos || isset($datos['error'])) {
            return response()->json(['error' => 'DNI no encontrado.'], 404);
        }

        return response()->json([
            'dni' => $datos['numeroDocumento'],
            'primer_nombre' => $datos['nombres'], // Ahora todo el nombre en un solo campo
            'primer_apellido' => $datos['apellidoPaterno'],
            'segundo_apellido' => $datos['apellidoMaterno'],
        ], 200);
    }


    // Listar pacientes del centro médico del usuario autenticado
    public function index()
    {
        $pacientes = Paciente::where('id_centro', Auth::user()->id_centro)->get();
        return view('admin.centro.paciente.index', compact('pacientes'));
    }

    // Mostrar formulario de creación de paciente
    public function create()
    {
        return view('admin.centro.paciente.create');
    }

    // Almacenar un nuevo paciente
    public function store(Request $request)
    {
        $this->validatePaciente($request);

        // Crear el paciente con los datos validados
        Paciente::create([
            'id_centro' => Auth::user()->id_centro,
            'primer_nombre' => $request->primer_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'grupo_sanguineo' => $request->grupo_sanguineo,
            'nombre_contacto_emergencia' => $request->nombre_contacto_emergencia,
            'telefono_contacto_emergencia' => $request->telefono_contacto_emergencia,
            'relacion_contacto_emergencia' => $request->relacion_contacto_emergencia,

        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente.');
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $paciente = Paciente::where('id_centro', Auth::user()->id_centro)->findOrFail($id);
        return view('admin.centro.paciente.edit', compact('paciente'));
    }

    // Actualizar datos de un paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::where('id_centro', Auth::user()->id_centro)->findOrFail($id);

        // Validación y actualización de los datos del paciente
        $this->validatePaciente($request, $paciente);

        $paciente->update([
            'primer_nombre' => $request->primer_nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'dni' => $request->dni,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'grupo_sanguineo' => $request->grupo_sanguineo,
            'nombre_contacto_emergencia' => $request->nombre_contacto_emergencia,
            'telefono_contacto_emergencia' => $request->telefono_contacto_emergencia,
            'relacion_contacto_emergencia' => $request->relacion_contacto_emergencia,
            'es_donador' => $request->es_donador,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
    }




    // Validación común para creación y edición de pacientes
    private function validatePaciente(Request $request, $paciente = null)
    {
        $uniqueDni = 'unique:pacientes,dni' . ($paciente ? ',' . $paciente->id_paciente . ',id_paciente' : '');
        $uniqueEmail = 'unique:pacientes,email' . ($paciente ? ',' . $paciente->id_paciente . ',id_paciente' : '');

        $request->validate([
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'required|date',

            'dni' => ['required', 'string', 'max:20', $uniqueDni],
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'email' => ['nullable', 'email', 'max:100', $uniqueEmail],
            'grupo_sanguineo' => 'required|string|max:5',
            'nombre_contacto_emergencia' => 'nullable|string|max:191',
            'telefono_contacto_emergencia' => 'nullable|string|max:20',
            'relacion_contacto_emergencia' => 'nullable|string|max:50',

        ]);
    }

    public function destroy($id)
    {
        $paciente = Paciente::where('id_centro', Auth::user()->id_centro)
            ->with([
                'historialClinico.anamnesis',
                'historialClinico.diagnostico',
                'historialClinico.recetas',
                'historialClinico.examenesMedicos',
                'historialClinico.consultas',
                'historialClinico.cirugias',
                'historialClinico.tratamientos',
                'historialClinico.alergias',
                'historialClinico.vacunas'
            ])
            ->findOrFail($id);

        // Inicializar detalles de eliminación
        $detalles = [
            "DNI: {$paciente->dni}",
        ];

        // Recorrer historial clínico
        foreach ($paciente->historialClinico as $historial) {
            // Eliminar anamnesis
            if ($historial->anamnesis) {
                foreach ($historial->anamnesis as $anamnesis) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Anamnesis',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Detalle: " . ($anamnesis->descripcion ?: "No especificado")
                    );
                    $anamnesis->delete();
                }
                $detalles[] = "Anamnesis eliminados: " . $historial->anamnesis->count();
            }

            // Eliminar diagnósticos
            if ($historial->diagnosticos) {
                foreach ($historial->diagnosticos as $diagnostico) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Diagnóstico',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Enfermedad: " . ($diagnostico->descripcion ?: "Sin especificar") .
                            ", Observaciones: " . ($diagnostico->observaciones ?: "Sin observaciones")
                    );
                    $diagnostico->delete();
                }
                $detalles[] = "Diagnósticos eliminados: " . $historial->diagnosticos->count();
            }

            // Eliminar recetas
            if ($historial->recetas) {
                foreach ($historial->recetas as $receta) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Receta',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Fecha: " . ($receta->fecha_receta ?: "No registrada")
                    );
                    $receta->delete();
                }
                $detalles[] = "Recetas eliminadas: " . $historial->recetas->count();
            }

            // Eliminar exámenes médicos
            if ($historial->examenesMedicos) {
                foreach ($historial->examenesMedicos as $examen) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Examen Médico',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Tipo: " . ($examen->tipo_examen ?: "No especificado") .
                            ", Resultado: " . ($examen->resultados ?: "No especificado")
                    );
                    $examen->delete();
                }
                $detalles[] = "Exámenes médicos eliminados: " . $historial->examenesMedicos->count();
            }

            // Eliminar consultas
            if ($historial->consultas) {
                foreach ($historial->consultas as $consulta) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Consulta',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Fecha: " . ($consulta->fecha_consulta ?: "No registrada") .
                            ", Motivo: " . ($consulta->motivo_consulta ?: "No especificado")
                    );
                    $consulta->delete();
                }
                $detalles[] = "Consultas eliminadas: " . $historial->consultas->count();
            }

            // Eliminar cirugías
            if ($historial->cirugias) {
                foreach ($historial->cirugias as $cirugia) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Cirugía',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Tipo: " . ($cirugia->tipo_cirugia ?: "No especificado") .
                            ", Cirujano: " . ($cirugia->cirujano ?: "No especificado")
                    );
                    $cirugia->delete();
                }
                $detalles[] = "Cirugías eliminadas: " . $historial->cirugias->count();
            }

            // Eliminar tratamientos
            if ($historial->tratamientos) {
                foreach ($historial->tratamientos as $tratamiento) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Tratamiento',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Descripción: " . ($tratamiento->descripcion ?: "No especificado")
                    );
                    $tratamiento->delete();
                }
                $detalles[] = "Tratamientos eliminados: " . $historial->tratamientos->count();
            }

            // Eliminar alergias
            if ($historial->alergias) {
                foreach ($historial->alergias as $alergia) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Alergia',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Tipo: " . ($alergia->tipo ?: "No especificado") .
                            ", Severidad: " . ($alergia->severidad ?: "No especificado")
                    );
                    $alergia->delete();
                }
                $detalles[] = "Alergias eliminadas: " . $historial->alergias->count();
            }

            // Eliminar vacunas
            if ($historial->vacunas) {
                foreach ($historial->vacunas as $vacuna) {
                    HistorialEliminacionesController::registrarEliminacion(
                        'Vacuna',
                        "Paciente: {$paciente->primer_nombre} {$paciente->primer_apellido}",
                        "Nombre: " . ($vacuna->nombre_vacuna ?: "No especificado") .
                            ", Fecha: " . ($vacuna->fecha_aplicacion ?: "No registrada")
                    );
                    $vacuna->delete();
                }
                $detalles[] = "Vacunas eliminadas: " . $historial->vacunas->count();
            }
        }

        // Registrar eliminación del paciente con detalles
        HistorialEliminacionesController::registrarEliminacion(
            'Paciente',
            "{$paciente->primer_nombre} {$paciente->primer_apellido}",
            implode(" | ", $detalles) // Convertir array en texto
        );

        // Eliminar el paciente
        $paciente->delete();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
